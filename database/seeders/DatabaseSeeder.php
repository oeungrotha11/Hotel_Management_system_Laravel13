<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([['101', 'Single', 20, 1], ['102', 'Double', 35, 2], ['201', 'Suite', 80, 4], ['202', 'Deluxe', 60, 3]] as [$number, $type, $price, $capacity]) {
            Room::firstOrCreate(['room_number' => $number], ['type' => $type, 'price_per_night' => $price, 'capacity' => $capacity, 'status' => 'available', 'description' => 'Sample room for demonstration']);
        }
    }
}
