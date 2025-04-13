<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id'); // Foreign key to events table
            $table->unsignedBigInteger('attendee_id'); // Foreign key to attendees table
            $table->enum('rsvp_status', ['pending', 'accepted', 'declined'])->default('pending'); // RSVP status
            $table->string('rsvp_link')->unique(); // Unique RSVP link
            $table->string('tracking_token')->unique(); // Unique tracking token
            $table->timestamp('sent_at')->nullable(); // Date when the invitation was sent
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');            
            $table->foreign('attendee_id')->references('attendee_id')->on('attendees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
