@extends('layouts.app')
@section('title', $floor->exists ? 'Edit Floor' : 'Add Floor')
@section('content')
<div class="card">
    <h1>{{ $floor->exists ? 'Edit Floor' : 'Add a Floor' }}</h1>
    <form method="POST" action="{{ $floor->exists ? route('admin.floors.update', $floor) : route('admin.floors.store') }}">
        @csrf
        @if($floor->exists)
            @method('PUT')
        @endif

        <label>Hotel
            <select name="hotel_id" required>
                <option value="">Select a hotel</option>
                @foreach($hotels as $hotel)
                    <option value="{{ $hotel->id }}" @selected(old('hotel_id', $floor->hotel_id) == $hotel->id)>{{ $hotel->name }}</option>
                @endforeach
            </select>
        </label>

        <div class="row">
            <label>Floor number<input type="number" min="1" max="100" name="floor_number" value="{{ old('floor_number', $floor->floor_number) }}" required></label>
            <label>Name<input name="name" value="{{ old('name', $floor->name) }}" placeholder="e.g. Executive Floor"></label>
        </div>

        <label>Description<textarea name="description" rows="4">{{ old('description', $floor->description) }}</textarea></label>

        <button class="btn">Save floor</button>
        <a class="btn gray" href="{{ route('admin.floors.index') }}">Cancel</a>
    </form>
</div>
@endsection
