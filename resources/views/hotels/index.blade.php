@extends('layouts.app')
@section('title', 'Hotels')
@section('content')
<div class="row">
    <div><h1>Hotels</h1><p class="muted">Manage your hotel properties and locations.</p></div>
    <div style="text-align:right"><a class="btn" href="{{ route('admin.hotels.create') }}">+ Add hotel</a></div>
</div>

<div class="card table-wrap">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>City</th>
                <th>Address</th>
                <th>Rooms</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hotels as $hotel)
                <tr>
                    <td>{{ $hotel->name }}</td>
                    <td>{{ $hotel->city ?: '—' }}</td>
                    <td>{{ $hotel->address ?: '—' }}</td>
                    <td>{{ $hotel->rooms_count }}</td>
                    <td>
                        <div class="actions">
                            <a class="btn gray" href="{{ route('admin.hotels.show', $hotel) }}">View</a>
                            <a class="btn green" href="{{ route('admin.hotels.edit', $hotel) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.hotels.destroy', $hotel) }}" onsubmit="return confirm('Delete this hotel?')">
                                @csrf @method('DELETE')
                                <button class="btn red">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No hotels found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">{{ $hotels->links() }}</div>
</div>
@endsection
