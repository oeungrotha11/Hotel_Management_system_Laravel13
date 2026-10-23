<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreignId('hotel_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->foreignId('floor_id')->nullable()->after('hotel_id')->constrained()->nullOnDelete();
            $table->string('main_image')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropConstrainedForeignId('hotel_id');
            $table->dropConstrainedForeignId('floor_id');
            $table->dropColumn('main_image');
        });
    }
};
