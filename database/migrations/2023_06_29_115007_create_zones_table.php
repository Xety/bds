<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('allow_material')->default(true);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('material_count')->default(0);
            $table->timestamps();
        });

        Schema::table('zones', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\Site::class)
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unique(['site_id', 'name'], 'zones_site_name_primary');

            $table->foreign('parent_id')
                ->references('id')
                ->on('zones')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
