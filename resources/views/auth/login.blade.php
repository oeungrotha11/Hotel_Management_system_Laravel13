@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <div class="card auth">
        <h1>Welcome back</h1>
        <p class="muted">Sign in to continue to your hotel account.</p>
        <form method="POST" action="{{ route('login') }}">@csrf
            <label>Email address<input type="email" name="email" value="{{ old('email') }}" required autofocus></label>
            <label>Password<input type="password" name="password" required></label>
            <button class="btn" style="width:100%">Login</button>
        </form>
        <p>New here? <a href="{{ route('register') }}">Create an account</a></p>
</div>@endsection