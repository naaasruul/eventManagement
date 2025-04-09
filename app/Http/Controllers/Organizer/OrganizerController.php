<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;
use App\Mail\ReminderMail;
use League\Csv\Reader;

class OrganizerController extends Controller
{
    public function index()
{
    $organizerId = auth()->id();

    // Fetch events created by the organizer
    $events = Event::where('created_by', $organizerId)->get();

    // Count RSVP statuses
    $acceptedRSVPs = Invitation::whereIn('event_id', $events->pluck('id'))->where('rsvp_status', 'accepted')->count();
    $declinedRSVPs = Invitation::whereIn('event_id', $events->pluck('id'))->where('rsvp_status', 'declined')->count();
    $pendingRSVPs = Invitation::whereIn('event_id', $events->pluck('id'))->where('rsvp_status', 'pending')->count();

    // Fetch attendee counts for each event, excluding declined RSVPs
    $eventNames = $events->pluck('name');
    $attendeeCounts = $events->map(function ($event) {
        return $event->invitations()->where('rsvp_status', '!=', 'declined')->count();
    });

    return view('organizer.dashboard', compact(
        'events',
        'acceptedRSVPs',
        'declinedRSVPs',
        'pendingRSVPs',
        'eventNames',
        'attendeeCounts'
    ));
}

    public function viewEvents(Request $request)
    {
        // Fetch all events created by the logged-in organizer
        $query = Event::where('created_by', auth()->id());

        // Search functionality
        if ($request->has('search') && $request->search !== null) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
        }

        // Filter by status
        if ($request->has('status') && $request->status !== null) {
            $query->where('status', $request->status);
        }

        // Paginate results
        $events = $query->paginate(10);

        return view('organizer.my-events', compact('events'));
    }

    public function createEvent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date_start' => 'required|date',
            'time_start' => 'required',
            'date_end' => 'required|date|after_or_equal:date_start',
            'time_end' => 'required',
        ]);
        // Combine date and time for comparison
        $startDateTime = strtotime($request->date_start . ' ' . $request->time_start);
        $endDateTime = strtotime($request->date_end . ' ' . $request->time_end);

        if ($startDateTime >= $endDateTime) {
            return redirect()->back()->withInput()->withErrors([
                'date_start' => 'The start date and time must be earlier than the end date and time.',
            ]);
        }
        Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'date_start' => $request->date_start,
            'time_start' => $request->time_start,
            'date_end' => $request->date_end,
            'time_end' => $request->time_end,
            'status' => 'pending',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('organizer.dashboard')->with('success', 'Event created successfully and sent for approval.');
    }

    public function manageInvitations($id)
    {
        $event = Event::findOrFail($id);
        $invitations = Invitation::where('event_id', $id)->get();
        return view('organizer.invitations', compact('event', 'invitations'));
    }

    public function sendInvitations(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Convert the comma-separated string of emails into an array
        $email = $request->attendee_email;
        // Generate a unique RSVP link identifier
        $rsvpLink = uniqid();
        $invitation = Invitation::create([
            'event_id' => $id,
            'attendee_email' => $request->attendee_email,
            'rsvp_status' => 'pending',
            'rsvp_link' => $rsvpLink,
            'seat_type' => $request->seat_type,
            'seat_number' => $request->seat_type !== 'General' ? $request->seat_number : null,
        ]);

        // Send email
        Mail::to($email)->send(new InvitationMail($invitation));

        return redirect()->back()->with('success', 'Invitations sent successfully.');
    }

    public function sendReminders($id)
    {
        $invitations = Invitation::where('event_id', $id)->where('rsvp_status', 'pending')->get();

        foreach ($invitations as $invitation) {
            // Send reminder email
            Mail::to($invitation->attendee_email)->send(new ReminderMail($invitation));
        }

        return redirect()->back()->with('success', 'Reminders sent successfully.');
    }

    public function assignSeating($id)
    {
        $event = Event::findOrFail($id);
        $invitations = Invitation::where('event_id', $id)->get();
        return view('organizer.seating', compact('event', 'invitations'));
    }

    public function saveSeating(Request $request, $id)
    {
        foreach ($request->seating as $invitationId => $seatType) {
            $invitation = Invitation::findOrFail($invitationId);
            $invitation->update(['seat_type' => $seatType]);
        }

        return redirect()->back()->with('success', 'Seating assignments saved successfully.');
    }

    public function checkAndSendReminders()
    {
        // Use a static date for testing
        // $currentDate = now(); // Real logic
        $currentDate = now()->create(2025, 4, 8); // Static date for testing
    
        $nextDay = $currentDate->copy()->addDay()->toDateString();
    
        // Fetch events starting tomorrow
        $events = Event::whereDate('date_start', $nextDay)->get();
    
        $eventsWithReminders = [];
    
        foreach ($events as $event) {
            // Fetch pending invitations for the event
            $invitations = Invitation::where('event_id', $event->id)
                ->where('rsvp_status', 'pending')
                ->get();
    
            foreach ($invitations as $invitation) {
                // Send reminder email
                Mail::to($invitation->attendee_email)->send(new ReminderMail($invitation));
            }
    
            if ($invitations->count() > 0) {
                $eventsWithReminders[] = $event->name;
            }
        }
    
        return response()->json([
            'success' => true,
            'events' => $eventsWithReminders,
        ]);
    }

    public function uploadInvitations(Request $request, $id)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $event = Event::findOrFail($id);

        $file = $request->file('csv_file');
        $invitations = [];

        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
            // Read the CSV file line by line
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $email = trim($data[0]);
                $seatType = $data[1] ?? 'General'; // Default to 'General' if not provided
                $seatNumber = $data[2] ?? null;

                // Validate email
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    // Avoid duplicate invitations
                    $invitation = Invitation::firstOrCreate(
                        [
                            'event_id' => $event->id,
                            'attendee_email' => $email,
                        ],
                        [
                            'rsvp_status' => 'pending',
                            'rsvp_link' => uniqid(),
                            'seat_type' => $seatType,
                            'seat_number' => $seatType !== 'General' ? $seatNumber : null,
                        ]
                    );

                    $invitations[] = $invitation;

                    // Send the invitation email
                    Mail::to($email)->send(new InvitationMail($invitation));
                }
            }
            fclose($handle);
        }

        return redirect()->back()->with('success', count($invitations) . ' invitations imported and emails sent successfully.');
    }

}
