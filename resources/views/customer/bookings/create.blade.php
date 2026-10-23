@extends('layouts.app')
@section('title','Request a Booking')
@section('content')
<div class="card"><h1>Request a booking</h1><p class="muted">Your reservation will be pending until the hotel confirms it.</p>
<form method="POST" action="{{ route('customer.bookings.store') }}">@csrf
<label>Room<select name="room_id" required><option value="">Select an available room</option>@foreach($rooms as $room)<option value="{{ $room->id }}" @selected((string)old('room_id',request('room_id'))===(string)$room->id)>Room {{ $room->room_number }} — {{ $room->type }} (${{ number_format($room->price_per_night,2) }}/night; capacity {{ $room->capacity }})</option>@endforeach</select></label>
<div class="row"><label>Check-in<input type="date" name="check_in" min="{{ now()->toDateString() }}" value="{{ old('check_in') }}" required></label><label>Check-out<input type="date" name="check_out" min="{{ now()->addDay()->toDateString() }}" value="{{ old('check_out') }}" required></label></div>
<label>Number of guests<input type="number" name="guests" min="1" max="20" value="{{ old('guests',1) }}" required></label>
<p>Booking under: <b>{{ auth()->user()->name }}</b> ({{ auth()->user()->email }})</p><button class="btn">Submit booking request</button> <a class="btn gray" href="{{ route('customer.rooms.index') }}">Cancel</a></form></div>
@endsection
