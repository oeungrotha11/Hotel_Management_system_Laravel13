@extends('layouts.app')

@section('title', 'StayEase Hotel Management')

@section('content')
    <section class="hero row" style="align-items:center;">
        <div style="flex:1.5; min-width:280px;">
            <div class="feature-chip">Luxury stays made simple</div>
            <h1>Book your stay in a refined hotel experience.</h1>
            <p style="font-size:1.08rem; max-width:620px; color:#dbeafe; margin:0 0 18px;">
                Discover premium rooms, modern comforts, and effortless booking in one beautifully designed hotel system.
            </p>
            <div class="row" style="justify-content:flex-start; margin-top:12px;">
                <a class="btn green" href="{{ route('customer.rooms.index') }}">Explore rooms</a>
                @guest
                    <a class="btn gray" href="{{ route('login') }}">Login</a>
                @endguest
            </div>
        </div>

        <div style="flex:1; min-width:260px;">
            <div class="hero-panel">
                <p class="muted" style="color:#dbeafe; text-transform:uppercase; letter-spacing:.08em; font-size:12px; margin:0 0 8px;">Popular this week</p>
                <h3 style="margin:0 0 10px; font-size:2rem;">From $89 / night</h3>
                <p style="margin:0; color:#dbeafe;">Free Wi‑Fi, breakfast, parking, and comfortable rooms designed for your perfect stay.</p>
            </div>
        </div>
    </section>

    <section style="margin-top:22px;">
        <div class="stats">
            <div class="stat-box">
                <div class="muted">Hotels</div>
                <div class="stat">{{ $hotels->count() ?: 0 }}</div>
            </div>
            <div class="stat-box">
                <div class="muted">Available rooms</div>
                <div class="stat">{{ $featuredRooms->count() ?: 0 }}</div>
            </div>
            <div class="stat-box">
                <div class="muted">Amenities</div>
                <div class="stat">5+</div>
            </div>
        </div>
    </section>

    <section style="margin-top:26px;">
        <div class="section-header">
            <h2>Featured hotels</h2>
            <a class="btn secondary" href="{{ route('customer.rooms.index') }}">Browse all rooms</a>
        </div>
        <div class="room-grid">
            @forelse($hotels as $hotel)
                <div class="card room-card">
                    <div class="room-card-body">
                        <span class="feature-chip">Featured stay</span>
                        <h3>{{ $hotel->name }}</h3>
                        <p class="muted">{{ $hotel->city }}</p>
                        <p>{{ $hotel->address ?: 'Prime location in the city center.' }}</p>
                        <p><strong>{{ $hotel->rooms_count }}</strong> rooms available</p>
                    </div>
                </div>
            @empty
                <div class="card">No hotels available yet.</div>
            @endforelse
        </div>
    </section>

    <section style="margin-top:26px;">
        <div class="section-header">
            <h2>Featured rooms</h2>
            <a class="btn secondary" href="{{ route('customer.rooms.index') }}">View catalog</a>
        </div>

        <div class="room-grid">
            @forelse($featuredRooms as $room)
                @php
                    $featuredImage = $room->main_image
                        ? \Illuminate\Support\Facades\Storage::url($room->main_image)
                        : 'data:image/svg+xml;charset=UTF-8,'.urlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 500"><rect width="800" height="500" fill="#e2e8f0"/><rect x="80" y="60" width="640" height="380" rx="30" fill="#cbd5e1"/><circle cx="400" cy="185" r="80" fill="#94a3b8"/><rect x="255" y="265" width="290" height="90" rx="22" fill="#94a3b8"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-size="120" fill="#475569">🏨</text></svg>');
                @endphp
                <div class="card room-card">
                    <img src="{{ $featuredImage }}" alt="Room {{ $room->room_number }}">
                    <div class="room-card-body">
                        <p class="muted">{{ $room->hotel?->name ?? 'Hotel' }} · {{ $room->type }} room</p>
                        <h3>Room {{ $room->room_number }}</h3>
                        <div class="room-price">${{ number_format($room->price_per_night, 2) }} <small class="muted" style="font-size:13px; font-weight:normal">/ night</small></div>
                        <p>{{ $room->description ?: 'Comfortable and modern room for your stay.' }}</p>
                        @if($room->amenities->isNotEmpty())
                            <p class="muted">{{ $room->amenities->pluck('name')->implode(', ') }}</p>
                        @endif
                        <div style="margin-top:auto;">
                            <a class="btn" href="{{ route('customer.rooms.show', $room) }}">View details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card">No rooms available right now.</div>
            @endforelse
        </div>
    </section>
@endsection
