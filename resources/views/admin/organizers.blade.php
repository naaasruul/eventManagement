@extends('layouts.app-layout')

@section('title', 'Manage Organizers')
@section('page-title', 'Manage Organizers')
@section('page-subtitle', 'View and manage all registered organizers.')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title"><i class="bi bi-person-fill"></i> Organizers</h4>
            
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOrganizerModal">
                <i class="bi bi-plus-circle"></i> Add Organizer
            </button>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.organizers') }}" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search by email..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
            </form>
            <table class="table table-striped" id="organizersTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($organizers as $index => $organizer)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $organizer->name }}</td>
                            <td>{{ $organizer->email }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editOrganizerModal{{ $organizer->id }}">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <form action="{{ route('admin.organizers.remove', $organizer->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Organizer Modal -->
                        <div class="modal fade" id="editOrganizerModal{{ $organizer->id }}" tabindex="-1" aria-labelledby="editOrganizerModalLabel{{ $organizer->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editOrganizerModalLabel{{ $organizer->id }}">Edit Organizer</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.organizers.edit',$organizer->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name{{ $organizer->id }}" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name{{ $organizer->id }}" name="name" value="{{ $organizer->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email{{ $organizer->id }}" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email{{ $organizer->id }}" name="email" value="{{ $organizer->email }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Add Organizer Modal -->
<div class="modal fade" id="addOrganizerModal" tabindex="-1" aria-labelledby="addOrganizerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOrganizerModalLabel">Add New Organizer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.organizers.add') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Organizer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let organizersTable = document.querySelector('#organizersTable');
        if (organizersTable) {
            new simpleDatatables.DataTable(organizersTable, {
                searchable: true,
                fixedHeight: true,
                perPage: 10,
            });
        }
    });
</script>
@endsection