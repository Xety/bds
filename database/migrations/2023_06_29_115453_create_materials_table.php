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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('qrcode_flash_count')->default(0);
            $table->integer('cleaning_count')->default(0);
            $table->boolean('selvah_cleaning_test_ph_enabled')->default(false);
            $table->boolean('cleaning_alert')->default(false);
            $table->boolean('cleaning_alert_email')->default(false);
            $table->tinyInteger('cleaning_alert_frequency_repeatedly')->default(0);
            $table->timestamp('last_cleaning_at')->nullable();
            $table->timestamp('last_cleaning_alert_send_at')->nullable();
            $table->enum('cleaning_alert_frequency_type', ['daily', 'monthly', 'yearly'])
                ->default('daily');
            $table->timestamps();
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\User::class)
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(\BDS\Models\Zone::class)
                ->after('description')
                ->constrained()
                ->cascadeOnDelete();

            $table->unique(['zone_id', 'name'], 'materials_zone_name_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
        Schema::table('materials', function (Blueprint $table) {
            $table->dropForeignIdFor(\BDS\Models\Zone::class);
        });
    }
};
