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
            $table->rememberToken();
            $table->unsignedBigInteger('current_site_id')->nullable();
            $table->integer('cleaning_count')->default(0);
            $table->ipAddress('last_login_ip')->nullable();
            $table->dateTime('last_login_date')->nullable();
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
