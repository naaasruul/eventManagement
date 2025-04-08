<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','EV-M')</title>
    <link href="https://fonts.googleapis.com/css2?family=DM Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/auth.css') }}">
</head>
<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-12 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        {{-- <a href="{{ url('/') }}"><h1>EventEase</h1></a> --}}
                    </div>
                    @yield('auth-content')
                </div>
            </div>
            {{-- <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                </div>
            </div> --}}
        </div>
    </div>

</body>
</html>