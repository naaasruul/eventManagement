@extends('layouts.app-layout')

@section('title', 'Manage Events')

@section('page-title', 'Manage Events')
@section('page-subtitle', 'View and manage all events created by organizers.')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">All Events</h4>
            <div class="float-end d-flex">
                <!-- Search Form with Status Filter -->
                <form method="GET" action="{{ route('admin.events') }}" class="d-flex me-2">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search events..." value="{{ request('search') }}">
                    <select name="status" class="form-select me-2">
                        <option value="">All Statuses</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th data-sortable='true'>#</th>
                        <th data-sortable='true'>ID</th>
                        <th data-sortable='true'>Name</th>
                        <th data-sortable='true'>Description</th>
                        <th data-sortable='true'>Status</th>
                        <th data-sortable='true'>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $index => $event)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $event->id }}</td>
                            <td>{{ $event->name }}</td>
                            <td>{{ $event->description }}</td>
                            <td>
                                @if ($event->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif ($event->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif ($event->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ $event->organizer->name ?? 'N/A' }}</td>
                            <td>
                                @if ($event->status === 'pending')
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton{{ $event->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $event->id }}">
                                        <li>
                                            <form action="{{ route('admin.events.approve', $event->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-success">Approve</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.events.reject', $event->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">Reject</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                @else
                                    <span class="text-muted">No actions available</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="mt-3">
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
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize DataTable
        let table1 = document.querySelector('#table1');
        if (table1) {
            let dataTable = new simpleDatatables.DataTable(table1);

            // Filter by status
            const statusFilter = document.getElementById('statusFilter');
            statusFilter.addEventListener('change', function () {
                const selectedStatus = this.value.toLowerCase();
                dataTable.rows().every(function (row) {
                    const statusCell = row.cells[4].textContent.trim().toLowerCase();
                    if (selectedStatus === '' || statusCell.includes(selectedStatus)) {
                        row.show();
                    } else {
                        row.hide();
                    }
                });
            });
        }
    });
</script>
@endsection
