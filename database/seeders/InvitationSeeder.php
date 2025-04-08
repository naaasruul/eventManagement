<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invitation;

class InvitationSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample invitations
        Invitation::create([
            'event_id' => 1, // Assuming event ID 1 exists
            'attendee_email' => 'john.doe@example.com',
            'rsvp_status' => 'pending',
            'rsvp_link' => uniqid('rsvp_'),
        ]);

        Invitation::create([
            'event_id' => 1, // Assuming event ID 1 exists
            'attendee_email' => 'jane.smith@example.com',
            'rsvp_status' => 'accepted',
            'rsvp_link' => uniqid('rsvp_'),
        ]);

        Invitation::create([
            'event_id' => 2, // Assuming event ID 2 exists
            'attendee_email' => 'michael.brown@example.com',
            'rsvp_status' => 'declined',
            'rsvp_link' => uniqid('rsvp_'),
        ]);
    }
}
