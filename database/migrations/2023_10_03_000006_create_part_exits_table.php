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
        Schema::create('part_exits', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->integer('number')->default(0);
            $table->timestamps();
        });

        Schema::table('part_exits', function (Blueprint $table) {
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
        Schema::dropIfExists('part_exits');
        Schema::table('part_exits', function (Blueprint $table) {
            $table->dropForeignIdFor(\BDS\Models\User::class);
            $table->dropForeignIdFor(\BDS\Models\Part::class);
        });
    }
};
