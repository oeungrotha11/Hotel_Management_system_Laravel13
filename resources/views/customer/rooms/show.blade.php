@extends('layouts.app')
@section('title','Room '.$room->room_number.' | StayEase')
@section('content')
    <a href="{{ route('customer.rooms.index') }}" class="text-sm font-bold text-blue-700 hover:text-blue-900 inline-flex items-center gap-2 mb-5">← Back to room collection</a>
    <div class="grid lg:grid-cols-[1.15fr_.85fr] gap-6 items-start">
        <section class="card !p-0 overflow-hidden">
            @if($room->main_image)
                <img src="{{ IlluminateSupportFacadesStorage::url($room->main_image) }}" alt="Room {{ $room->room_number }}" class="w-full h-72 sm:h-[420px] object-cover">
            @else
                <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=85" alt="Comfortable hotel room" class="w-full h-72 sm:h-[420px] object-cover">
            @endif
            @if($room->roomImages->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4">@foreach($room->roomImages as $image)<img src="{{ IlluminateSupportFacadesStorage::url($image->image_path) }}" alt="Room {{ $room->room_number }} gallery image" class="w-full h-28 object-cover rounded-xl">@endforeach</div>
            @endif
        </section>
        <section class="card">
            <span class="feature-chip">{{ ucfirst($room->type) }} room</span>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 mt-4">Room {{ $room->room_number }}</h1>
            <p class="text-sm text-slate-500 mt-2">{{ $room->hotel?->name ?? 'StayEase property' }} · Floor {{ $room->floor?->floor_number ?? '—' }}</p>
            <div class="border-y border-slate-100 py-5 my-5"><div class="room-price">${{ number_format($room->price_per_night,2) }} <small class="text-sm text-slate-400 font-medium">/ night</small></div><p class="text-xs text-slate-500 mt-2">Price shown per night before any applicable fees.</p></div>
            <div class="grid grid-cols-2 gap-3 mb-5"><div class="bg-slate-50 rounded-xl p-4"><p class="text-xs text-slate-500">Guest capacity</p><p class="font-extrabold text-slate-800 mt-1">♙ {{ $room->capacity }} guest(s)</p></div><div class="bg-slate-50 rounded-xl p-4"><p class="text-xs text-slate-500">Location</p><p class="font-extrabold text-slate-800 mt-1">{{ $room->hotel?->city ?? '—' }}</p></div></div>
            <h2 class="font-extrabold text-slate-800">About this room</h2><p class="text-sm text-slate-600 leading-6 mt-2">{{ $room->description ?: 'A welcoming, comfortable space designed to help you relax during your stay.' }}</p>
            <h2 class="font-extrabold text-slate-800 mt-5">Amenities</h2>
            <div class="flex flex-wrap gap-2 mt-3">@forelse($room->amenities as $amenity)<span class="rounded-lg bg-blue-50 text-blue-800 px-3 py-2 text-xs font-bold">✓ {{ $amenity->name }}</span>@empty<span class="text-sm text-slate-500">No amenities listed yet.</span>@endforelse</div>
            <a class="btn w-full mt-7 !py-3" href="{{ route('customer.bookings.create',['room_id'=>$room->id]) }}">Continue to booking →</a>
            <p class="text-center text-xs text-slate-400 mt-3">Simple booking. A stay to look forward to.</p>
        </section>
    </div>
@endsection