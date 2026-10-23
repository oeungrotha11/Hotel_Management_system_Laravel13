@extends('layouts.app')
@section('title','My Bookings')
@section('content')<div class="row"><div><h1>My bookings</h1><p class="muted">View and track your reservations.</p></div><div style="text-align:right"><a class="btn" href="{{ route('customer.rooms.index') }}">+ Book a room</a></div></div>
<div class="card"><form method="GET" class="row"><div><label>Status<select name="status"><option value="">All statuses</option>@foreach(['pending','confirmed','checked_in','checked_out','cancelled'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ str_replace('_',' ',ucfirst($s)) }}</option>@endforeach</select></label></div><div style="flex:0 0 auto"><button class="btn">Filter</button> <a class="btn gray" href="{{ route('customer.bookings.index') }}">Reset</a></div></form></div>
<div class="card table-wrap"><table><thead><tr><th>Room</th><th>Stay</th><th>Guests</th><th>Total</th><th>Status</th><th></th></tr></thead><tbody>
@forelse($bookings as $booking)<tr><td>{{ $booking->room->room_number }} ({{ $booking->room->type }})</td><td>{{ $booking->check_in->format('Y-m-d') }} – {{ $booking->check_out->format('Y-m-d') }}</td><td>{{ $booking->guests }}</td><td>${{ number_format($booking->total_price,2) }}</td><td>{{ str_replace('_',' ',ucfirst($booking->status)) }}</td><td><a class="btn gray" href="{{ route('customer.bookings.show',$booking) }}">Details</a></td></tr>@empty<tr><td colspan="6">You have not booked a room yet.</td></tr>@endforelse
</tbody></table><div class="pagination">{{ $bookings->links() }}</div></div>
@endsection
