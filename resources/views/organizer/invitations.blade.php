<!-- filepath: c:\Users\Nasul\OneDrive\Desktop\project_client\event_management\event_management_pro\resources\views\organizer\invitations.blade.php -->
@extends('layouts.app-layout')

@section('title', 'Manage Invitations')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Manage Invitations for {{ $event->name }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Upload CSV Form -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Upload CSV File</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('organizer.events.invitations.upload', $event->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="csv_file" class="form-label">Upload CSV File</label>
                                <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Upload and Send Invitations</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Add Single Invitation Form -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Add Single Invitation</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('organizer.events.invitations.send', $event->id) }}" method="POST">
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
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const seatTypeSelect = document.getElementById('seat_type');
        const seatNumberContainer = document.getElementById('seat_number_container');

        seatTypeSelect.addEventListener('change', function () {
            if (this.value === 'VIP' || this.value === 'VVIP') {
                seatNumberContainer.style.display = 'block';
            } else {
                seatNumberContainer.style.display = 'none';
                document.getElementById('seat_number').value = ''; // Clear seat number if not VIP or VVIP
            }
        });
    });
</script>
@endsection