{{-- filepath: c:\Users\Nasul\OneDrive\Desktop\project_client\event_management\event_management_pro\resources\views\admin\dashboard.blade.php --}}
@extends('layouts.app-layout')

@section('title', 'Admin Dashboard')

@section('page-title', 'Welcome, Admin!')

@section('content')
    <div class="row">
        {{-- Statistics Cards --}}
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Events</h5>
                    <p class="card-text display-4">{{ $totalEvents }}</p>
                    <p class="text-muted">All events created by organizers.</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pending Approvals</h5>
                    <p class="card-text display-4">{{ $pendingEvents }}</p>
                    <p class="text-muted">Events awaiting your approval.</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Organizers</h5>
                    <p class="card-text display-4">{{ $totalOrganizers }}</p>
                    <p class="text-muted">Registered organizers in the system.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        {{-- Events Status Chart --}}
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Event Status Overview</h4>
                </div>
                <div class="card-body">
                    <canvas id="eventStatusChart" height="200"></canvas>
                </div>
            </div>
        </div>

        {{-- Organizer Activity Chart --}}
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Organizer Activity</h4>
                </div>
                <div class="card-body">
                    <canvas id="organizerActivityChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/charts.js') }}"></script>
    <script>
        // Sample data for charts
        const eventStatusData = {
            labels: ['Approved', 'Pending', 'Rejected'],
            datasets: [{
                label: 'Event Status',
                data: [{{ $approvedEvents }}, {{ $pendingEvents }}, {{ $rejectedEvents }}],
                backgroundColor: ['#4CAF50', '#FFC107', '#F44336'],
            }]
        };

        const organizerActivityData = {
            labels: {!! json_encode($organizerNames) !!},
            datasets: [{
                label: 'Organizer Activity',
                data: {!! json_encode($organizerEventCounts) !!},
                backgroundColor: '#2196F3',
            }]
        };

        // Initialize charts
        const ctx1 = document.getElementById('eventStatusChart').getContext('2d');
        const ctx2 = document.getElementById('organizerActivityChart').getContext('2d');

        new Chart(ctx1, {
            type: 'pie',
            data: eventStatusData,
        });

        new Chart(ctx2, {
            type: 'bar',
            data: organizerActivityData,
        });
    </script>
@endsection
