<?php

namespace App\Http\Controllers;

use App\Mail\notifyTicket;
use App\Models\GameOTP;
use App\Models\GameSetting;
use App\Models\GameTrack;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PlayGameController extends Controller
{
    public function page1()
    {
        $setting = GameSetting::first();

        $code = GameOTP::where('status', '=', '1')->get('otp');
        if (!$code->isEmpty()) {
            $otp = $code[0]->otp;
            return view('frontend.game.first_page', ['otp' => $otp, 'setting' => $setting]);
        } else {
            $otp = 'Error';
            return view('frontend.game.first_page', ['otp' => $otp, 'setting' => $setting]);
        }
    }

    public function page2()
    {
        if (Auth::check()) {
            $track = new GameTrack();
            $track->user_id = Auth::id();
            $track->otp_mached = 1;
            $track->save();
        }

        $setting = GameSetting::first();
        return view('frontend.game.second_page', ['setting' => $setting]);
    }

    public function page3()
    {
        $setting = GameSetting::first();
        return view('frontend.game.third_page', ['setting' => $setting]);
    }

    public function page4()
    {
        $setting = GameSetting::first();
        return view('frontend.game.fourth_page', ['setting' => $setting]);
    }

    public function page5()
    {
        $setting = GameSetting::first();

        if (Auth::check()) {
            if ((GameTrack::where([['track', '=', '1'], ['user_id', '=', Auth::id()]])->latest())) {
                if (!GameTrack::where('otp_mached', '=', '1')) {
                    return view('frontend.game.first_page', ['setting' => $setting]);
                } else {
                    $Sec_Max = $setting->probablity_1 + $setting->probablity_2;
                    $Third_Max = $Sec_Max + $setting->probablity_3;
                    $last_Max = $Third_Max + $setting->probablity_4;
                    $arr = array(
                        $setting->point_1    =>  array('min' =>  0, 'max' =>  $setting->probablity_1),
                        $setting->point_2  =>  array('min' => $setting->probablity_1 + 1, 'max' =>  $Sec_Max),
                        $setting->point_3    =>  array('min' =>  $Sec_Max + 1, 'max' => $Third_Max),
                        $setting->point_4  =>  array('min' => $Third_Max + 1, 'max' => $last_Max),
                    );
                    $rnd = rand(1, 100);
                    foreach ($arr as $k => $v) {
                        if ($rnd > $v['min'] && $rnd <= $v['max']) {
                            $score = $k;
                        }
                    }

                    $track = new GameTrack();
                    $track->user_id = Auth::id();
                    $track->score = $score;
                    $track->track = 1;
                    $trackTime = Carbon::now();
                    $track->trackTime = $trackTime->toDateTimeString();
                    $track->save();

                    $totalPoints = User::where('id', '=', Auth::id())->first();
                    $totalPoints->total_points = $totalPoints->total_points + $score;
                    $totalPoints->save();

                    $tickets = $totalPoints->total_points;
                    if((($tickets % 50) >= 0)  && (($tickets % 50)  < 50) ){
                        $email = [
                                'total_points' => $totalPoints->total_points,
                                'tickets' => $tickets/50
                            ];
                            Mail::to($totalPoints->email)->send(new notifyTicket($email));
                    }

                    return view('frontend.game.fifth_page', ['score' => $score, 'setting' => $setting]);
                }
            } else {
                return view('frontend.game.fifth_page', ['message' => '過去24時間以内にプレイしたため、現在プレイできません。 後でお試しください', 'setting' => $setting]);
            }
        } else {
            return view('frontend.game.fourth_page', ['setting' => $setting]);
        }
    }
}
