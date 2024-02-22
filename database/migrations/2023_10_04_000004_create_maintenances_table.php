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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('gmao_id')->nullable();
            $table->mediumText('description');
            $table->text('reason');
            $table->enum('type', ['curative', 'preventive'])->default('curative');
            $table->enum('realization', ['internal', 'external', 'both'])->default('external');
            $table->timestamp('started_at')->nullable();
            $table->boolean('is_finished')->default(0);
            $table->timestamp('finished_at')->nullable();
            $table->integer('incident_count')->default(0);
            $table->integer('company_count')->default(0);
            $table->integer('edit_count')->default(0);
            $table->boolean('is_edited')->default(false);
            $table->bigInteger('edited_user_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });

        Schema::table('maintenances', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\Material::class)->after('gmao_id')->nullable();
            $table->foreignIdFor(\BDS\Models\User::class)->after('reason');
            $table->foreignIdFor(\BDS\Models\Site::class)
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();
            //$table->foreign('edited_user_id')->references('id')->on('users');
        });

        Schema::table('part_exits', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\Maintenance::class)->after('id')->nullable();
        });

        Schema::table('incidents', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\Maintenance::class)->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropForeignIdFor(\BDS\Models\Maintenance::class);
        });
        Schema::table('part_exits', function (Blueprint $table) {
            $table->dropForeignIdFor(\BDS\Models\Maintenance::class);
        });
        Schema::dropIfExists('maintenances');
        Schema::table('maintenances', function (Blueprint $table) {
            $table->dropForeignIdFor(\BDS\Models\Material::class);
            $table->dropForeignIdFor(\BDS\Models\User::class);
            //$table->dropForeign('edited_user_id');
        });
    }
};
