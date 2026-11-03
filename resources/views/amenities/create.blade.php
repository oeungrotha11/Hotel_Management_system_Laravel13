@extends('layouts.app')
@section('title', $amenity->exists ? 'Edit Amenity' : 'Add Amenity')
@section('content')
    <div class="card">
        <h1>{{ $amenity->exists ? 'Edit Amenity' : 'Add an Amenity' }}</h1>

        <form method="POST" action="{{ $amenity->exists ? route('admin.amenities.update', $amenity) : route('admin.amenities.store') }}">
            @csrf
            @if($amenity->exists)
                @method('PUT')
            @endif

            <label>
                Amenity name
                <input type="text" name="name" value="{{ old('name', $amenity->name) }}" required maxlength="100" placeholder="Wi-Fi" class="mt-2 w-full h-12 rounded-xl border border-slate-200 bg-white px-3 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">
            </label>

            <button class="btn">Save amenity</button>
            <a class="btn gray" href="{{ route('admin.amenities.index') }}">Cancel</a>
        </form>
    </div>
@endsection
