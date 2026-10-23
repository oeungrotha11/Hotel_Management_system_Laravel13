<?php

namespace Tests\Feature;

use App\Models\Floor;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RoomImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_room_image(): void
    {
        Storage::fake('public');

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $hotel = Hotel::create([
            'name' => 'Royal Hotel',
            'city' => 'Colombo',
            'address' => '123 Main Street',
        ]);

        $floor = Floor::create([
            'hotel_id' => $hotel->id,
            'floor_number' => 2,
            'name' => 'Deluxe Floor',
        ]);

        $file = UploadedFile::fake()->image('room-101.jpg', 600, 400);
        $galleryFile = UploadedFile::fake()->image('room-101-2.jpg', 600, 400);

        $response = $this->actingAs($admin)
            ->post('/admin/rooms', [
                'room_number' => '101',
                'hotel_id' => $hotel->id,
                'floor_id' => $floor->id,
                'type' => 'Double',
                'price_per_night' => 120,
                'capacity' => 2,
                'status' => 'available',
                'description' => 'Nice room',
                'main_image' => $file,
                'gallery_images' => [$galleryFile],
            ]);

        $response->assertRedirect('/admin/rooms');

        $room = Room::first();
        $this->assertNotNull($room);
        $this->assertStringContainsString('rooms/', $room->main_image);
        $this->assertTrue(Storage::disk('public')->exists($room->main_image));
        $this->assertNotEmpty($room->roomImages);
        $this->assertTrue(Storage::disk('public')->exists($room->roomImages->first()->image_path));
    }
}
