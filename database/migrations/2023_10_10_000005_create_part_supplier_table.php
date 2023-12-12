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
        Schema::create('part_supplier', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('part_supplier', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\Supplier::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(\BDS\Models\Part::class)
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part_supplier');
    }
};
