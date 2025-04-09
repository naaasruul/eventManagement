@extends('layouts.app-layout')

@section('title', 'Organizer Events')

@section('page-title', 'My Events!')

@section('content')
<div class="row">
    <!-- Flash Messages -->
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
    <!-- Create Event Form -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Create New Event</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('organizer.events.create') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Event Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Event Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date_start" class="form-label">Start Date</label>
                            <input type="date" class="form-control @error('date_start') is-invalid @enderror" id="date_start" name="date_start" value="{{ old('date_start') }}" required>
                            @error('date_start')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="time_start" class="form-label">Start Time</label>
                            <input type="time" class="form-control @error('time_start') is-invalid @enderror" id="time_start" name="time_start" value="{{ old('time_start') }}" required>
                            @error('time_start')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date_end" class="form-label">End Date</label>
                            <input type="date" class="form-control @error('date_end') is-invalid @enderror" id="date_end" name="date_end" value="{{ old('date_end') }}" required>
                            @error('date_end')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="time_end" class="form-label">End Time</label>
                            <input type="time" class="form-control @error('time_end') is-invalid @enderror" id="time_end" name="time_end" value="{{ old('time_end') }}" required>
                            @error('time_end')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Event</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Manage Events Section -->
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Manage Events</h4>
                <form method="GET" action="{{ route('organizer.events') }}" class="d-flex">
                    <!-- Search Input -->
                    <input type="text" name="search" class="form-control me-2" placeholder="Search events..." value="{{ request('search') }}">
                    <!-- Sort Dropdown -->
                    <select name="status" class="form-select me-2">
                        <option value="">All Statuses</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="eventsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Event Name</th>
                            <th>Status</th>
                            <th>Date Start</th>
                            <th>Time Start</th>
                            <th>Date End</th>
                            <th>Time End</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $index => $event)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $event->name }}</td>
                            <td>
                                @if ($event->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif ($event->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif ($event->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ $event->date_start }}</td>
                            <td>{{ $event->time_start }}</td>
                            <td>{{ $event->date_end }}</td>
                            <td>{{ $event->time_end }}</td>
                            <td>
                                <a href="{{ route('organizer.events.invitations', $event->id) }}" class="btn btn-sm btn-primary">Manage Invitations</a>
                                {{-- <a href="{{ route('organizer.events.seating', $event->id) }}" class="btn btn-sm btn-secondary">Assign Seats</a> --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Pagination -->
<div class="mt-3 d-flex justify-content-center">
    <nav aria-label="Page navigation example">
        <ul class="pagination pagination-primary">
            <li class="page-item">
                <a class="page-link" href="{{ $events->previousPageUrl() }}">
                    <span aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
                </a>
            </li>
            @for ($i = 1; $i <= $events->lastPage(); $i++)
                <li class="page-item {{ $events->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $events->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item">
                <a class="page-link" href="{{ $events->nextPageUrl() }}">
                    <span aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
                </a>
            </li>
        </ul>
    </nav>
</div>
@endsection

@section('scripts')
@endsection
