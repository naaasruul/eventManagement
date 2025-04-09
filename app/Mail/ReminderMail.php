<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;

    /**
     * Create a new message instance.
     */
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Reminder: RSVP for the Event')
                    ->view('emails.reminder')
                    ->with([
                        'eventName' => $this->invitation->event->name,
                        'rsvpLink' => $this->invitation->rsvp_link,
                        'seatType' => $this->invitation->seat_type,
                        'seatNumber' => $this->invitation->seat_number,
                        'date_start' => $this->invitation->event->date_start,
                        'time_start' => $this->invitation->event->time_start,
                        'date_end' => $this->invitation->event->date_end,
                        'time_end' => $this->invitation->event->time_end,
                    ]);
    }
}
