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
        Schema::create('calendars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('color')->nullable();
            $table->enum('status', ['incoming','waiting','progress', 'done', 'canceled'])->default('incoming');
            $table->boolean('allDay')->default(true);
            $table->timestamp('started');
            $table->timestamp('ended')->nullable();
        });

        Schema::table('calendars', function (Blueprint $table) {
            $table->foreignIdFor(\BDS\Models\CalendarEvent::class)
                ->after('id');
            $table->foreignIdFor(\BDS\Models\Site::class)
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(\BDS\Models\User::class)
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
        Schema::dropIfExists('calendars');
    }
};
