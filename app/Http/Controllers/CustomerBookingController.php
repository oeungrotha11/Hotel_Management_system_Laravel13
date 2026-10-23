<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class CustomerBookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = $request->user()->bookings()->with('room')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()->paginate(10)->withQueryString();
        return view('customer.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::where('status', 'available')->orderBy('price_per_night')->get();
        return view('customer.bookings.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $room = Room::findOrFail($data['room_id']);
        abort_unless($room->status === 'available', 422, 'This room is not currently available.');
        if ((int) $data['guests'] > $room->capacity) {
            throw ValidationException::withMessages(['guests' => 'This room can accommodate up to '.$room->capacity.' guest(s).']);
        }
        $this->ensureNoOverlap($room, $data['check_in'], $data['check_out']);

        $nights = Carbon::parse($data['check_in'])->diffInDays(Carbon::parse($data['check_out']));
        $user = $request->user();
        $booking = $user->bookings()->create([
            'room_id' => $room->id,
            'guest_name' => $user->name,
            'guest_email' => $user->email,
            'check_in' => $data['check_in'],
            'check_out' => $data['check_out'],
            'guests' => $data['guests'],
            'status' => 'pending',
            'total_price' => $room->price_per_night * $nights,
        ]);

        return redirect()->route('customer.bookings.show', $booking)->with('success', 'Booking request submitted. It is pending confirmation.');
    }

    public function show(Request $request, Booking $booking)
    {
        abort_unless($booking->user_id === $request->user()->id, 404);
        $booking->load('room');
        return view('customer.bookings.show', compact('booking'));
    }

    public function cancel(Request $request, Booking $booking)
    {
        abort_unless($booking->user_id === $request->user()->id, 404);
        if (!in_array($booking->status, ['pending', 'confirmed'], true) || $booking->check_in->isPast()) {
            return back()->with('error', 'This booking can no longer be cancelled online. Please contact the hotel.');
        }
        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Booking cancelled.');
    }

    private function ensureNoOverlap(Room $room, string $checkIn, string $checkOut, ?int $ignoreBookingId = null): void
    {
        $conflict = Booking::where('room_id', $room->id)
            ->whereNotIn('status', ['cancelled', 'checked_out'])
            ->whereDate('check_in', '<', $checkOut)
            ->whereDate('check_out', '>', $checkIn)
            ->when($ignoreBookingId, fn ($q) => $q->where('id', '!=', $ignoreBookingId))
            ->exists();

        if ($conflict) {
            throw ValidationException::withMessages(['room_id' => 'This room is already booked for some of those dates. Please choose different dates or another room.']);
        }
    }
}
