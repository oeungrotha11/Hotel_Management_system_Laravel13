<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Hotel;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function index()
    {
        $floors = Floor::with('hotel')->latest()->paginate(10);

        return view('floors.index', compact('floors'));
    }

    public function create()
    {
        return view('floors.create', ['floor' => new Floor(), 'hotels' => Hotel::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'floor_number' => 'required|integer|min:1|max:100',
            'name' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
        ]);

        Floor::create($data);

        return redirect()->route('admin.floors.index')->with('success', 'Floor created.');
    }

    public function show(Floor $floor)
    {
        return view('floors.show', compact('floor'));
    }

    public function edit(Floor $floor)
    {
        return view('floors.create', ['floor' => $floor, 'hotels' => Hotel::orderBy('name')->get()]);
    }

    public function update(Request $request, Floor $floor)
    {
        $data = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'floor_number' => 'required|integer|min:1|max:100',
            'name' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
        ]);

        $floor->update($data);

        return redirect()->route('admin.floors.index')->with('success', 'Floor updated.');
    }

    public function destroy(Floor $floor)
    {
        if ($floor->rooms()->exists()) {
            return back()->with('error', 'Cannot delete a floor that still has rooms.');
        }

        $floor->delete();

        return redirect()->route('admin.floors.index')->with('success', 'Floor deleted.');
    }
}
