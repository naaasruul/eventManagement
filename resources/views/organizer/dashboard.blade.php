@extends('layouts.app-layout')

@section('title', 'Organizer Dashboard')

@section('page-title', 'Welcome, Organizer!')

@section('content')
<div class="row">
     <!-- Event Attendees Chart -->
     <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h2 class="">Event Attendees</h2>
            </div>
            <div class="card-body">
                <canvas id="eventAttendeesChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- RSVP Status Chart -->
    <div class="col-12 d-flex justify-content-center col-lg-12">
        <div class="card w-50">
            <div class="card-header">
                <h2 class="text-center">RSVP Status Overview</h2>
            </div>
            <div class="card-body">
                <canvas id="rsvpStatusChart" height="200"></canvas>
            </div>
        </div>
    </div>

   
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Initialize RSVP Status Chart
    const rsvpStatusCtx = document.getElementById('rsvpStatusChart').getContext('2d');
    const rsvpStatusChart = new Chart(rsvpStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Accepted', 'Declined', 'Pending'],
            datasets: [{
                label: 'RSVP Status',
                data: [{{ $acceptedRSVPs }}, {{ $declinedRSVPs }}, {{ $pendingRSVPs }}],
                backgroundColor: ['#4CAF50', '#F44336', '#FFC107'],
            }]
        }
    });

    // Initialize Event Attendees Chart
    const eventAttendeesCtx = document.getElementById('eventAttendeesChart').getContext('2d');
    const eventAttendeesChart = new Chart(eventAttendeesCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($eventNames) !!},
            datasets: [{
                label: 'Number of Attendees',
                data: {!! json_encode($attendeeCounts) !!},
                backgroundColor: '#2196F3',
            }]
        }
    });


</script>
@endsection