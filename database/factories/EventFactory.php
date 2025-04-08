<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3), // Generate a random event name
            'description' => $this->faker->paragraph, // Generate a random description
            'status' => $this->faker->randomElement(['approved', 'pending', 'rejected']), // Random status
            'created_by' => User::where('role', 'organizer')->inRandomOrder()->first()->id, // Random organizer ID
        ];
    }
}
