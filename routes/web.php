<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Attendee\AttendeeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Organizer\OrganizerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/', [AuthController::class, 'index'])->name('showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin dashboard route
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/events', [AdminController::class, 'viewEvents'])->name('events');
    Route::post('/events/{id}/approve', [AdminController::class, 'approveEvent'])->name('events.approve');
    Route::post('/events/{id}/reject', [AdminController::class, 'rejectEvent'])->name('events.reject');

    Route::get('/organizers', [AdminController::class, 'viewOrganizers'])->name('organizers');
    Route::post('/organizers/add', [AdminController::class, 'addOrganizer'])->name('organizers.add');
    Route::post('/organizers/{id}/edit', [AdminController::class, 'editOrganizer'])->name('organizers.edit');
    Route::delete('/organizers/{id}', [AdminController::class, 'removeOrganizer'])->name('organizers.remove');
});

// Organizer dashboard route
Route::prefix('organizer')->name('organizer.')->group(function () {
    Route::get('/dashboard', [OrganizerController::class, 'index'])->name('dashboard');

    Route::get('/events', [OrganizerController::class, 'viewEvents'])->name('events');
    Route::post('/events/create', [OrganizerController::class, 'createEvent'])->name('events.create');
    Route::get('/events/{id}/invitations', [OrganizerController::class, 'manageInvitations'])->name('events.invitations');
    Route::post('/events/{id}/invitations/send', [OrganizerController::class, 'sendInvitations'])->name('events.invitations.send');
    Route::post('/events/{id}/invitations/remind', [OrganizerController::class, 'sendReminders'])->name('events.invitations.remind');
    Route::get('/events/{id}/seating', [OrganizerController::class, 'assignSeating'])->name('events.seating');
    Route::post('/events/{id}/seating', [OrganizerController::class, 'saveSeating'])->name('events.seating.save');

    Route::post('/events/{id}/invitations/upload', [OrganizerController::class, 'uploadInvitations'])->name('events.invitations.upload');
});

// Attendee dashboard route
Route::prefix('attendee')->name('attendee.')->group(function () {
    Route::get('/rsvp/success', [AttendeeController::class, 'index'])->name('dashboard');

    Route::get('/rsvp/{link}', [AttendeeController::class, 'viewRSVP'])->name('rsvp');
    Route::post('/rsvp/{link}', [AttendeeController::class, 'submitRSVP'])->name('rsvp.submit');
});
Route::get('/events/check-reminders', [OrganizerController::class, 'checkAndSendReminders']);



Route::get('/log-test', function () {
    Log::info('✅ Logging is working!');
    return 'Check your logs!';
});