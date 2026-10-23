@extends('layouts.app')
@section('title', $hotel->name)
@section('content')
<div class="card">
    <h1>{{ $hotel->name }}</h1>
    <p><b>City:</b> {{ $hotel->city ?: '—' }}</p>
    <p><b>Address:</b> {{ $hotel->address ?: '—' }}</p>
    <p><b>Description:</b> {{ $hotel->description ?: '—' }}</p>
    @if($hotel->cover_image)
        <img src="{{ $hotel->cover_image }}" alt="{{ $hotel->name }}" style="max-width: 100%; height: 220px; object-fit: cover; border-radius: 12px; margin: 12px 0;">
    @endif
    <a class="btn green" href="{{ route('admin.hotels.edit', $hotel) }}">Edit hotel</a>
    <a class="btn gray" href="{{ route('admin.hotels.index') }}">Back</a>
</div>
@endsection
