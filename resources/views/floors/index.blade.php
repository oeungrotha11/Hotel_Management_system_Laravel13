@extends('layouts.app')
@section('title', 'Floors')
@section('content')
<div class="row">
    <div><h1>Floors</h1><p class="muted">Track every floor inside each hotel.</p></div>
    <div style="text-align:right"><a class="btn" href="{{ route('admin.floors.create') }}">+ Add floor</a></div>
</div>

<div class="card table-wrap">
    <table>
        <thead>
            <tr>
                <th>Hotel</th>
                <th>Floor</th>
                <th>Name</th>
                <th>Rooms</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($floors as $floor)
                <tr>
                    <td>{{ $floor->hotel?->name ?? '—' }}</td>
                    <td>{{ $floor->floor_number }}</td>
                    <td>{{ $floor->name ?: 'Floor '.$floor->floor_number }}</td>
                    <td>{{ $floor->rooms()->count() }}</td>
                    <td>
                        <div class="actions">
                            <a class="btn gray" href="{{ route('admin.floors.show', $floor) }}">View</a>
                            <a class="btn green" href="{{ route('admin.floors.edit', $floor) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.floors.destroy', $floor) }}" onsubmit="return confirm('Delete this floor?')">
                                @csrf @method('DELETE')
                                <button class="btn red">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No floors found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $floors->links() }}</div>
</div>
@endsection
