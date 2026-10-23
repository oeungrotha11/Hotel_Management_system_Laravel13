@extends('layouts.app')
@section('title', $room->exists ? 'Edit Room' : 'Add Room')
@section('content')
    <div class="card">
        <h1>{{ $room->exists ? 'Edit Room' : 'Add a Room' }}</h1>
        <form method="POST" action="{{ $room->exists ? route('admin.rooms.update', $room) : route('admin.rooms.store') }}" enctype="multipart/form-data">@csrf
            @if($room->exists)@method('PUT')@endif
            <div class="row"><label>Room number<input name="room_number" value="{{ old('room_number', $room->room_number) }}"
                        required maxlength="20"></label><label>Room type<select name="type"
                        required>@foreach(['Single', 'Double', 'Twin', 'Suite', 'Deluxe'] as $type)
                        <option @selected(old('type', $room->type) === $type)>{{ $type }}</option>@endforeach
                    </select></label></div>
            <div class="row"><label>Price per night ($)<input type="number" min="0" step="0.01" name="price_per_night"
                        value="{{ old('price_per_night', $room->price_per_night) }}" required></label><label>Capacity
                    (guests)<input type="number" min="1" max="20" name="capacity"
                        value="{{ old('capacity', $room->capacity ?? 1) }}" required></label></div>
            <label>Status<select name="status">@foreach(['available', 'occupied', 'maintenance'] as $status)
                <option value="{{ $status }}" @selected(old('status', $room->status ?? 'available') === $status)>
            {{ ucfirst($status) }}</option>@endforeach
                </select></label>
            <div class="row">
                <label>Hotel<select name="hotel_id" required>
                    <option value="">Select hotel</option>
                    @foreach($hotels as $hotel)
                        <option value="{{ $hotel->id }}" @selected(old('hotel_id', $room->hotel_id) == $hotel->id)>{{ $hotel->name }}</option>
                    @endforeach
                </select></label>
                <label>Floor<select name="floor_id" required>
                    <option value="">Select floor</option>
                    @foreach($floors as $floor)
                        <option value="{{ $floor->id }}" @selected(old('floor_id', $room->floor_id) == $floor->id)>{{ $floor->hotel?->name ?? 'Hotel' }} - Floor {{ $floor->floor_number }}</option>
                    @endforeach
                </select></label>
            </div>
            <div style="margin: 18px 0;">
                <label style="display:block; margin-bottom:8px; font-weight:600;">Amenities</label>
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:10px;">
                    @foreach($amenities as $amenity)
                        <label style="display:flex; align-items:center; gap:8px; background:#f8fafc; padding:10px 12px; border:1px solid #e2e8f0; border-radius:10px;">
                            <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                                @checked(in_array($amenity->id, old('amenities', $room->exists ? $room->amenities->pluck('id')->toArray() : [])))>
                            {{ $amenity->name }}
                        </label>
                    @endforeach
                </div>
            </div>
            <label>Main image<input type="file" name="main_image" accept="image/*"></label>
            <label>Extra room photos<input type="file" name="gallery_images[]" accept="image/*" multiple></label>
            @if($room->main_image)
                <p class="muted">Current image: {{ basename($room->main_image) }}</p>
            @endif
            <label>Description<textarea name="description"
                    rows="3">{{ old('description', $room->description) }}</textarea></label><button class="btn">Save
                room</button> <a class="btn gray" href="{{ route('admin.rooms.index') }}">Cancel</a>
        </form>
</div>@endsection