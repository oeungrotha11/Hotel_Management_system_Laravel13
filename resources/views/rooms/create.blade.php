@extends('layouts.app')
@section('title', $room->exists ? 'Edit Room' : 'Add Room')
@section('content')
    <div class="card">
        <h1>{{ $room->exists ? 'Edit Room' : 'Add a Room' }}</h1>
        <form method="POST" action="{{ $room->exists ? route('admin.rooms.update', $room) : route('admin.rooms.store') }}"
            enctype="multipart/form-data">@csrf
            @if($room->exists)@method('PUT')@endif
            <div class="row"><label>Room number<input name="room_number"
                        value="{{ old('room_number', $room->room_number) }}" required maxlength="20" class="mt-2 w-full h-12 rounded-xl border border-slate-200 bg-white px-3 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"></label><label>Room
                    type<select name="type" required class="mt-2 w-full h-12 rounded-xl border border-slate-200 bg-white px-3 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">@foreach(['Single', 'Double', 'Twin', 'Suite', 'Deluxe'] as $type)
                    <option @selected(old('type', $room->type) === $type)>{{ $type }}</option>@endforeach
                    </select></label></div>
            <div class="row"><label>Price per night ($)<input type="number" min="0" step="0.01" name="price_per_night"
                        value="{{ old('price_per_night', $room->price_per_night) }}" required class="mt-2 w-full h-12 rounded-xl border border-slate-200 bg-white px-3 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"></label><label>Capacity
                    (guests)<input type="number" min="1" max="20" name="capacity"
                        value="{{ old('capacity', $room->capacity ?? 1) }}" required class="mt-2 w-full h-12 rounded-xl border border-slate-200 bg-white px-3 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100"></label></div>
            <label>Status<select name="status" class="mt-2 w-full h-12 rounded-xl border border-slate-200 bg-white px-3 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">@foreach(['available', 'occupied', 'maintenance'] as $status)
                <option value="{{ $status }}" @selected(old('status', $room->status ?? 'available') === $status)>
                    {{ ucfirst($status) }}
            </option>@endforeach
                </select></label>
            <div class="row">
                <label>Hotel<select name="hotel_id" required class="mt-2 w-full h-12 rounded-xl border border-slate-200 bg-white px-3 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        <option value="">Select hotel</option>
                        @foreach($hotels as $hotel)
                            <option value="{{ $hotel->id }}" @selected(old('hotel_id', $room->hotel_id) == $hotel->id)>
                                {{ $hotel->name }}
                            </option>
                        @endforeach
                    </select></label>
                <label>Floor<select name="floor_id" required class="mt-2 w-full h-12 rounded-xl border border-slate-200 bg-white px-3 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        <option value="">Select floor</option>
                        @foreach($floors as $floor)
                            <option value="{{ $floor->id }}" @selected(old('floor_id', $room->floor_id) == $floor->id)>
                                {{ $floor->hotel?->name ?? 'Hotel' }} - Floor {{ $floor->floor_number }}
                            </option>
                        @endforeach
                    </select></label>
            </div>
            <div style="margin: 18px 0;">
                <label style="display:block; margin-bottom:10px; font-weight:600;">Amenities</label>
                <div style="display:flex; flex-wrap:wrap; gap:8px;">
                    @foreach($amenities as $amenity)
                        <label style="display:inline-flex; align-items:center; gap:6px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:999px; padding:7px 12px; font-size:12px; font-weight:600; margin:0; cursor:pointer;">
                            <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" @checked(in_array($amenity->id, old('amenities', $room->exists ? $room->amenities->pluck('id')->toArray() : [])))>
                            {{ $amenity->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="row" style="align-items:flex-start;">
                <div style="flex:1;">
                    <label>Main image<input type="file" name="main_image" accept="image/*" id="main_image_input" class="mt-2 block w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-base text-slate-800 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-blue-700"></label>
                    <div id="main_image_preview" style="display:block; margin-top:12px;">
                        <img src="{{ $room->main_image ? asset('storage/' . $room->main_image) : '' }}" alt="Main room preview" style="width:220px; height:150px; object-fit:cover; border-radius:12px; border:1px solid #dbeafe; background:#f8fafc; {{ $room->main_image ? '' : 'display:none;' }}">
                    </div>
                    @if($room->main_image)
                        <p class="muted">Current image: {{ basename($room->main_image) }}</p>
                    @endif
                </div>

                <div style="flex:1;">
                    <label>Extra room photos<input type="file" name="gallery_images[]" accept="image/*" multiple id="gallery_images_input" class="mt-2 block w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-base text-slate-800 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-blue-700"></label>
                    @if($room->exists && $room->roomImages->isNotEmpty())
                        <div style="margin-top:12px; margin-bottom:8px;">
                            <p class="muted" style="margin-bottom:8px;">Current gallery</p>
                            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(110px,1fr)); gap:10px;">
                                @foreach($room->roomImages as $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Current room gallery" style="width:100%; height:90px; object-fit:cover; border-radius:10px; border:1px solid #dbeafe;">
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div id="gallery_images_preview" style="display:none; margin-top:12px; display:grid; grid-template-columns:repeat(auto-fit,minmax(110px,1fr)); gap:10px;"></div>
                </div>
            </div>

            <label>Description<textarea name="description"
                    rows="3" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-base text-slate-800 focus:border-blue-400 focus:outline-none focus:ring-4 focus:ring-blue-100">{{ old('description', $room->description) }}</textarea></label><button class="btn">Save
                room</button> <a class="btn gray" href="{{ route('admin.rooms.index') }}">Cancel</a>
        </form>

        @if($room->exists && $room->roomImages->isNotEmpty())
            <div style="margin-top: 24px;">
                <h3>Current gallery</h3>
                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:14px;">
                    @foreach($room->roomImages as $image)
                        <div style="position:relative; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden; background:#f8fafc;">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Room gallery image" style="width:100%; height:120px; object-fit:cover; display:block;">
                            <form method="POST" action="{{ route('admin.rooms.gallery.destroy', ['room' => $room, 'galleryImage' => $image]) }}" onsubmit="return confirm('Remove this room photo?');" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn red" style="width:100%; border-radius:0; padding:9px 10px; font-size:12px;">Remove</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
</div>

<script>
    const mainImageInput = document.getElementById('main_image_input');
    const mainImagePreview = document.getElementById('main_image_preview');
    const mainImagePreviewImg = mainImagePreview?.querySelector('img');

    if (mainImageInput && mainImagePreview && mainImagePreviewImg) {
        mainImageInput.addEventListener('change', function () {
            const file = this.files && this.files[0];
            if (!file) {
                const hasExisting = !!mainImagePreviewImg.src && !mainImagePreviewImg.src.includes('blob:');
                mainImagePreview.style.display = hasExisting ? 'block' : 'none';
                if (!hasExisting) {
                    mainImagePreviewImg.src = '';
                }
                return;
            }

            const reader = new FileReader();
            reader.onload = function (event) {
                mainImagePreviewImg.src = event.target.result;
                mainImagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }

    const galleryInput = document.getElementById('gallery_images_input');
    const galleryPreview = document.getElementById('gallery_images_preview');

    if (galleryInput && galleryPreview) {
        galleryInput.addEventListener('change', function () {
            const files = Array.from(this.files || []);
            galleryPreview.innerHTML = '';

            if (!files.length) {
                galleryPreview.style.display = 'none';
                return;
            }

            files.forEach((file) => {
                const reader = new FileReader();
                reader.onload = function (event) {
                    const preview = document.createElement('img');
                    preview.src = event.target.result;
                    preview.alt = 'Gallery preview';
                    preview.style.width = '100%';
                    preview.style.height = '90px';
                    preview.style.objectFit = 'cover';
                    preview.style.borderRadius = '10px';
                    preview.style.border = '1px solid #dbeafe';
                    galleryPreview.appendChild(preview);
                    galleryPreview.style.display = 'grid';
                };
                reader.readAsDataURL(file);
            });
        });
    }
</script>
@endsection