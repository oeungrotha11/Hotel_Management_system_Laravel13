<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            if (Schema::hasColumn('rooms', 'address')) {
                $table->dropColumn('address');
            }

            if (Schema::hasColumn('rooms', 'latitude')) {
                $table->dropColumn('latitude');
            }

            if (Schema::hasColumn('rooms', 'longitude')) {
                $table->dropColumn('longitude');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
        });
    }
};
