<?php

namespace Database\Seeders;

use App\Models\GameSetting;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = GameSetting::first();
        $settings->app_name = '';
        $settings->page1_body_title = '';
        $settings->page1_button_title = '';
        $settings->page2_heading = '';
        $settings->page2_heading2 = '';
        $settings->page2_game_start_text = '';
        $settings->page2_game_skip_text = '';
        $settings->pg3_title = '';
        $settings->pg3_caution = '';
        $settings->pg4_score_txt = '';
        $settings->pg5_title = '';
        $settings->pg5_title2 = '';
        $settings->login_access = '';

        $settings->logo = 'default/logo.png';
        $settings->background_image = 'default/background.png';
        $settings->game_img = 'default/game_image.png';
                
        $settings->point_1 = '1';
        $settings->point_2 = '3';
        $settings->point_3 = '5';
        $settings->point_4 = '10';
        $settings->probablity_1 = '20';
        $settings->probablity_2 = '30';
        $settings->probablity_3 = '40';
        $settings->probablity_4 = '10';

        $settings->save();
    }
}
