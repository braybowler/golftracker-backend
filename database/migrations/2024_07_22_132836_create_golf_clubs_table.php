<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('golf_clubs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('make');
            $table->string('model');
            $table->integer('carry_distance')->nullable();
            $table->integer('total_distance')->nullable();
            $table->integer('loft')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('golf_clubs');
    }
};
