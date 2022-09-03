<?php

namespace App\Http\Controllers;

use App\Models\GameOTP;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function showOTP(){
        $otp = GameOTP::all();
        return view('frontend.otp', ['otps'=> $otp]);
    }

    public function storeOTP(Request $request){
        $otp = new GameOTP();
        $otp->fill($request->all());
        if($otp->save()){
            return redirect('/admin/game-otp');
        }
    }
}
