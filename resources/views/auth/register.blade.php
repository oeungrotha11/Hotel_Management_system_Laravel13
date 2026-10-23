@extends('layouts.app')
@section('title','Create account | StayEase')
@section('content')
<div class="max-w-5xl mx-auto grid md:grid-cols-2 overflow-hidden rounded-3xl bg-white border border-slate-200 shadow-soft">
    <div class="hidden md:flex flex-col justify-between bg-gradient-to-br from-slate-900 via-blue-950 to-blue-700 text-white p-10 min-h-[620px]">
        <a href="{{ route('home') }}" class="flex items-center gap-3 text-white no-underline"><span class="brand-mark">⌂</span><strong class="text-lg">StayEase</strong></a>
        <div><p class="text-xs uppercase tracking-[.18em] text-blue-200 font-extrabold">MAKE YOURSELF AT HOME</p><h1 class="text-4xl font-extrabold tracking-tight leading-tight mt-4">A more comfortable way to travel.</h1><p class="text-blue-100 leading-7 mt-4">Create your account to browse rooms, request bookings, and keep every reservation easy to find.</p></div>
        <p class="text-xs text-blue-200">Your journey, made simpler.</p>
    </div>
    <div class="p-7 sm:p-10 flex flex-col justify-center">
        <div class="md:hidden mb-7 flex items-center gap-3"><span class="brand-mark">⌂</span><strong class="text-lg">StayEase</strong></div>
        <p class="text-xs uppercase tracking-[.16em] text-blue-600 font-extrabold">GET STARTED</p><h1 class="text-3xl font-extrabold tracking-tight text-slate-900 mt-2">Create your account</h1><p class="text-sm text-slate-500 mt-2 mb-6">Join StayEase to discover your next stay.</p>
        <form method="POST" action="{{ route('register') }}">@csrf
            <label>Full name<input name="name" value="{{ old('name') }}" maxlength="100" placeholder="Your full name" required autocomplete="name"></label>
            <label>Email address<input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autocomplete="email"></label>
            <label>Password<input type="password" name="password" minlength="8" placeholder="At least 8 characters" required autocomplete="new-password"></label>
            <label>Confirm password<input type="password" name="password_confirmation" minlength="8" placeholder="Enter password again" required autocomplete="new-password"></label>
            <button class="btn w-full !py-3 mt-1">Create account <span>→</span></button>
        </form>
        <p class="text-sm text-slate-500 mt-6 text-center">Already have an account? <a class="font-bold text-blue-700 hover:text-blue-900" href="{{ route('login') }}">Sign in</a></p>
    </div>
</div>
@endsection