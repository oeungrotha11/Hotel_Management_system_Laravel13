@extends('layouts.app')
@section('title', 'Sign in | StayEase')
@section('content')
<div class="max-w-5xl mx-auto grid md:grid-cols-2 overflow-hidden rounded-3xl bg-white border border-slate-200 shadow-soft">
    <div class="hidden md:flex flex-col justify-between bg-gradient-to-br from-slate-900 via-blue-950 to-blue-700 text-white p-10 min-h-[560px]">
        <a href="{{ route('home') }}" class="flex items-center gap-3 text-white no-underline"><span class="brand-mark">⌂</span><strong class="text-lg">StayEase</strong></a>
        <div><p class="text-xs uppercase tracking-[.18em] text-blue-200 font-extrabold">WELCOME BACK</p><h1 class="text-4xl font-extrabold tracking-tight leading-tight mt-4">Your next great stay starts here.</h1><p class="text-blue-100 leading-7 mt-4">Sign in to explore rooms, manage your reservations, and keep your travel plans in one place.</p></div>
        <p class="text-xs text-blue-200">Stay better. Travel well.</p>
    </div>
    <div class="p-7 sm:p-10 flex flex-col justify-center">
        <div class="md:hidden mb-8 flex items-center gap-3"><span class="brand-mark">⌂</span><strong class="text-lg">StayEase</strong></div>
        <p class="text-xs uppercase tracking-[.16em] text-blue-600 font-extrabold">YOUR ACCOUNT</p><h1 class="text-3xl font-extrabold tracking-tight text-slate-900 mt-2">Welcome back</h1><p class="text-sm text-slate-500 mt-2 mb-7">Enter your details to sign in to your account.</p>
        <form method="POST" action="{{ route('login') }}">@csrf
            <label>Email address<input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus autocomplete="email"></label>
            <label>Password<input type="password" name="password" placeholder="Enter your password" required autocomplete="current-password"></label>
            <button class="btn w-full !py-3 mt-1">Sign in <span>→</span></button>
        </form>
        <p class="text-sm text-slate-500 mt-6 text-center">New to StayEase? <a class="font-bold text-blue-700 hover:text-blue-900" href="{{ route('register') }}">Create an account</a></p>
    </div>
</div>
@endsection