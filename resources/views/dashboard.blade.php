@extends('layouts.app')
@section('title','Dashboard')
@section('content')
<h1>Hotel Dashboard</h1><p class="muted">Welcome, {{ auth()->user()->name }}. Here is the current overview.</p>
<div class="stats"><div class="card"><div class="muted">Total rooms</div><div class="stat">{{ $rooms }}</div></div><div class="card"><div class="muted">Available rooms</div><div class="stat">{{ $availableRooms }}</div></div><div class="card"><div class="muted">Total bookings</div><div class="stat">{{ $bookings }}</div></div></div>
<div class="row"><h2>Recent bookings</h2><a class="btn" href="{{ route('admin.bookings.create') }}">+ New booking</a></div>
<div class="card table-wrap"><table><thead><tr><th>Guest</th><th>Room</th><th>Check in</th><th>Check out</th><th>Status</th></tr></thead><tbody>
@forelse($recentBookings as $booking)<tr><td>{{ $booking->guest_name }}</td><td>{{ $booking->room->room_number }}</td><td>{{ $booking->check_in->format('Y-m-d') }}</td><td>{{ $booking->check_out->format('Y-m-d') }}</td><td>{{ str_replace('_',' ',ucfirst($booking->status)) }}</td></tr>@empty<tr><td colspan="5">No bookings yet. <a href="{{ route('admin.bookings.create') }}">Create the first booking</a>.</td></tr>@endforelse
</tbody></table></div>
@endsection
