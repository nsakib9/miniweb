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
        $settings = new GameSetting();
        $settings->app_name = 'LAMP 牛の番';
        $settings->page1_body_title = 'ゲームコードを入力してください';
        $settings->page1_button_title = '登録完了';
        $settings->page2_heading = 'ゲーム説明';
        $settings->page2_heading2 = '並んでる牛さんをクリックすると 点数がもらえるよ';
        $settings->page2_game_start_text = 'ゲーム開始';
        $settings->page2_game_skip_text = 'スキップ';
        $settings->pg3_title = '好きな牛さんを選んで<span>クリック</span>';
        $settings->pg3_caution = '【注意】戻るを操作するとゲームが終了してしまいます';
        $settings->pg4_score_txt = 'あなたの得点は？';
        $settings->pg5_title = 'あなたの得点は？';
        $settings->pg5_title2 = 'クリックして <br> ポイントゲット';
        $settings->login_access = '1';

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
