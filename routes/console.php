<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure-based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule::call(function () {
//     Log::info('Scheduled task ran at ' . now());
//     // Query to find users with null email_verified_at
//     $users = User::whereNull('email_verified_at')->get();
//     if ($users->isEmpty()) {
//         Log::info('No users found with null email_verified_at');
//     } else {
//         Log::info('Found ' . $users->count() . ' users with null email_verified_at');
//         // Update the users' email_verified_at to the current time
//         $users->each(function ($user) {
//             Log::info('Updating user: ' . $user->id);
//             $user->update(['name' => 'memek']);
//         });
//     }
    
// })->everyFiveSeconds();

Schedule::command('reminders:send')->everyMinute();