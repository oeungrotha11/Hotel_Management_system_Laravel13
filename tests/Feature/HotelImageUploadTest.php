<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HotelImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_hotel_cover_image(): void
    {
        Storage::fake('public');

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $file = UploadedFile::fake()->image('hotel-cover.jpg', 1200, 800);

        $response = $this->actingAs($admin)
            ->post('/admin/hotels', [
                'name' => 'Ocean View Hotel',
                'city' => 'Galle',
                'address' => '22 Palm Road',
                'description' => 'Beautiful hotel by the sea',
                'cover_image' => $file,
            ]);

        $response->assertRedirect('/admin/hotels');

        $hotel = \App\Models\Hotel::first();
        $this->assertNotNull($hotel);
        $this->assertStringContainsString('hotels/', $hotel->cover_image);
        $this->assertTrue(Storage::disk('public')->exists($hotel->cover_image));
    }
}
