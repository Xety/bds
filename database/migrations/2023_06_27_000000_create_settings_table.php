<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedBigInteger('site_id')->nullable();
            $table->string('key')->index();
            $table->longText('value')->nullable();
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->text('text')->nullable();
            $table->text('label')->nullable();
            $table->text('label_info')->nullable();
            $table->unsignedBigInteger('last_updated_user_id')->nullable()->index();
            $table->timestamps();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->index('site_id', 'settings_site_id_index');
            $table->unique(['key', 'site_id'], 'settings_key_site_id_unique');
            $table->index(['model_id', 'model_type'], 'settings_model_id_model_type_index');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
