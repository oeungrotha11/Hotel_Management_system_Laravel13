@extends('layouts.app')
@section('title', $floor->name ?: 'Floor '.$floor->floor_number)
@section('content')
<div class="card">
    <h1>{{ $floor->name ?: 'Floor '.$floor->floor_number }}</h1>
    <p><b>Hotel:</b> {{ $floor->hotel?->name ?? '—' }}</p>
    <p><b>Floor number:</b> {{ $floor->floor_number }}</p>
    <p><b>Description:</b> {{ $floor->description ?: '—' }}</p>
    <a class="btn green" href="{{ route('admin.floors.edit', $floor) }}">Edit floor</a>
    <a class="btn gray" href="{{ route('admin.floors.index') }}">Back</a>
</div>
@endsection
