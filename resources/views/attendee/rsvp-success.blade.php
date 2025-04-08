<!-- filepath: c:\Users\Nasul\OneDrive\Desktop\project_client\event_management\event_management_pro\resources\views\attendee\rsvp-success.blade.php -->
@extends('layouts.attendee-layout')


@section('content')
<div class="container mt-5 text-center">
    <h1 class="text-success">Thank You!</h1>
    <p>Your RSVP has been submitted successfully.</p>
    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Back to Home</a>
</div>
@endsection