<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Fetch statistics
        $totalEvents = Event::count();
        $pendingEvents = Event::where('status', 'pending')->count();
        $approvedEvents = Event::where('status', 'approved')->count();
        $rejectedEvents = Event::where('status', 'rejected')->count();
        $totalOrganizers = User::where('role', 'organizer')->count();

        // Organizer activity data
        $organizers = User::where('role', 'organizer')->get();
        $organizerNames = $organizers->pluck('name');
        $organizerEventCounts = $organizers->map(function ($organizer) {
            return $organizer->events()->count();
        });

        return view('admin.dashboard', compact(
            'totalEvents',
            'pendingEvents',
            'approvedEvents',
            'rejectedEvents',
            'totalOrganizers',
            'organizerNames',
            'organizerEventCounts',
            
        ));
    }

    public function viewEvents(Request $request)
    {
        $query = Event::with('organizer');

        // Search functionality
        if ($request->has('search') && $request->search !== null) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhereHas('organizer', function ($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== null) {
            $query->where('status', $request->status);
        }

        // Paginate results
        $events = $query->paginate(10);

        return view('admin.events', compact('events'));
    }

    public function approveEvent($id)
    {
        // Approve the event
        $event = Event::findOrFail($id);
        $event->status = 'approved';
        $event->save();

        return redirect()->route('admin.events')->with('success', 'Event approved successfully.');
    }

    public function rejectEvent($id)
    {
        // Reject the event
        $event = Event::findOrFail($id);
        $event->status = 'rejected';
        $event->save();

        return redirect()->route('admin.events')->with('success', 'Event rejected successfully.');
    }

    public function viewOrganizers(Request $request)
    {
        $query = User::where('role', 'organizer');

        // Search functionality
        if ($request->has('search') && $request->search !== null) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $organizers = $query->paginate(10);

        return view('admin.organizers', compact('organizers'));
    }

    public function addOrganizer(Request $request)
    {
        // Add a new organizer
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'organizer',
        ]);

        return redirect()->route('admin.organizers')->with('success', 'Organizer added successfully.');
    }

    public function removeOrganizer($id)
    {
        // Remove an organizer
        $organizer = User::findOrFail($id);
        $organizer->delete();

        return redirect()->route('admin.organizers')->with('success', 'Organizer removed successfully.');
    }

    public function editOrganizer(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $organizer = User::findOrFail($id);
        $organizer->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.organizers')->with('success', 'Organizer updated successfully.');
    }
}
