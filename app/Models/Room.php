<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = ['room_number', 'type', 'price_per_night', 'capacity', 'status', 'description', 'hotel_id', 'floor_id', 'main_image'];
    protected function casts(): array
    {
        return ['price_per_night' => 'decimal:2', 'capacity' => 'integer', 'hotel_id' => 'integer', 'floor_id' => 'integer'];
    }
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }
    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
    }
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function roomImages(): HasMany
    {
        return $this->hasMany(RoomImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class);
    }
}
