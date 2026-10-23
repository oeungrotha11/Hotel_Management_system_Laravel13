<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

class CustomerRoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::query()->with(['hotel', 'floor', 'amenities'])
            ->where('status', 'available')
            ->when($request->filled('search'), fn ($q) => $q->where(fn ($w) => $w
                ->where('room_number', 'like', '%'.$request->search.'%')
                ->orWhere('type', 'like', '%'.$request->search.'%')
                ->orWhereHas('hotel', fn ($hotelQuery) => $hotelQuery->where('name', 'like', '%'.$request->search.'%'))
                ->orWhereHas('floor', fn ($floorQuery) => $floorQuery->where('name', 'like', '%'.$request->search.'%'))))
            ->when($request->filled('capacity'), fn ($q) => $q->where('capacity', '>=', (int) $request->capacity))
            ->when($request->filled('hotel_id'), fn ($q) => $q->where('hotel_id', $request->hotel_id))
            ->orderBy('price_per_night')->paginate(9)->withQueryString();

        return view('customer.rooms.index', [
            'rooms' => $rooms,
            'hotels' => Hotel::orderBy('name')->get(),
        ]);
    }

    public function show(Room $room)
    {
        abort_unless($room->status === 'available', 404);

        $room->load(['hotel', 'floor', 'amenities', 'roomImages']);

        return view('customer.rooms.show', compact('room'));
    }
}
