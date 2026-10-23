<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'rooms' => Room::count(),
            'availableRooms' => Room::where('status', 'available')->count(),
            'bookings' => Booking::count(),
            'pendingBookings' => Booking::where('status', 'pending')->count(),
            'customers' => User::where('role', 'customer')->count(),
            'recentBookings' => Booking::with(['room', 'user'])->latest()->take(8)->get(),
        ]);
    }
}
