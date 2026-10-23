<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with('room', 'user')
            ->when($request->filled('search'), fn ($q) => $q->where(fn ($w) => $w
                ->where('guest_name', 'like', '%'.$request->search.'%')
                ->orWhere('guest_email', 'like', '%'.$request->search.'%')
                ->orWhereHas('room', fn ($r) => $r->where('room_number', 'like', '%'.$request->search.'%'))))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()->paginate(10)->withQueryString();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        return view('bookings.create', ['booking' => new Booking(), 'rooms' => Room::orderBy('room_number')->get()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $room = Room::findOrFail($data['room_id']);
        $this->checkRoomAndDates($room, $data['check_in'], $data['check_out'], (int) $data['guests']);
        $data['user_id'] = DB::table('users')->where('email', $data['guest_email'])->value('id') ?? $request->user()->id;
        $data['total_price'] = $room->price_per_night * Carbon::parse($data['check_in'])->diffInDays(Carbon::parse($data['check_out']));
        Booking::create($data);
        return redirect()->route('admin.bookings.index')->with('success', 'Booking created.');
    }

    public function show(Booking $booking)
    {
        $booking->load('room', 'user');
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        return view('bookings.create', ['booking' => $booking, 'rooms' => Room::orderBy('room_number')->get()]);
    }

    public function update(Request $request, Booking $booking)
    {
        $data = $this->validated($request);
        $room = Room::findOrFail($data['room_id']);
        $this->checkRoomAndDates($room, $data['check_in'], $data['check_out'], (int) $data['guests'], $booking->id);
        $data['total_price'] = $room->price_per_night * Carbon::parse($data['check_in'])->diffInDays(Carbon::parse($data['check_out']));
        unset($data['user_id']);
        $booking->update($data);
        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'required|string|max:100',
            'guest_email' => 'required|email|max:255',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:20',
            'status' => ['required', Rule::in(['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'])],
        ]);
    }

    private function checkRoomAndDates(Room $room, string $checkIn, string $checkOut, int $guests, ?int $ignoreId = null): void
    {
        if ($guests > $room->capacity) {
            throw ValidationException::withMessages(['guests' => 'This room can accommodate up to '.$room->capacity.' guest(s).']);
        }
        if ($room->status === 'maintenance') {
            throw ValidationException::withMessages(['room_id' => 'A room under maintenance cannot be booked.']);
        }
        $conflict = Booking::where('room_id', $room->id)
            ->whereNotIn('status', ['cancelled', 'checked_out'])
            ->whereDate('check_in', '<', $checkOut)
            ->whereDate('check_out', '>', $checkIn)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists();
        if ($conflict) {
            throw ValidationException::withMessages(['room_id' => 'This room is already booked for some of those dates.']);
        }
    }
}
