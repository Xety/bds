<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('part_user', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('part_user', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\Part::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(\BDS\Models\User::class)
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part_user');
    }
};
