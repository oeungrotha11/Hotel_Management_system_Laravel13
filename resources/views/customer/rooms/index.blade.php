@extends('layouts.app')
@section('title','Browse Hotel Rooms')
@section('content')
    <div class="section-header">
        <div>
            <h1>Find your stay</h1>
            <p class="muted">Browse top rooms and book your next relaxing escape.</p>
        </div>
    </div>

    <div class="card">
        <form method="GET" class="row">
            <div>
                <label>Search room or hotel<input name="search" value="{{ request('search') }}" placeholder="Suite, Grand Hotel, 101..."></label>
            </div>
            <div>
                <label>Hotel<select name="hotel_id"><option value="">All hotels</option>@foreach($hotels as $hotel)<option value="{{ $hotel->id }}" @selected((string)request('hotel_id') === (string)$hotel->id)>{{ $hotel->name }}</option>@endforeach</select></label>
            </div>
            <div>
                <label>Minimum capacity<select name="capacity"><option value="">Any capacity</option>@foreach([1,2,3,4,5,6] as $n)<option value="{{ $n }}" @selected((string)request('capacity')===(string)$n)>{{ $n }}+ guest(s)</option>@endforeach</select></label>
            </div>
            <div style="flex:0 0 auto; min-width:170px;">
                <button class="btn">Search</button>
                <a class="btn gray" href="{{ route('customer.rooms.index') }}">Reset</a>
            </div>
        </form>
    </div>

    <div class="room-grid">
        @forelse($rooms as $room)
            @php
                $roomImage = $room->main_image
                    ? \Illuminate\Support\Facades\Storage::url($room->main_image)
                    : 'data:image/svg+xml;charset=UTF-8,'.urlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 500"><rect width="800" height="500" fill="#e2e8f0"/><rect x="80" y="60" width="640" height="380" rx="30" fill="#cbd5e1"/><circle cx="400" cy="185" r="80" fill="#94a3b8"/><rect x="255" y="265" width="290" height="90" rx="22" fill="#94a3b8"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-size="120" fill="#475569">🏨</text></svg>');
            @endphp
            <div class="card room-card">
                <img src="{{ $roomImage }}" alt="Room {{ $room->room_number }}">
                <div class="room-card-body">
                    <p class="muted">{{ $room->hotel?->name ?? 'Hotel' }} · Floor {{ $room->floor?->floor_number ?? '—' }} · {{ $room->type }} room</p>
                    <h2>Room {{ $room->room_number }}</h2>
                    <div class="room-price">${{ number_format($room->price_per_night,2) }} <small class="muted" style="font-size:13px;font-weight:normal">/ night</small></div>
                    <p>Up to {{ $room->capacity }} guest(s)</p>
                    <p>{{ $room->description ?: 'A comfortable room for your stay.' }}</p>
                    @if($room->amenities->isNotEmpty())
                        <p class="muted">{{ $room->amenities->pluck('name')->implode(', ') }}</p>
                    @endif
                    <div class="row" style="margin-top:auto;">
                        <a class="btn" href="{{ route('customer.rooms.show',$room) }}">View room</a>
                        <a class="btn green" href="{{ route('customer.bookings.create',['room_id'=>$room->id]) }}">Book now</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="card">No available rooms match your search.</div>
        @endforelse
    </div>
    <div class="pagination">{{ $rooms->links() }}</div>
@endsection

