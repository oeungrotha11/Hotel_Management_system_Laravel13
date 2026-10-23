@extends('layouts.app')
@section('title', 'Manage Rooms')
@section('content')
    <div class="row">
        <div>
            <h1>Rooms</h1>
            <p class="muted">Create, view, update and delete hotel rooms.</p>
        </div>
        <div style="text-align:right"><a class="btn" href="{{ route('admin.rooms.create') }}">+ Add room</a></div>
    </div>
    <div class="card">
        <form method="GET" action="{{ route('admin.rooms.index') }}" class="row">
            <div><label>Search by room number or type<input name="search" value="{{ request('search') }}"
                        placeholder="e.g. 101 or Suite"></label></div>
            <div><label>Status<select name="status">
                        <option value="">All statuses</option>@foreach(['available', 'occupied', 'maintenance'] as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select></label></div>
            <div style="flex:0 0 auto"><button class="btn">Search / Filter</button> <a class="btn gray"
                    href="{{ route('admin.rooms.index') }}">Reset</a></div>
        </form>
    </div>
    <div class="card table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Hotel</th>
                    <th>Floor</th>
                    <th>Type</th>
                    <th>Price/night</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                    <tr>
                        <td>{{ $room->room_number }}</td>
                        <td>{{ $room->hotel?->name ?? '—' }}</td>
                        <td>{{ $room->floor ? 'Floor ' . $room->floor->floor_number : '—' }}</td>
                        <td>{{ $room->type }}</td>
                        <td>${{ number_format($room->price_per_night, 2) }}</td>
                        <td>{{ $room->capacity }}</td>
                        <td>{{ ucfirst($room->status) }}</td>
                        <td>
                            <div class="actions"><a class="btn gray" href="{{ route('admin.rooms.show', $room) }}">View</a><a
                                    class="btn green" href="{{ route('admin.rooms.edit', $room) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}"
                                    onsubmit="return confirm('Delete this room?')">@csrf @method('DELETE')<button
                                        class="btn red">Delete</button></form>
                            </div>
                        </td>
                </tr>@empty<tr>
                    <td colspan="8">No rooms found.</td>
                </tr>@endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $rooms->links() }}</div>
    </div>
@endsection