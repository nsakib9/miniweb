<?php

namespace App\Http\Controllers;

use App\Models\GameOTP;
use App\Models\GameSetting;
use App\Models\GameTrack;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    private $i = 0;

    public function showOTP()
    {
        $setting = GameSetting::first();
        $otp = GameOTP::simplePaginate(15);
        return view('backend.otp', ['otps' => $otp, 'setting' => $setting]);
    }

    public function editOTP($id)
    {
        $setting = GameSetting::first();
        $otp = GameOTP::find($id);
        $allotp = GameOTP::simplePaginate(15);
        return view('backend.otp', ['otp' => $otp, 'otps' => $allotp, 'setting' => $setting]);
    }

    public function storeOTP(Request $request)
    {
        $validation = $request->validate([
            'date' => 'required|unique:game_o_t_p_s,date',
            'date_valid_to' => 'required|unique:game_o_t_p_s,date_valid_to|after_or_equal:date',
            'otp' => 'required|unique:game_o_t_p_s,otp'
        ], [
            'date.unique' => 'Effective Date has already been defined',
            'date_valid_to.unique' => 'Date of expiry has already been defined',
            'date_valid_to.after_or_equal' => 'Date of Expiry must be a date after or equal to Effective date',
        ]);

        $otp = new GameOTP();
        $otp->fill($request->all());
        if ($otp->save()) {
            return redirect('/admin/game/otp');
        }
    }

    public function updateOTP(Request $request, $id)
    {
        $otp = GameOTP::find($id);
        $otp->fill($request->all());
        if ($otp->save()) {
            return redirect('/admin/game/otp');
        }
    }

    public function destroyOTP($id)
    {
        $otp = GameOTP::find($id);
        if ($otp->delete()) {
            return back();
        }
    }

    public function showSettings()
    {
        $setting = GameSetting::first();
        return view('backend.settings', ['setting' => $setting]);
    }

    public function storeSettings(Request $request)
    {

        $probability = $request->probablity_1 + $request->probablity_2 + $request->probablity_3 + $request->probablity_4;
        if ($probability != 100) {
            session()->flash('error', 'The Sum of Probabilities must be 100');
            return back();
        } else {
            if (!empty(GameSetting::first())) {
                $settings = GameSetting::first();
                $settings = $this->patchSettings($settings, $request);
            } else {
                $settings = new GameSetting();
                $settings = $this->patchSettings($settings, $request);
            }

            if ($settings->save()) {
                return redirect('/admin/game/settings');
            }
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

        $settings->logo = $this->imageUpload($settings, $request->logo, 1);
        $settings->background_image = $this->imageUpload($settings, $request->background_image, 2);
        $settings->game_img = $this->imageUpload($settings, $request->game_img, 3);

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

    private function imageUpload($settings, $image, $image_type)
    {
        $this->i++;
        if (!empty($image)) {
            if ($image_type == 1) {
                if (file_exists(public_path('storage/settings/' . $settings->logo))) {
                    unlink(public_path('storage/settings/' . $settings->logo));
                }
            } elseif ($image_type == 2) {
                if (file_exists(public_path('storage/settings/' . $settings->logo))) {
                    unlink(public_path('storage/settings/' . $settings->background_image));
                }
            } else {
                if (file_exists(public_path('storage/settings/' . $settings->logo))) {
                    unlink(public_path('storage/settings/' . $settings->game_img));
                }
            }

            $image_name = $this->i . '-' . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/settings/', $image_name);
            return $image_name;
            
        } else {
            if ($image_type == 1) {
                return $settings->logo;
            } elseif ($image_type == 2) {
                return $settings->background_image;
            } else {
                return $settings->game_img;
            }
        }
    }

    public function pointLog()
    {
        $points = GameTrack::with(['user'])->get();

        return view('backend.point_log', ['points' => $points]);
    }

    public function singleUserLog($id)
    {
        $points = GameTrack::where('user_id', '=', $id)->with(['user'])->get();
        $user = User::find($id);

        return view('backend.single_user_log', ['points' => $points, 'user' => $user]);
    }

    public function usersLog()
    {
        // $points = GameTrack::select(['game_tracks.id', 'game_tracks.user_id', DB::raw('SUM(score) as total_points')])->groupBy('game_tracks.user_id')->with(['user'])->get();
        $points = GameTrack::groupBy('user_id')->with(['user'])->get();

        return view('backend.users_log', ['points' => $points]);
    }
}
