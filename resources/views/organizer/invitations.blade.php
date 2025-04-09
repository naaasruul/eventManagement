<!-- filepath: c:\Users\Nasul\OneDrive\Desktop\project_client\event_management\event_management_pro\resources\views\organizer\invitations.blade.php -->
@extends('layouts.app-layout')

@section('title', 'Manage Invitations')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Manage Invitations for {{ $event->name }}</h4>
    </div>
    <div class="card-body">
        <!-- Display Success or Error Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Buttons to Trigger Modals -->
        <div class="d-flex justify-content-between mb-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadCsvModal">
                Upload CSV File
            </button>
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addSingleInvitationModal">
                Add Single Invitation
            </button>
        </div>

        <!-- RSVP Status Table -->
        <h5 class="mt-4">RSVP Status</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>RSVP Status</th>
                    <th>Seat Type</th>
                    <th>Seat Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invitations as $index => $invitation)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $invitation->attendee_email }}</td>
                    <td>{{ ucfirst($invitation->rsvp_status) }}</td>
                    <td>{{ $invitation->seat_type ?? 'N/A' }}</td>
                    <td>{{ $invitation->seat_number ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Upload CSV Modal -->
<div class="modal fade" id="uploadCsvModal" tabindex="-1" aria-labelledby="uploadCsvModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadCsvModalLabel">Upload CSV File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('organizer.events.invitations.upload', $event->id) }}" method="POST" enctype="multipart/form-data" id="uploadCsvForm">
                    @csrf
                    <div class="mb-3">
                        <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Upload and Send Invitations</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Single Invitation Modal -->
<div class="modal fade" id="addSingleInvitationModal" tabindex="-1" aria-labelledby="addSingleInvitationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSingleInvitationModalLabel">Add Single Invitation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('organizer.events.invitations.send', $event->id) }}" method="POST" id="sendInvitationForm">
                    @csrf
                    <div class="mb-3">
                        <label for="attendee_email" class="form-label">Attendee Email</label>
                        <input type="email" class="form-control" id="attendee_email" name="attendee_email" placeholder="Enter attendee email" required>
                    </div>
                    <div class="mb-3">
                        <label for="seat_type" class="form-label">Seat Type</label>
                        <select class="form-select" id="seat_type" name="seat_type" required>
                            <option value="General" selected>General</option>
                            <option value="VIP">VIP</option>
                            <option value="VVIP">VVIP</option>
                        </select>
                    </div>
                    <div class="mb-3" id="seat_number_container" style="display: none;">
                        <label for="seat_number" class="form-label">Seat Number</label>
                        <input type="text" class="form-control" id="seat_number" name="seat_number" placeholder="Enter seat number">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send Invitation</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Loading Screen -->
<div id="loadingScreen" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; text-align: center; padding-top: 20%;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <p>Please wait...</p>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const seatTypeSelect = document.getElementById('seat_type');
        const seatNumberContainer = document.getElementById('seat_number_container');
        const loadingScreen = document.getElementById('loadingScreen');

        // Show/Hide Seat Number Field
        seatTypeSelect.addEventListener('change', function () {
            if (this.value === 'VIP' || this.value === 'VVIP') {
                seatNumberContainer.style.display = 'block';
            } else {
                seatNumberContainer.style.display = 'none';
                document.getElementById('seat_number').value = ''; // Clear seat number if not VIP or VVIP
            }
        });

        // Show Loading Screen on Form Submission
        const uploadCsvForm = document.getElementById('uploadCsvForm');
        const sendInvitationForm = document.getElementById('sendInvitationForm');

        uploadCsvForm.addEventListener('submit', function () {
            loadingScreen.style.display = 'block';
        });

        sendInvitationForm.addEventListener('submit', function () {
            loadingScreen.style.display = 'block';
        });
    });
</script>
@endsection