<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
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
        return $this->subject('You are Invited!')
                    ->view('emails.invitation')
                    ->with([
                        'eventName' => $this->invitation->event->name,
                        'rsvpLink' => $this->invitation->rsvp_link,
                        'seatType' => $this->invitation->seat_type,
                        'seatNumber' => $this->invitation->seat_number,
                    ]);
    }
}
