<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (!Schema::hasTable('hotels') || !Schema::hasTable('rooms')) {
            return view('home', ['hotels' => collect(), 'featuredRooms' => collect()]);
        }

        $hotels = Hotel::query()
            ->withCount('rooms')
            ->orderBy('name')
            ->limit(3)
            ->get();

        $featuredRooms = Room::query()
            ->with(['hotel', 'amenities'])
            ->where('status', 'available')
            ->orderBy('price_per_night')
            ->limit(3)
            ->get();

        return view('home', compact('hotels', 'featuredRooms'));
    }
}
