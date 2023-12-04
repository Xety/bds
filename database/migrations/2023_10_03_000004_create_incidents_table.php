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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->timestamp('started_at')->nullable();
            $table->enum('impact', ['mineur', 'moyen', 'critique'])->default('mineur');
            $table->boolean('is_finished')->default(0);
            $table->timestamp('finished_at')->nullable();
            $table->integer('edit_count')->default(0);
            $table->boolean('is_edited')->default(false);
            $table->bigInteger('edited_user_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });

        Schema::table('incidents', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\User::class)->after('id');
            $table->foreignIdFor(\BDS\Models\Material::class)
                ->after('id')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropForeignIdFor(\BDS\Models\User::class);
            $table->dropForeignIdFor(\BDS\Models\Material::class);
        });
    }
};
