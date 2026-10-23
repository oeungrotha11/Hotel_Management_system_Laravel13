<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::withCount('rooms')->latest()->paginate(10);

        return view('hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('hotels.create', ['hotel' => new Hotel()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'cover_image' => 'nullable|string|max:255',
        ]);

        Hotel::create($data);

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel created.');
    }

    public function show(Hotel $hotel)
    {
        return view('hotels.show', compact('hotel'));
    }

    public function edit(Hotel $hotel)
    {
        return view('hotels.create', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'cover_image' => 'nullable|string|max:255',
        ]);

        $hotel->update($data);

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel updated.');
    }

    public function destroy(Hotel $hotel)
    {
        if ($hotel->rooms()->exists()) {
            return back()->with('error', 'Cannot delete a hotel that still has rooms.');
        }

        $hotel->delete();

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel deleted.');
    }
}
