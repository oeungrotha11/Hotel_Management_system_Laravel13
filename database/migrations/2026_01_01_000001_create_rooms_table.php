<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number')->unique();
            $table->enum('type', ['Single', 'Double', 'Twin', 'Suite', 'Deluxe']);
            $table->decimal('price_per_night', 10, 2);
            $table->unsignedTinyInteger('capacity')->default(1);
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available');
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
