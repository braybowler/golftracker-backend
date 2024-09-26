<?php

use App\Enums\SwingType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('yardages', function (Blueprint $table) {
            $table->id();
            $table->integer('golf_club_id');
            $table->enum('swing_type', SwingType::toArray());
            $table->integer('carry_distance');
            $table->integer('total_distance');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('yardages');
    }
};
