@extends('layouts.app')
@section('title', 'Request a Booking')
@section('content')
    <div class="card max-w-2xl mx-auto">
        <h1 class="mb-2">Request a booking</h1>
        <p class="muted mb-6">Your reservation will be pending until the hotel confirms it.</p>

        <form method="POST" action="{{ route('customer.bookings.store') }}" class="space-y-5">@csrf
            <label class="block text-sm font-semibold text-slate-700">
                Room
                <select name="room_id" required class="mt-2 w-full h-12 rounded-xl border border-slate-200 bg-white px-3 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">
                    <option value="">Select an available room</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" @selected((string) old('room_id', request('room_id')) === (string) $room->id)>
                            Room {{ $room->room_number }} — {{ $room->type }} (${{ number_format($room->price_per_night, 2) }}/night; capacity {{ $room->capacity }})
                        </option>
                    @endforeach
                </select>
            </label>

            <div class="grid gap-5 md:grid-cols-2">
                <label class="block text-sm font-semibold text-slate-700">
                    Check-in
                    <input type="date" name="check_in" min="{{ now()->toDateString() }}" value="{{ old('check_in') }}" required class="mt-2 w-full h-12 rounded-xl border border-slate-200 bg-white px-3 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">
                </label>

                <label class="block text-sm font-semibold text-slate-700">
                    Check-out
                    <input type="date" name="check_out" min="{{ now()->addDay()->toDateString() }}" value="{{ old('check_out') }}" required class="mt-2 w-full h-12 rounded-xl border border-slate-200 bg-white px-3 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">
                </label>
            </div>

            <label class="block text-sm font-semibold text-slate-700">
                Number of guests
                <input type="number" name="guests" min="1" max="20" value="{{ old('guests', 1) }}" required class="mt-2 w-full h-12 rounded-xl border border-slate-200 bg-white px-3 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">
            </label>

            <p class="text-sm text-slate-600">Booking under: <b>{{ auth()->user()->name }}</b> ({{ auth()->user()->email }})</p>

            <div class="flex flex-wrap gap-3 pt-2">
                <button class="btn h-12 px-5">Submit booking request</button>
                <a class="btn gray h-12 px-5" href="{{ route('customer.rooms.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection