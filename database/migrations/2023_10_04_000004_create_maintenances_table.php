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
            $table->timestamp('finished_at')->nullable();
            $table->integer('edit_count')->default(0);
            $table->boolean('is_edited')->default(false);
            $table->bigInteger('edited_user_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });

        Schema::table('maintenances', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\Material::class)->after('gmao_id')->nullable();
            $table->foreignIdFor(\BDS\Models\User::class)->after('reason');
            //$table->foreign('edited_user_id')->references('id')->on('users');
        });

        Schema::create('company_maintenance', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\Company::class);
            $table->foreignIdFor(\BDS\Models\Maintenance::class);
            $table->primary(['maintenance_id', 'company_id']);
            $table->timestamps();
        });

        Schema::create('maintenance_user', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\Maintenance::class);
            $table->foreignIdFor(\BDS\Models\User::class);
            $table->primary(['maintenance_id', 'user_id']);
            $table->timestamps();
        });

        Schema::table('part_exits', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\Maintenance::class)->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('part_exits', function (Blueprint $table) {
            $table->dropForeignIdFor(\BDS\Models\Maintenance::class);
        });
        Schema::dropIfExists('maintenance_part_exit');
        Schema::dropIfExists('company_maintenance');
        Schema::dropIfExists('maintenances');
        Schema::table('maintenances', function (Blueprint $table) {
            $table->dropForeignIdFor(\BDS\Models\Material::class);
            $table->dropForeignIdFor(\BDS\Models\User::class);
            //$table->dropForeign('edited_user_id');
        });
    }
};
