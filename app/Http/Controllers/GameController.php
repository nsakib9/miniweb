<?php

namespace App\Http\Controllers;

use App\Models\GameOTP;
use App\Models\GameSetting;
use Illuminate\Http\Request;

class GameController extends Controller
{
    private $i = 0;

    public function showOTP(){
        $setting = GameSetting::first();
        $otp = GameOTP::all();
        return view('backend.otp', ['otps'=> $otp, 'setting'=> $setting]);
    }

    public function storeOTP(Request $request){
        $otp = new GameOTP();
        $otp->fill($request->all());
        if($otp->save()){
            return redirect('/admin/game/otp');
        }
    }

    public function showSettings(){
        $setting = GameSetting::first();
        return view('backend.settings', ['setting'=> $setting]);
    }

    public function storeSettings(Request $request){

        if(!empty(GameSetting::first())){
            $settings = GameSetting::first();
            $settings = $this->patchSettings($settings, $request);
        }else{
            $settings = new GameSetting();
            $settings = $this->patchSettings($settings, $request);
        }

        if($settings->save()){
            return redirect('/admin/game/settings');
        }
    }

    private function patchSettings($settings, $request): object
    {
        $settings->app_name = $request->app_name;
        $settings->page1_body_title = $request->page1_body_title;
        $settings->page1_button_title = $request->page1_button_title;
        $settings->page2_heading = $request->page2_heading;
        $settings->page2_heading2 = $request->page2_heading2;
        $settings->page2_game_start_text = $request->page2_game_start_text;
        $settings->page2_game_skip_text = $request->page2_game_skip_text;
        $settings->pg3_title = $request->pg3_title;
        $settings->pg3_caution = $request->pg3_caution;
        $settings->pg4_score_txt = $request->pg4_score_txt;
        $settings->pg5_title = $request->pg5_title;
        $settings->pg5_title2 = $request->pg5_title2;
        $settings->login_access = $request->login_access;

        $settings->logo = $this->imageUpload($settings, $request->logo)?? $settings->logo;
        $settings->background_image = $this->imageUpload($settings, $request->background_image)?? $settings->background_image;
        $settings->game_img = $this->imageUpload($settings, $request->game_img)?? $settings->game_img;
                
        $settings->point_1 = $request->point_1;
        $settings->point_2 = $request->point_2;
        $settings->point_3 = $request->point_3;
        $settings->point_4 = $request->point_4;
        $settings->probablity_1 = $request->probablity_1;
        $settings->probablity_2 = $request->probablity_2;
        $settings->probablity_3 = $request->probablity_3;
        $settings->probablity_4 = $request->probablity_4;

        return $settings;
    }

    private function imageUpload($settings, $image){

        $this->i++;
        if(!empty($image)){
            if(!file_exists('public/settings/'.$image)){
                $image_name = $this->i. '-' .time(). '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/settings/', $image_name);
                return $image_name;
            }
        }
    }
}
