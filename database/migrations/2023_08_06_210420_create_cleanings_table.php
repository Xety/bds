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
        Schema::create('cleanings', function (Blueprint $table) {
            $table->id();
            $table->mediumText('description')->nullable();
            $table->enum('type', ['daily', 'weekly', 'bimonthly', 'monthly', 'quarterly', 'biannual', 'annual', 'casual'])
                ->default('daily');
            $table->integer('edit_count')->default(0);
            $table->boolean('is_edited')->default(false);
            $table->timestamps();
        });

        Schema::table('cleanings', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\Material::class)
                ->after('id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(\BDS\Models\User::class)
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(\BDS\Models\User::class, 'edited_user_id')->after('is_edited')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cleanings');

        Schema::table('cleanings', function (Blueprint $table) {
            $table->dropForeignIdFor(\BDS\Models\Material::class);
            $table->dropForeignIdFor(\BDS\Models\User::class);
            $table->dropForeignIdFor(\BDS\Models\User::class, 'edited_user_id');
        });
    }
};
