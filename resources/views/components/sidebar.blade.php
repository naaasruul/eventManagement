{{-- filepath: c:\Users\Nasul\OneDrive\Desktop\project_client\event_management\event_management_pro\resources\views\components\sidebar.blade.php --}}
<div class="sidebar-wrapper active">
    <div class="sidebar-header">
        <div class="d-flex justify-content-between">
            <div class="logo">
                <a href="{{ route($role . '.dashboard') }}">EventEase</a>
            </div>
            <div class="toggler">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu</li>

            {{-- Common Dashboard Link --}}
            <li class="sidebar-item {{ request()->routeIs($role . '.dashboard') ? 'active' : '' }}">
                <a href="{{ route($role . '.dashboard') }}" class='sidebar-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- Admin-Specific Links --}}
            @if ($role === 'admin')
                <li class="sidebar-item {{ request()->routeIs('admin.events') ? 'active' : '' }}">
                    <a href="{{ route('admin.events') }}" class='sidebar-link'>
                        <i class="bi bi-calendar-event"></i>
                        <span>Manage Events</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.organizers') ? 'active' : '' }}">
                    <a href="{{ route('admin.organizers') }}" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Manage Organizers</span>
                    </a>
                </li>
            @endif

            {{-- Organizer-Specific Links --}}
            @if ($role === 'organizer')
                <li class="sidebar-item {{ request()->routeIs('organizer.events') ? 'active' : '' }}">
                    <a href="{{ route('organizer.events') }}" class='sidebar-link'>
                        <i class="bi bi-calendar-event"></i>
                        <span>My Events</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item {{ request()->routeIs('organizer.events.create') ? 'active' : '' }}">
                    <a href="{{ route('organizer.events.create') }}" class='sidebar-link'>
                        <i class="bi bi-plus-circle"></i>
                        <span>Create Event</span>
                    </a>
                </li> --}}
            @endif

            {{-- Attendee-Specific Links --}}
            @if ($role === 'attendee')
                <li class="sidebar-item {{ request()->routeIs('attendee.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('attendee.dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-envelope-fill"></i>
                        <span>My Invitations</span>
                    </a>
                </li>
            @endif

            {{-- Logout Link with Confirmation Modal --}}
            <li class="sidebar-item">
                <a href="#" class="sidebar-link" id="logout-btn">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>

            

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const logoutBtn = document.getElementById('logout-btn');
                    const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));

                    logoutBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        logoutModal.show();
                    });
                });
            </script>
        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>