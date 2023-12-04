<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('part_entries', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->default(0);
            $table->string('order_id')->nullable();
            $table->timestamps();
        });

        Schema::table('part_entries', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\User::class)
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(\BDS\Models\Part::class)
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part_entries');

        Schema::table('part_entries', function (Blueprint $table) {
            $table->dropForeignIdFor(\BDS\Models\User::class);
            $table->dropForeignIdFor(\BDS\Models\Part::class);
        });
    }
};
