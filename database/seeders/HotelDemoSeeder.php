<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Floor;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class HotelDemoSeeder extends Seeder
{
    public function run(): void
    {
        Booking::query()->delete();
        Room::query()->delete();
        Floor::query()->delete();
        Hotel::query()->delete();

        $hotel = Hotel::create([
            'name' => 'StayEase Grand Hotel',
            'city' => 'Colombo',
            'address' => '123 Galle Road, Colombo 03',
            'description' => 'A premium city hotel for demo and testing purposes.',
        ]);

        $roomTypes = ['Single', 'Double', 'Twin', 'Suite', 'Deluxe'];
        $amenityNames = [
            'Wi-Fi',
            'Air Conditioning',
            'TV',
            'Breakfast',
            'Parking',
            'Pool',
            'Workspace',
            'Laundry',
            'Housekeeping',
            'Balcony',
        ];
        $imageMap = $this->buildLocalImageMap();

        $amenityIds = [];
        foreach ($amenityNames as $name) {
            $amenity = Amenity::firstOrCreate(['name' => $name]);
            $amenityIds[$name] = $amenity->id;
        }

        foreach (range(1, 5) as $floorNumber) {
            $floor = $hotel->floors()->firstOrCreate(
                ['floor_number' => $floorNumber],
                [
                    'name' => 'Floor ' . $floorNumber,
                    'description' => 'Sample floor for hotel demo data.',
                ]
            );

            foreach (range(1, 10) as $roomIndex) {
                $roomNumber = ($floorNumber * 100) + $roomIndex;
                $type = $roomTypes[($roomIndex - 1) % count($roomTypes)];

                $price = match ($type) {
                    'Single' => 55,
                    'Double' => 90,
                    'Twin' => 100,
                    'Suite' => 180,
                    'Deluxe' => 150,
                    default => 80,
                };

                $capacity = match ($type) {
                    'Single' => 1,
                    'Double' => 2,
                    'Twin' => 2,
                    'Suite' => 4,
                    'Deluxe' => 3,
                    default => 2,
                };

                $room = Room::create([
                    'room_number' => (string) $roomNumber,
                    'hotel_id' => $hotel->id,
                    'floor_id' => $floor->id,
                    'type' => $type,
                    'price_per_night' => $price,
                    'capacity' => $capacity,
                    'status' => 'available',
                    'description' => 'Sample room created by the demo seeder.',
                ]);

                $selectedAmenities = match ($type) {
                    'Single' => ['Wi-Fi', 'Air Conditioning', 'TV'],
                    'Double' => ['Wi-Fi', 'Air Conditioning', 'Workspace', 'Housekeeping'],
                    'Twin' => ['Wi-Fi', 'Air Conditioning', 'TV', 'Breakfast'],
                    'Suite' => ['Wi-Fi', 'Air Conditioning', 'Pool', 'Breakfast', 'Balcony'],
                    'Deluxe' => ['Wi-Fi', 'Air Conditioning', 'Pool', 'Breakfast', 'Laundry', 'TV'],
                    default => ['Wi-Fi', 'Air Conditioning'],
                };

                $room->amenities()->sync(array_values(array_filter(array_map(fn ($name) => $amenityIds[$name] ?? null, $selectedAmenities))));
                $this->attachLocalRoomImages($room, $type, $imageMap);
            }
        }
    }

    private function attachLocalRoomImages(Room $room, string $type, array $imageMap): void
    {
        $files = $imageMap[$this->normalizeRoomTypeKey($type)] ?? [];

        if (empty($files)) {
            return;
        }

        $mainImagePath = $this->copyImageToPublicStorage($files[0]);
        if ($mainImagePath) {
            $room->update(['main_image' => $mainImagePath]);
        }

        foreach (array_slice($files, 1) as $index => $file) {
            $galleryPath = $this->copyImageToPublicStorage($file);
            if (!$galleryPath) {
                continue;
            }

            RoomImage::create([
                'room_id' => $room->id,
                'image_path' => $galleryPath,
                'sort_order' => $index,
            ]);
        }
    }

    private function buildLocalImageMap(): array
    {
        $possibleRoots = [
            base_path('database/seeders/demo_images'),
            base_path('storage/app/demo_images'),
            base_path('public/demo_images'),
        ];

        $map = [];

        foreach ($possibleRoots as $root) {
            if (!is_dir($root)) {
                continue;
            }

            $directories = glob($root . '/*', GLOB_ONLYDIR);

            foreach ($directories as $directory) {
                $key = $this->normalizeRoomTypeKey(basename($directory));
                $files = glob($directory . DIRECTORY_SEPARATOR . '*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);

                if ($files !== false && !empty($files)) {
                    sort($files, SORT_STRING);
                    $map[$key] = $files;
                }
            }
        }

        return $map;
    }

    private function copyImageToPublicStorage(string $sourcePath): ?string
    {
        if (!is_file($sourcePath)) {
            return null;
        }

        $extension = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION) ?: 'jpg');
        $destinationPath = 'rooms/' . uniqid('demo_', true) . '.' . $extension;
        $contents = file_get_contents($sourcePath);

        if ($contents === false) {
            return null;
        }

        Storage::disk('public')->put($destinationPath, $contents);

        return $destinationPath;
    }

    private function normalizeRoomTypeKey(string $type): string
    {
        return strtolower(str_replace([' ', '-', '_'], '', $type));
    }
}
