@extends('layouts.app')
@section('title', $hotel->exists ? 'Edit Hotel' : 'Add Hotel')
@section('content')
<div class="card">
    <h1>{{ $hotel->exists ? 'Edit Hotel' : 'Add a Hotel' }}</h1>
    <form method="POST" action="{{ $hotel->exists ? route('admin.hotels.update', $hotel) : route('admin.hotels.store') }}" enctype="multipart/form-data">
        @csrf
        @if($hotel->exists)
            @method('PUT')
        @endif

        <label>Name<input name="name" value="{{ old('name', $hotel->name) }}" required class="mt-2 w-full h-12 rounded-xl border border-slate-200 bg-white px-3 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"></label>
        <div class="row">
            <label>City<input name="city" value="{{ old('city', $hotel->city) }}" class="mt-2 w-full h-12 rounded-xl border border-slate-200 bg-white px-3 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"></label>
            <label>Address<input name="address" value="{{ old('address', $hotel->address) }}" class="mt-2 w-full h-12 rounded-xl border border-slate-200 bg-white px-3 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"></label>
        </div>

        <label>
            Cover image
            <input type="file" name="cover_image" accept="image/*" class="mt-2 block w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-base text-slate-800 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-blue-700">
        </label>

        @if($hotel->cover_image)
            <div style="margin-bottom: 16px;">
                <p class="muted">Current image</p>
                <img src="{{ asset('storage/' . $hotel->cover_image) }}" alt="{{ $hotel->name }}" style="max-width: 260px; max-height: 180px; object-fit: cover; border-radius: 12px; border: 1px solid #dbeafe;">
            </div>
        @endif

        <label>Description<textarea name="description" rows="4" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">{{ old('description', $hotel->description) }}</textarea></label>

        <button class="btn">Save hotel</button>
        <a class="btn gray" href="{{ route('admin.hotels.index') }}">Cancel</a>
    </form>
</div>
@endsection
