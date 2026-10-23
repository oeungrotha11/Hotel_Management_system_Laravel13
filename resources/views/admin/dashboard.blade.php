@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
    <h1>Admin Dashboard</h1>
    <p class="muted">Manage rooms, reservations and customer accounts from one place.</p>
    <div class="stats">
        <div class="card">
            <div class="muted">Total rooms</div>
            <div class="stat">{{ $rooms }}</div>
        </div>
        <div class="card">
            <div class="muted">Available rooms</div>
            <div class="stat">{{ $availableRooms }}</div>
        </div>
        <div class="card">
            <div class="muted">Total bookings</div>
            <div class="stat">{{ $bookings }}</div>
        </div>
        <div class="card">
            <div class="muted">Pending bookings</div>
            <div class="stat">{{ $pendingBookings }}</div>
        </div>
        <div class="card">
            <div class="muted">Customers</div>
            <div class="stat">{{ $customers }}</div>
        </div>
    </div>
    <div class="row">
        <h2>Recent bookings</h2><a class="btn" href="{{ route('admin.bookings.index') }}">Manage all bookings</a>
    </div>
    <div class="card table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Stay</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                    <tr>
                        <td>{{ $booking->guest_name }}<br><small>{{ $booking->guest_email }}</small></td>
                        <td>{{ $booking->room->room_number }}</td>
                        <td>{{ $booking->check_in->format('Y-m-d') }} – {{ $booking->check_out->format('Y-m-d') }}</td>
                        <td>${{ number_format($booking->total_price, 2) }}</td>
                        <td>{{ str_replace('_', ' ', ucfirst($booking->status)) }}</td>
                        <td><a class="btn gray" href="{{ route('admin.bookings.edit', $booking) }}">Manage</a></td>
                </tr>@empty<tr>
                    <td colspan="6">No bookings yet.</td>
                </tr>@endforelse
            </tbody>
        </table>
    </div>
@endsection