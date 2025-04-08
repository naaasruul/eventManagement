<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Generate 100 sample events using the factory
        Event::factory()->count(100)->create();
    }
}
