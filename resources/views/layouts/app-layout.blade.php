<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" >
    <link href="https://fonts.googleapis.com/css2?family=DM Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Vendor --}}
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" defer></script>
    <link rel="stylesheet" href="{{ asset('vendors/chartjs/Chart.min.css') }}">

    
    
</head>

<body>
    <div id="app">
        <div id="main">
            <div id="sidebar" class="active">
                <x-sidebar :role="auth()->user()->role" />
            </div>

            <div class="page-content">
                <div class="page-heading">
                    <h3>@yield('page-title', 'Dashboard')</h3>
                </div>
                <section class="content">
                    @yield('content')
                </section>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/extensions/sweetalert2.js') }}"></script>

    <script src="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    
    <script src="{{ asset('vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('js/pages/ui-chartjs.js') }}"></script>
    <script src="{{ asset('vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('js/reminder.js') }}"></script>
    
    @yield('scripts')
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- filepath: c:\Users\Nasul\OneDrive\Desktop\project_client\event_management\event_management_pro\resources\views\layouts\app-layout.blade.php -->
    
    
</body>

</html>