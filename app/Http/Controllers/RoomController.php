<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Amenity;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::query()->when($request->filled('search'), fn($q) => $q->where(fn($w) => $w->where('room_number', 'like', '%' . $request->search . '%')->orWhere('type', 'like', '%' . $request->search . '%')))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))->latest()->paginate(10)->withQueryString();
        return view('rooms.index', compact('rooms'));
    }
    public function create()
    {
        return view('rooms.create', [
            'room' => new Room(),
            'hotels' => Hotel::orderBy('name')->get(),
            'floors' => Floor::with('hotel')->orderBy('hotel_id')->orderBy('floor_number')->get(),
            'amenities' => Amenity::orderBy('name')->get(),
        ]);
    }
    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('rooms', 'public');
        }

        $room = Room::create($data);
        $room->amenities()->sync($request->input('amenities', []));

        $this->storeGalleryImages($request, $room);

        return redirect()->route('admin.rooms.index')->with('success', 'Room created.');
    }
    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }
    public function edit(Room $room)
    {
        return view('rooms.create', [
            'room' => $room,
            'hotels' => Hotel::orderBy('name')->get(),
            'floors' => Floor::with('hotel')->orderBy('hotel_id')->orderBy('floor_number')->get(),
            'amenities' => Amenity::orderBy('name')->get(),
        ]);
    }
    public function update(Request $request, Room $room)
    {
        $data = $this->validated($request, $room);

        if ($request->hasFile('main_image')) {
            if ($room->main_image && Storage::disk('public')->exists($room->main_image)) {
                Storage::disk('public')->delete($room->main_image);
            }

            $data['main_image'] = $request->file('main_image')->store('rooms', 'public');
        }

        $room->update($data);
        $room->amenities()->sync($request->input('amenities', []));
        $this->storeGalleryImages($request, $room);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated.');
    }
    public function destroy(Room $room)
    {
        if ($room->bookings()->exists()) return back()->with('error', 'Cannot delete a room that has bookings.');

        foreach ($room->roomImages as $image) {
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        if ($room->main_image && Storage::disk('public')->exists($room->main_image)) {
            Storage::disk('public')->delete($room->main_image);
        }

        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted.');
    }
    private function validated(Request $request, ?Room $room = null): array
    {
        return $request->validate([
            'room_number' => ['required', 'string', 'max:20', Rule::unique('rooms', 'room_number')->ignore($room?->id)],
            'hotel_id' => ['nullable', 'exists:hotels,id'],
            'floor_id' => ['nullable', 'exists:floors,id'],
            'type' => 'required|in:Single,Double,Twin,Suite,Deluxe',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1|max:20',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'nullable|string|max:1000',
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['integer', 'exists:amenities,id'],
            'main_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);
    }

    private function storeGalleryImages(Request $request, Room $room): void
    {
        if (!$request->hasFile('gallery_images')) {
            return;
        }

        $sortOrder = 0;

        foreach ($request->file('gallery_images') as $galleryImage) {
            $path = $galleryImage->store('rooms/gallery', 'public');

            RoomImage::create([
                'room_id' => $room->id,
                'image_path' => $path,
                'sort_order' => $sortOrder,
            ]);

            $sortOrder++;
        }
    }
}
