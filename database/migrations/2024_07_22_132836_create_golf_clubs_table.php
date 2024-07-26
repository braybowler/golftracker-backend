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
            $table->enum(
                'club_category',
                [
                    'Wedge',
                    'Iron',
                    'Hybrid',
                    'Wood',
                    'Putter'
                ]
            );
            $table->enum(
                'club_type',
                [
                    'LW', 'SW', 'GW', 'PW',
                    '9i', '8i', '7i', '6i', '5i', '4i', '3i', '2i', '1i',
                    '7h', '6h', '5h', '4h', '3h', '2h', '1h',
                    '9w', '7w', '5w', '4w', '3w', '2w', '1w',
                    'Putter'
                ]
            );
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
