@extends('layouts.app')
@section('title', 'Amenities')
@section('content')
    <div class="row">
        <div>
            <h1>Amenities</h1>
            <p class="muted">Manage the room features that customers can choose from.</p>
        </div>
        <div style="text-align:right"><a class="btn" href="{{ route('admin.amenities.create') }}">+ Add amenity</a></div>
    </div>

    <div class="card table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Rooms using it</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($amenities as $amenity)
                    <tr>
                        <td>{{ $amenity->name }}</td>
                        <td>{{ $amenity->rooms_count }}</td>
                        <td>
                            <div class="actions">
                                <a class="btn gray" href="{{ route('admin.amenities.show', $amenity) }}">View</a>
                                <a class="btn green" href="{{ route('admin.amenities.edit', $amenity) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.amenities.destroy', $amenity) }}" onsubmit="return confirm('Delete this amenity?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn red">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3">No amenities found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $amenities->links() }}</div>
    </div>
@endsection
