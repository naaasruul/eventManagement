<!-- filepath: c:\Users\Nasul\OneDrive\Desktop\project_client\event_management\event_management_pro\resources\views\attendee\rsvp.blade.php -->
@extends('layouts.attendee-layout')

@section('title', 'RSVP')

@section('content')
<div class="container mt-5">
    <h2>RSVP for {{ $invitation->event->name }}</h2>
    <p>Dear {{ $invitation->attendee_email }}, please confirm your attendance for the event.</p>

    <form action="{{ route('attendee.rsvp.submit', $invitation->rsvp_link) }}" method="POST">
        @csrf
        <div class="form-check">
            <input class="form-check-input" type="radio" name="rsvp_status" id="accepted" value="accepted" required>
            <label class="form-check-label" for="accepted">Accept</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="rsvp_status" id="declined" value="declined" required>
            <label class="form-check-label" for="declined">Decline</label>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Submit RSVP</button>
    </form>
</div>
@endsection