<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::withCount('rooms')->latest()->paginate(10);

        return view('amenities.index', compact('amenities'));
    }

    public function create()
    {
        return view('amenities.create', ['amenity' => new Amenity()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:amenities,name'],
        ]);

        Amenity::create($data);

        return redirect()->route('admin.amenities.index')->with('success', 'Amenity created.');
    }

    public function show(Amenity $amenity)
    {
        return view('amenities.show', compact('amenity'));
    }

    public function edit(Amenity $amenity)
    {
        return view('amenities.create', compact('amenity'));
    }

    public function update(Request $request, Amenity $amenity)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('amenities', 'name')->ignore($amenity->id)],
        ]);

        $amenity->update($data);

        return redirect()->route('admin.amenities.index')->with('success', 'Amenity updated.');
    }

    public function destroy(Amenity $amenity)
    {
        if ($amenity->rooms()->exists()) {
            return back()->with('error', 'Cannot delete an amenity that is attached to rooms.');
        }

        $amenity->delete();

        return redirect()->route('admin.amenities.index')->with('success', 'Amenity deleted.');
    }
}
