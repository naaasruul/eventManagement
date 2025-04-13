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
        Schema::create('seats', function (Blueprint $table) {
            $table->id('seat_id'); // Primary key
            $table->unsignedBigInteger('event_id'); // Foreign key to events table
            $table->string('seat_category'); // Seat category (e.g., Regular, VIP)
            $table->string('seat_number'); // Seat number
            $table->enum('status', ['available', 'reserved'])->default('available'); // Seat status
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
