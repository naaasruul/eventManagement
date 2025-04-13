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
        Schema::create('rsvp', function (Blueprint $table) {
            $table->id('rsvp_id'); // Primary key
            $table->unsignedBigInteger('attendee_id'); // Foreign key to attendees table
            $table->unsignedBigInteger('event_id'); // Foreign key to events table
            $table->enum('status', ['accepted', 'declined', 'pending'])->default('pending'); // RSVP status
            $table->dateTime('response_date')->nullable(); // Date of RSVP response
            $table->boolean('vip_status')->default(false); // VIP status
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('attendee_id')->references('attendee_id')->on('attendees')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rsvp');
    }
};
