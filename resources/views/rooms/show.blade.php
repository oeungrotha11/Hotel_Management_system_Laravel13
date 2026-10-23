@extends('layouts.app')
@section('title', 'Room Details')
@php use Illuminate\Support\Facades\Storage; @endphp
@section('content')
    <div class="card">
        <h1>Room {{ $room->room_number }}</h1>
        @if($room->main_image)
            <img src="{{ Storage::url($room->main_image) }}" alt="Room {{ $room->room_number }}" style="max-width: 100%; height: 220px; object-fit: cover; border-radius: 12px; margin-bottom: 16px;">
        @endif

        @if($room->roomImages->isNotEmpty())
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:12px; margin:16px 0;">
                @foreach($room->roomImages as $image)
                    <img src="{{ Storage::url($image->image_path) }}" alt="Room {{ $room->room_number }} photo" style="width:100%; height:180px; object-fit:cover; border-radius:12px; border:1px solid #e2e8f0;">
                @endforeach
            </div>
        @endif

        <p><b>Hotel:</b> {{ $room->hotel?->name ?? '—' }}</p>
        <p><b>Floor:</b> {{ $room->floor ? 'Floor '.$room->floor->floor_number : '—' }}</p>
        <p><b>Type:</b> {{ $room->type }}</p>
        <p><b>Price per night:</b> ${{ number_format($room->price_per_night, 2) }}</p>
        <p><b>Capacity:</b> {{ $room->capacity }}</p>
        <p><b>Status:</b> {{ ucfirst($room->status) }}</p>
        <p><b>Amenities:</b>
            @if($room->amenities->isNotEmpty())
                {{ $room->amenities->pluck('name')->implode(', ') }}
            @else
                —
            @endif
        </p>
        <p><b>Description:</b> {{ $room->description ?: '—' }}</p>
        <a class="btn green" href="{{ route('admin.rooms.edit', $room) }}">Edit room</a>
        <a class="btn gray" href="{{ route('admin.rooms.index') }}">Back</a>
    </div>
@endsection