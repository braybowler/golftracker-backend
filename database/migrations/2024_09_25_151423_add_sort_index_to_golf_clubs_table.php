<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('golf_clubs', function (Blueprint $table) {
            $table->integer('sort_index')->after('user_id')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('golf_clubs', function (Blueprint $table) {
            $table->dropColumn('sort_index');
        });
    }
};
