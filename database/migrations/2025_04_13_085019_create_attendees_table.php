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
        Schema::create('attendees', function (Blueprint $table) {
            $table->id('attendee_id'); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->unsignedBigInteger('event_id'); // Foreign key to events table
            $table->string('name'); // Attendee name
            $table->string('email')->unique(); // Attendee email
            $table->string('seat_category'); // Seat category (e.g., Regular, VIP)
            $table->boolean('email_sent')->default(false); // Email sent status
            $table->string('token')->unique(); // Unique token for RSVP confirmation
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendees');
    }
};
