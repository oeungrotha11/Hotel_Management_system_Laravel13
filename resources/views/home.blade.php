@extends('layouts.app')
@section('title', 'StayEase | Find your next stay')
@section('content')
    <section class="hero">
        <div class="grid lg:grid-cols-[1.25fr_.75fr] gap-9 items-center relative z-10">
            <div>
                <span class="feature-chip !bg-white/15 !text-white border border-white/20">A better way to stay</span>
                <h1>Find a stay that<br class="hidden sm:block"> feels like <span class="text-blue-200">your own.</span></h1>
                <p class="text-blue-100 leading-7 max-w-xl mb-7">Thoughtfully selected rooms, simple reservations, and the comfort you need to make every trip feel special.</p>
                <div class="flex flex-wrap gap-3">
                    <a class="btn !bg-white !text-blue-800 hover:!bg-blue-50 !px-5 !py-3" href="{{ route('customer.rooms.index') }}">Explore rooms <span>→</span></a>
                    @guest<a class="btn !bg-white/10 !border-white/30 hover:!bg-white/20 !px-5 !py-3" href="{{ route('register') }}">Join StayEase</a>@endguest
                </div>
                <div class="flex flex-wrap gap-6 mt-8 text-xs text-blue-100"><span>✓ Thoughtful comfort</span><span>✓ Easy booking</span><span>✓ Trusted service</span></div>
            </div>
            <div class="hero-panel">
                <p class="text-xs uppercase tracking-[.16em] font-bold text-blue-100 mb-4">Your next getaway</p>
                <div class="rounded-2xl overflow-hidden mb-5 bg-white/10">
                    <img class="w-full h-40 object-cover" src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=900&q=85" alt="Warm, modern hotel bedroom">
                </div>
                <div class="flex justify-between gap-4 items-end"><div><h2 class="text-xl font-extrabold">Rest easy. Stay inspired.</h2><p class="text-sm text-blue-100 mt-2">Comfortable rooms for every kind of journey.</p></div><span class="text-2xl">✦</span></div>
            </div>
        </div>
    </section>
    <section class="grid sm:grid-cols-3 gap-4 mt-5">
        <div class="stat-box"><p class="muted text-xs font-semibold">Properties to explore</p><div class="stat">{{ $hotels->count() }}</div></div>
        <div class="stat-box"><p class="muted text-xs font-semibold">Featured rooms</p><div class="stat">{{ $featuredRooms->count() }}</div></div>
        <div class="stat-box"><p class="muted text-xs font-semibold">Designed around you</p><div class="stat">Every stay</div></div>
    </section>
    <section class="mt-10">
        <div class="section-header"><div><p class="text-xs uppercase tracking-[.15em] text-blue-600 font-extrabold mb-2">DISCOVER</p><h2>Featured properties</h2></div><a class="btn gray" href="{{ route('customer.rooms.index') }}">Browse rooms →</a></div>
        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">
            @forelse($hotels as $hotel)
                <article class="card !p-0 overflow-hidden !mb-0">
                    <div class="h-36 bg-gradient-to-br from-slate-100 to-blue-100 grid place-items-center text-4xl text-blue-300">⌂</div>
                    <div class="p-5"><span class="feature-chip">StayEase property</span><h3 class="text-lg font-extrabold mt-3">{{ $hotel->name }}</h3><p class="text-sm text-slate-500 mt-1">⌖ {{ $hotel->city }}</p><p class="text-sm text-slate-500 mt-3">{{ $hotel->address ?: 'A convenient location for your next stay.' }}</p><p class="text-xs text-slate-500 mt-4"><strong class="text-slate-800">{{ $hotel->rooms_count }}</strong> rooms in this property</p></div>
                </article>
            @empty
                <div class="card">No properties available yet. Please check back soon.</div>
            @endforelse
        </div>
    </section>
    <section class="mt-10">
        <div class="section-header"><div><p class="text-xs uppercase tracking-[.15em] text-blue-600 font-extrabold mb-2">HANDPICKED FOR YOU</p><h2>Rooms worth staying in</h2></div><a class="btn gray" href="{{ route('customer.rooms.index') }}">View all rooms →</a></div>
        <div class="room-grid">
            @forelse($featuredRooms as $room)
                @php($featuredImage = $room->main_image ? IlluminateSupportFacadesStorage::url($room->main_image) : 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=900&q=80')
                <article class="card room-card !mb-0">
                    <img src="{{ $featuredImage }}" alt="Room {{ $room->room_number }}">
                    <div class="room-card-body"><p class="text-xs text-slate-500">{{ $room->hotel?->name ?? 'StayEase property' }} · {{ $room->type }}</p><h3>Room {{ $room->room_number }}</h3><div class="room-price">${{ number_format($room->price_per_night, 2) }} <small class="muted text-xs font-normal">/ night</small></div><p>{{ $room->description ?: 'A welcoming room with the essentials for a comfortable stay.' }}</p>@if($room->amenities->isNotEmpty())<p class="muted">{{ $room->amenities->pluck('name')->implode(' · ') }}</p>@endif<div class="mt-3"><a class="btn" href="{{ route('customer.rooms.show', $room) }}">View room details →</a></div></div>
                </article>
            @empty
                <div class="card">No rooms are available right now.</div>
            @endforelse
        </div>
    </section>
@endsection