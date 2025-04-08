<!-- filepath: c:\Users\Nasul\OneDrive\Desktop\project_client\event_management\event_management_pro\resources\views\organizer\seating.blade.php -->
@extends('layouts.app-layout')

@section('title', 'Assign Seating')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Assign Seating for {{ $event->name }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('organizer.events.seating.save', $event->id) }}" method="POST">
            @csrf
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Seat Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invitations as $index => $invitation)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $invitation->attendee_email }}</td>
                        <td>
                            <select name="seating[{{ $invitation->id }}]" class="form-select">
                                <option value="VVIP" {{ $invitation->seat_type === 'VVIP' ? 'selected' : '' }}>VVIP</option>
                                <option value="VIP" {{ $invitation->seat_type === 'VIP' ? 'selected' : '' }}>VIP</option>
                                <option value="General" {{ $invitation->seat_type === 'General' ? 'selected' : '' }}>General</option>
                            </select>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Save Seating</button>
        </form>
    </div>
</div>
@endsection