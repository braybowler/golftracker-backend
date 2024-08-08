<?php

use App\Models\GolfBag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('baggables', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(GolfBag::class)->constrained()->cascadeOnDelete();
            $table->foreignId('baggable_id');
            $table->string('baggable_type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baggables');
    }
};
