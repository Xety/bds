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
        Schema::create('site_user', function (Blueprint $table) {
            $table->boolean('manager')->default(false);
            $table->timestamps();
        });

        Schema::table('site_user', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(\BDS\Models\Site::class)
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_user');
    }
};
