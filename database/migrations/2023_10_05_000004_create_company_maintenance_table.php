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
        Schema::create('company_maintenance', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('company_maintenance', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\Company::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(\BDS\Models\Maintenance::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->primary(['maintenance_id', 'company_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_maintenance');
    }
};
