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
            $table->timestamps();
        });

        Schema::table('incidents', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\Selvah\CorrespondenceSheet::class, 'selvah_correspondence_sheet_id')
                ->after('id')
                ->nullable();
            $table->foreignIdFor(\BDS\Models\User::class)->after('id');
            $table->foreignIdFor(\BDS\Models\Material::class)
                ->after('id')
                ->nullable();
            $table->foreignIdFor(\BDS\Models\Site::class)
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(\BDS\Models\User::class, 'edited_user_id')
                ->after('is_edited')
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
            $table->dropForeignIdFor(\BDS\Models\Selvah\CorrespondenceSheet::class, 'selvah_correspondence_sheet_id');
            $table->dropForeignIdFor(\BDS\Models\User::class);
            $table->dropForeignIdFor(\BDS\Models\Material::class);
            $table->dropForeignIdFor(\BDS\Models\Site::class);
            $table->dropForeignIdFor(\BDS\Models\User::class, 'edited_user_id');
        });
    }
};
