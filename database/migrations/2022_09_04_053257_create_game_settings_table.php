<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->nullable();
            $table->string('logo')->nullable();
            $table->string('background_image')->nullable();
            $table->string('game_img')->nullable();
            $table->string('page1_body_title')->nullable();
            $table->string('page1_button_title')->nullable();
            $table->string('page2_heading')->nullable();
            $table->string('page2_heading2')->nullable();
            $table->string('page2_game_start_text')->nullable();
            $table->string('page2_game_skip_text')->nullable();
            $table->string('pg3_title')->nullable();
            $table->string('pg3_caution')->nullable();
            $table->string('pg4_score_txt')->nullable();
            $table->string('pg5_title')->nullable();
            $table->string('pg5_title2')->nullable();
            $table->boolean('login_access')->nullable()->default(1);
            $table->integer('point_1');
            $table->integer('point_2');
            $table->integer('point_3');
            $table->integer('point_4');
            $table->integer('probablity_1');
            $table->integer('probablity_2');
            $table->integer('probablity_3');
            $table->integer('probablity_4');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_settings');
    }
}
