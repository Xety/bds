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
        Schema::create('maintenance_user', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('maintenance_user', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\Maintenance::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(\BDS\Models\User::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->primary(['maintenance_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_user');
    }
};
