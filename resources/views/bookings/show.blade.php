@extends('layouts.app')
@section('content')<div class="card"><h1>Booking #{{ $booking->id }}</h1><p>{{ $booking->guest_name }} — Room {{ $booking->room->room_number }}</p><a class="btn gray" href="{{ route('admin.bookings.index') }}">Back</a></div>@endsection
