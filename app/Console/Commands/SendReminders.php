<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderMail;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to attendees with pending RSVPs for events starting soon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the current date and time
        $currentDate = now();

        // Fetch events starting within the next 3 days
        $events = Event::whereDate('date_start', '>=', $currentDate->toDateString())
            ->whereDate('date_start', '<=', $currentDate->addDays(3)->toDateString())
            ->get();

        foreach ($events as $event) {
            // Fetch pending invitations for the event
            $invitations = Invitation::where('event_id', $event->id)
                ->where('rsvp_status', 'pending')
                ->get();

            foreach ($invitations as $invitation) {
                // Send reminder email
                Mail::to($invitation->attendee_email)->send(new ReminderMail($invitation));
            }
        }

        $this->info('Reminders sent successfully.');
    }
}
