@extends('layouts.guest-layout')

@section('title', 'Login')

@section('auth-content')
    <h1 class="auth-title">EventEase</h1>

    {{-- Display error messages --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="login-form" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" class="form-control form-control-xl" name="email" placeholder="email" required>
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" class="form-control form-control-xl" name="password" placeholder="Password" required>
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary  btn-block btn-lg shadow-lg mt-5">Log in</button>
        </div>
    </form>
    {{-- <div class="text-center mt-5 text-lg fs-4">
        <p class="text-gray-600">Don't have an account? <a href="{{ url('register') }}" class="font-bold">Sign up</a>.</p>
        <p><a class="font-bold" href="#">Forgot password?</a>.</p>
    </div> --}}
@endsection