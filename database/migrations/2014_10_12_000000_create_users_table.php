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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique()->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('office_phone')->nullable();
            $table->string('cell_phone')->nullable();
            $table->rememberToken();
            $table->unsignedBigInteger('current_site_id')->nullable();
            $table->integer('incident_count')->default(0);
            $table->integer('maintenance_count')->default(0);
            $table->integer('part_count')->default(0);
            $table->integer('part_exit_count')->default(0);
            $table->integer('part_entry_count')->default(0);
            $table->integer('cleaning_count')->default(0);
            $table->timestamp('end_employment_contract')->nullable();
            $table->ipAddress('last_login_ip')->nullable();
            $table->timestamp('last_login_date')->nullable();
            $table->timestamp('password_setup_at')->nullable();
            $table->bigInteger('deleted_user_id')->unsigned()->nullable()->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
