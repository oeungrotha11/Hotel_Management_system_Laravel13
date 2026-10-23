@extends('layouts.app')
@section('title', 'Overview | StayEase')
@section('heading', 'Overview')
@section('content')
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4 mb-7">
        <div><p class="text-xs uppercase tracking-[.16em] font-extrabold text-blue-600 mb-2">OVERVIEW</p><h2 class="admin-content-title">Good day, {{ auth()->user()->name }}</h2><p class="admin-subtitle">Here’s what’s happening across your hotel today.</p></div>
        <a class="btn" href="{{ route('admin.rooms.create') }}">＋ Add a room</a>
    </div>
    <div class="stats mb-7">
        <div class="card !mb-0"><div class="flex items-center justify-between"><span class="text-xs font-semibold text-slate-500">Total rooms</span><span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 grid place-items-center text-lg">▣</span></div><div class="stat">{{ $rooms }}</div><p class="text-xs text-slate-400 mt-2">Across all properties</p></div>
        <div class="card !mb-0"><div class="flex items-center justify-between"><span class="text-xs font-semibold text-slate-500">Available rooms</span><span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 grid place-items-center text-lg">✓</span></div><div class="stat">{{ $availableRooms }}</div><p class="text-xs text-slate-400 mt-2">Ready for a new guest</p></div>
        <div class="card !mb-0"><div class="flex items-center justify-between"><span class="text-xs font-semibold text-slate-500">Total reservations</span><span class="w-10 h-10 rounded-xl bg-violet-50 text-violet-700 grid place-items-center text-lg">▧</span></div><div class="stat">{{ $bookings }}</div><p class="text-xs text-slate-400 mt-2">All-time reservations</p></div>
        <div class="card !mb-0"><div class="flex items-center justify-between"><span class="text-xs font-semibold text-slate-500">Pending review</span><span class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 grid place-items-center text-lg">◷</span></div><div class="stat">{{ $pendingBookings }}</div><p class="text-xs text-slate-400 mt-2">Require your attention</p></div>
        <div class="card !mb-0"><div class="flex items-center justify-between"><span class="text-xs font-semibold text-slate-500">Customers</span><span class="w-10 h-10 rounded-xl bg-rose-50 text-rose-700 grid place-items-center text-lg">♙</span></div><div class="stat">{{ $customers }}</div><p class="text-xs text-slate-400 mt-2">Registered accounts</p></div>
    </div>
    <section class="card !p-0 overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-5 sm:px-6 py-5 border-b border-slate-100">
            <div><h3 class="font-extrabold text-slate-800">Recent reservations</h3><p class="text-xs text-slate-400 mt-1">Keep track of your latest guest activity.</p></div>
            <a class="btn gray" href="{{ route('admin.bookings.index') }}">View all reservations <span>→</span></a>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Guest</th><th>Room</th><th>Stay dates</th><th>Total</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                @forelse($recentBookings as $booking)
                    <tr>
                        <td><div class="font-bold text-slate-700">{{ $booking->guest_name }}</div><div class="text-xs text-slate-400 mt-1">{{ $booking->guest_email }}</div></td>
                        <td><span class="font-bold text-slate-700">Room {{ $booking->room->room_number }}</span></td>
                        <td><span class="text-slate-600">{{ $booking->check_in->format('d M Y') }}</span><div class="text-xs text-slate-400 mt-1">to {{ $booking->check_out->format('d M Y') }}</div></td>
                        <td class="font-extrabold text-slate-800">${{ number_format($booking->total_price, 2) }}</td>
                        <td><span class="badge-status">{{ str_replace('_', ' ', ucfirst($booking->status)) }}</span></td>
                        <td><a class="btn gray" href="{{ route('admin.bookings.edit', $booking) }}">Review</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-12"><div class="text-3xl mb-3">▧</div><p class="font-bold text-slate-700">No reservations yet</p><p class="text-xs text-slate-400 mt-1">New bookings will appear here.</p></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection