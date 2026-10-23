@extends('layouts.app')
@section('title','Register')
@section('content')<div class="card auth"><h1>Create account</h1><p class="muted">Create a customer account to browse rooms and request bookings.</p><form method="POST" action="{{ route('register') }}">@csrf
<label>Full name<input name="name" value="{{ old('name') }}" maxlength="100" required></label>
<label>Email address<input type="email" name="email" value="{{ old('email') }}" required></label>
<label>Password<input type="password" name="password" minlength="8" required></label>
<label>Confirm password<input type="password" name="password_confirmation" minlength="8" required></label>
<button class="btn" style="width:100%">Register</button></form><p>Already registered? <a href="{{ route('login') }}">Login</a></p></div>@endsection
