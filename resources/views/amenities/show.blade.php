@extends('layouts.app')
@section('title', $amenity->name)
@section('content')
    <div class="card">
        <h1>{{ $amenity->name }}</h1>
        <p><strong>Rooms linked:</strong> {{ $amenity->rooms()->count() }}</p>

        @if($amenity->rooms->isNotEmpty())
            <div class="mt-4">
                <h3>Rooms</h3>
                <ul>
                    @foreach($amenity->rooms as $room)
                        <li>{{ $room->room_number }} - {{ $room->hotel?->name ?? 'Hotel' }} </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="actions mt-4">
            <a class="btn green" href="{{ route('admin.amenities.edit', $amenity) }}">Edit</a>
            <a class="btn gray" href="{{ route('admin.amenities.index') }}">Back</a>
        </div>
    </div>
@endsection
