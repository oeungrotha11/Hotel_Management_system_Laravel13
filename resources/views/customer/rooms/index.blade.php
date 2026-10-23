@extends('layouts.app')
@section('title','Browse rooms | StayEase')
@section('content')
    <section class="rounded-3xl bg-gradient-to-r from-slate-900 via-blue-950 to-blue-800 text-white p-7 sm:p-10 mb-7">
        <p class="text-xs uppercase tracking-[.16em] text-blue-200 font-extrabold mb-3">THE ROOM COLLECTION</p>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Find your place to unwind.</h1>
        <p class="text-blue-100 text-sm sm:text-base mt-3 max-w-2xl leading-6">Compare room types, explore amenities, and choose the right space for your next stay.</p>
    </section>
    <section class="card">
        <div class="flex items-center justify-between gap-3 mb-4"><div><h2 class="font-extrabold text-slate-800">Find your room</h2><p class="text-xs text-slate-400 mt-1">Narrow down the options to match your trip.</p></div><span class="feature-chip">Room search</span></div>
        <form method="GET" class="grid md:grid-cols-3 gap-4 items-end">
            <div><label>Search<input name="search" value="{{ request('search') }}" placeholder="Room, hotel, or room type"></label></div>
            <div><label>Property<select name="hotel_id"><option value="">All properties</option>@foreach($hotels as $hotel)<option value="{{ $hotel->id }}" @selected((string)request('hotel_id') === (string)$hotel->id)>{{ $hotel->name }}</option>@endforeach</select></label></div>
            <div><label>Guest capacity<select name="capacity"><option value="">Any capacity</option>@foreach([1,2,3,4,5,6] as $n)<option value="{{ $n }}" @selected((string)request('capacity')===(string)$n)>{{ $n }}+ guest(s)</option>@endforeach</select></label></div>
            <div class="md:col-span-3 flex flex-wrap gap-2"><button class="btn">Apply filters →</button><a class="btn gray" href="{{ route('customer.rooms.index') }}">Clear filters</a></div>
        </form>
    </section>
    <div class="flex items-center justify-between gap-3 mb-4 mt-8"><div><h2 class="text-xl font-extrabold text-slate-900">Available rooms</h2><p class="text-sm text-slate-500 mt-1">Choose a room to see details and booking options.</p></div><span class="text-xs text-slate-500">{{ $rooms->total() }} result(s)</span></div>
    <div class="room-grid">
        @forelse($rooms as $room)
            @php($roomImage = $room->main_image ? IlluminateSupportFacadesStorage::url($room->main_image) : 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=900&q=80')
            <article class="card room-card !mb-0">
                <div class="relative"><img src="{{ $roomImage }}" alt="Room {{ $room->room_number }}"><span class="absolute top-3 left-3 feature-chip !bg-white/95 !text-slate-700">{{ ucfirst($room->type) }}</span></div>
                <div class="room-card-body"><p class="text-xs text-slate-500">{{ $room->hotel?->name ?? 'StayEase property' }} · Floor {{ $room->floor?->floor_number ?? '—' }}</p><h2>Room {{ $room->room_number }}</h2><div class="room-price">${{ number_format($room->price_per_night,2) }} <small class="muted text-xs font-normal">/ night</small></div><div class="flex flex-wrap gap-2 mt-1"><span class="text-xs text-slate-500 bg-slate-100 rounded-lg px-2 py-1">♙ {{ $room->capacity }} guest(s)</span>@if($room->amenities->isNotEmpty())<span class="text-xs text-slate-500 bg-slate-100 rounded-lg px-2 py-1">✦ {{ $room->amenities->count() }} amenities</span>@endif</div><p class="mt-1">{{ $room->description ?: 'A comfortable room with thoughtful essentials for a relaxing stay.' }}</p><div class="flex flex-wrap gap-2 mt-3"><a class="btn gray" href="{{ route('customer.rooms.show',$room) }}">Details</a><a class="btn" href="{{ route('customer.bookings.create',['room_id'=>$room->id]) }}">Book this room →</a></div></div>
            </article>
        @empty
            <div class="card text-center py-12 md:col-span-2 xl:col-span-3"><div class="text-3xl mb-3">⌕</div><h3 class="font-extrabold text-slate-800">No matching rooms found</h3><p class="text-sm text-slate-500 mt-2">Try changing your search or clearing the filters.</p><a class="btn mt-4" href="{{ route('customer.rooms.index') }}">Clear filters</a></div>
        @endforelse
    </div>
    <div class="pagination">{{ $rooms->links() }}</div>
@endsection