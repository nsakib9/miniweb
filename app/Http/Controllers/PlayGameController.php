<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GameController; // LS SH
use App\Mail\notifyTicket;
use App\Models\GameOTP;
use App\Models\GameSetting;
use App\Models\GameTrack;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PlayGameController extends Controller
{
    public function page1()
    {
        $setting = GameSetting::first();
        (new GameController)->update_status(); // LS SH

        $code = GameOTP::where('status', '=', '1')->get('otp');
        $track = GameTrack::where('user_id', '=', Auth::id())->get()->last();

        if (!empty($track)) {
            $trackTime = Carbon::createFromFormat('Y-m-d H:s:i', $track->trackTime); // LS SH
            // if ($track->track == 1) {
            if (Carbon::now()->diffInHours($trackTime) < 24) { // LS SH
                return view('frontend.game.first_page', ['message' => '過去24時間以内にプレイしたため、現在プレイできません。 後でお試しください', 'setting' => $setting, 'otp' => '']);
            } else {
                if (!$code->isEmpty()) {
                    $otp = $code[0]->otp;
                    return view('frontend.game.first_page', ['otp' => $otp, 'setting' => $setting]);
                } else {
                    $otp = 'Error';
                    return view('frontend.game.first_page', ['otp' => $otp, 'setting' => $setting]);
                }
            }
        } else {
            if (!$code->isEmpty()) {
                $otp = $code[0]->otp;
                return view('frontend.game.first_page', ['otp' => $otp, 'setting' => $setting]);
            } else {
                $otp = 'Error';
                return view('frontend.game.first_page', ['otp' => $otp, 'setting' => $setting]);
            }
        }
    }

    public function page2()
    {
        if (Auth::check()) {
            $track = new GameTrack();
            $track->user_id = Auth::id();
            $track->otp_mached = 1;
            $track->track = 0;
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
            $lastPlayed = GameTrack::where('user_id', '=', Auth::id())->latest()->first();

            if (!empty($lastPlayed)) {
                // if ($lastPlayed->track == 0) {
                if (empty($lastPlayed->trackTime)) { // LS SH
                    $otpCheck = GameTrack::where('user_id', '=', Auth::id())->latest()->first();
                    if ($otpCheck->otp_mached != 1) {
                        $otp = 'Error';
                        return view('frontend.game.first_page', ['otp' => $otp, 'setting' => $setting]);
                    } else {
                        $Sec_Max = $setting->probablity_1 + $setting->probablity_2;
                        $Third_Max = $Sec_Max + $setting->probablity_3;
                        $last_Max = $Third_Max + $setting->probablity_4;
                        $arr = array(
                            $setting->point_1 => array('min' => 0, 'max' => $setting->probablity_1),
                            $setting->point_2 => array('min' => $setting->probablity_1 + 1, 'max' => $Sec_Max),
                            $setting->point_3 => array('min' => $Sec_Max + 1, 'max' => $Third_Max),
                            $setting->point_4 => array('min' => $Third_Max + 1, 'max' => $last_Max),
                        );
                        $rnd = rand(1, 100);
                        foreach ($arr as $k => $v) {
                            if ($rnd > $v['min'] && $rnd <= $v['max']) {
                                $score = $k;
                            }
                        }

                        $track = GameTrack::where('user_id', '=', Auth::id())->latest()->first();
                        $track->score = $score;
                        $track->track = 1;
                        $trackTime = Carbon::now();
                        $track->trackTime = $trackTime->toDateTimeString();
                        $track->save();

                        $points = GameTrack::selectRaw('SUM(score) as total_points')->where('user_id', '=', Auth::id())->get();
                        $totalPoints = User::where('id', '=', Auth::id())->first();
                        $previousPoint = $totalPoints->tickets;
                        $newPoint = floor($points[0]->total_points / 50);
                        $totalPoints->total_points = $points[0]->total_points % 50;
                        $totalPoints->tickets = floor($points[0]->total_points / 50);
                        $totalPoints->save();
                        if ($previousPoint < $newPoint) {
                            $email = [
                                'total_points' => $totalPoints->total_points,
                                'tickets' => $totalPoints->tickets,
                            ];
                            Mail::to($totalPoints->email)->send(new notifyTicket($email));
                        }

                        // return response()->json(['score' => $score, 'setting' => $setting, 'track' => 0]);
                        return view('frontend.game.fifth_page', ['score' => $score, 'setting' => $setting, 'track' => 0]);
                    }
                } else {
                    return view('frontend.game.fifth_page', ['message' => '過去24時間以内にプレイしたため、現在プレイできません。 後でお試しください', 'setting' => $setting, 'track' => 1]);
                }
            } else {
                return redirect('/game');
            }
        } else {
            return view('frontend.game.fourth_page', ['setting' => $setting]);
        }
    }

    public function wpScoreApi()
    {
        return view('backend.wp_scores');
    }

    public function getScore($id) { // LS SH 
    $score = GameTrack::with(['user'])->where('user_id', $id)->get(); // LS SH
    // $tickets = $user->tickets;
    return response()->json(['score' => $score]);
    }

    public function page6()
    {
        $setting = GameSetting::first();
        $score = GameTrack::where('user_id', '=', Auth::id())->latest()->first();
        return view('frontend.game.sixth_page', ['score' => $score, 'setting' => $setting]);
    }
}
