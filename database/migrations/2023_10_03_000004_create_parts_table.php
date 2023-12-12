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
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('reference')->nullable();
            $table->string('supplier')->nullable();
            $table->float('price')->default(0.00);
            $table->integer('part_entry_total')->default(0);
            $table->integer('part_exit_total')->default(0);
            $table->boolean('number_warning_enabled')->default(false);
            $table->integer('number_warning_minimum')->default(0);
            $table->boolean('number_critical_enabled')->default(false);
            $table->integer('number_critical_minimum')->default(0);
            $table->integer('part_entry_count')->default(0);
            $table->integer('part_exit_count')->default(0);
            $table->integer('material_count')->default(0);
            $table->integer('qrcode_flash_count')->default(0);
            $table->integer('edit_count')->default(0);
            $table->boolean('is_edited')->default(false);
            $table->bigInteger('edited_user_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });

        Schema::table('parts', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\Site::class)
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(\BDS\Models\User::class)->after('description');

            $table->unique(['name', 'site_id'], 'parts_name_site_primary');
            $table->unique(['reference', 'site_id'], 'parts_reference_site_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
        Schema::table('parts', function (Blueprint $table) {
            $table->dropForeignIdFor(\BDS\Models\Material::class);
            $table->dropForeignIdFor(\BDS\Models\User::class);
        });
    }
};
