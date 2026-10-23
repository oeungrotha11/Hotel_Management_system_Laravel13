@extends('layouts.app')
@section('title', $hotel->exists ? 'Edit Hotel' : 'Add Hotel')
@section('content')
<div class="card">
    <h1>{{ $hotel->exists ? 'Edit Hotel' : 'Add a Hotel' }}</h1>
    <form method="POST" action="{{ $hotel->exists ? route('admin.hotels.update', $hotel) : route('admin.hotels.store') }}">
        @csrf
        @if($hotel->exists)
            @method('PUT')
        @endif

        <label>Name<input name="name" value="{{ old('name', $hotel->name) }}" required></label>
        <div class="row">
            <label>City<input name="city" value="{{ old('city', $hotel->city) }}"></label>
            <label>Address<input name="address" value="{{ old('address', $hotel->address) }}"></label>
        </div>
        <label>Cover image URL<input name="cover_image" value="{{ old('cover_image', $hotel->cover_image) }}" placeholder="https://example.com/image.jpg"></label>
        <label>Description<textarea name="description" rows="4">{{ old('description', $hotel->description) }}</textarea></label>

        <button class="btn">Save hotel</button>
        <a class="btn gray" href="{{ route('admin.hotels.index') }}">Cancel</a>
    </form>
</div>
@endsection
