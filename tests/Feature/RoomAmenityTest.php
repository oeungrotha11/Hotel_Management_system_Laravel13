<?php

namespace Tests\Feature;

use App\Models\Amenity;
use App\Models\Floor;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomAmenityTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_assign_amenities_to_room(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin2@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $hotel = Hotel::create([
            'name' => 'Grand Hotel',
            'city' => 'Negombo',
            'address' => '4 Sea Road',
        ]);

        $floor = Floor::create([
            'hotel_id' => $hotel->id,
            'floor_number' => 1,
            'name' => 'Garden Floor',
        ]);

        $wifi = Amenity::create(['name' => 'Wi-Fi']);
        $pool = Amenity::create(['name' => 'Pool']);

        $response = $this->actingAs($admin)
            ->post('/admin/rooms', [
                'room_number' => '201',
                'hotel_id' => $hotel->id,
                'floor_id' => $floor->id,
                'type' => 'Suite',
                'price_per_night' => 180,
                'capacity' => 3,
                'status' => 'available',
                'description' => 'Suite with amenities',
                'amenities' => [$wifi->id, $pool->id],
            ]);

        $response->assertRedirect('/admin/rooms');

        $room = \App\Models\Room::first();
        $this->assertNotNull($room);
        $this->assertCount(2, $room->amenities);
        $this->assertEqualsCanonicalizing([$wifi->id, $pool->id], $room->amenities->pluck('id')->all());
    }

    public function test_admin_can_remove_a_room_gallery_image(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin3@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $hotel = Hotel::create([
            'name' => 'Ocean View Hotel',
            'city' => 'Kalutara',
            'address' => '10 Beach Road',
        ]);

        $floor = Floor::create([
            'hotel_id' => $hotel->id,
            'floor_number' => 2,
            'name' => 'Ocean Floor',
        ]);

        $room = \App\Models\Room::create([
            'room_number' => '202',
            'hotel_id' => $hotel->id,
            'floor_id' => $floor->id,
            'type' => 'Double',
            'price_per_night' => 140,
            'capacity' => 2,
            'status' => 'available',
            'description' => 'Double room',
        ]);

        $galleryImage = \App\Models\RoomImage::create([
            'room_id' => $room->id,
            'image_path' => 'rooms/gallery/old-photo.jpg',
            'sort_order' => 0,
        ]);

        $response = $this->actingAs($admin)
            ->delete('/admin/rooms/' . $room->id . '/gallery/' . $galleryImage->id);

        $response->assertRedirect();
        $this->assertDatabaseMissing('room_images', ['id' => $galleryImage->id]);
    }
}
