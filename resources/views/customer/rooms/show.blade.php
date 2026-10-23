@extends('layouts.app')
@section('title','Room '.$room->room_number)
@section('content')
<div class="card">
    <p class="muted">{{ $room->hotel?->name ?? 'Hotel' }} · Floor {{ $room->floor?->floor_number ?? '—' }} · {{ $room->type }} room</p>
    <h1>Room {{ $room->room_number }}</h1>

    @if($room->main_image)
        <img src="{{ \Illuminate\Support\Facades\Storage::url($room->main_image) }}" alt="Room {{ $room->room_number }}" style="width:100%; max-height:360px; object-fit:cover; border-radius:12px; margin-bottom:18px;">
    @endif

    <div class="room-price">${{ number_format($room->price_per_night,2) }} / night</div>
    <p><b>Hotel:</b> {{ $room->hotel?->name ?? '—' }}</p>
    <p><b>Location:</b> {{ $room->hotel?->city ?? '—' }} · {{ $room->hotel?->address ?? '—' }}</p>
    <p><b>Floor:</b> {{ $room->floor ? 'Floor '.$room->floor->floor_number : '—' }}</p>
    <p><b>Capacity:</b> {{ $room->capacity }} guest(s)</p>
    <p><b>Amenities:</b>
        @if($room->amenities->isNotEmpty())
            {{ $room->amenities->pluck('name')->implode(', ') }}
        @else
            No amenities listed
        @endif
    </p>
    <p><b>Description:</b> {{ $room->description ?: 'A comfortable room for your stay.' }}</p>

    @if($room->roomImages->isNotEmpty())
        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:12px; margin:18px 0;">
            @foreach($room->roomImages as $image)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($image->image_path) }}" alt="Room {{ $room->room_number }} gallery image" style="width:100%; height:140px; object-fit:cover; border-radius:10px; border:1px solid #e2e8f0;">
            @endforeach
        </div>
    @endif

    <a class="btn" href="{{ route('customer.bookings.create',['room_id'=>$room->id]) }}">Book this room</a>
    <a class="btn gray" href="{{ route('customer.rooms.index') }}">Back to rooms</a>
</div>
@endsection
