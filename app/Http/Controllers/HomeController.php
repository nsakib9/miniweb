<?php

namespace App\Http\Controllers;

use App\Models\ExchangeTicket;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GameTrack;
use Auth;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('backend.dashboard');
    }

    public function pointlog()
    {
        $auditLog = \OwenIt\Auditing\Models\Audit::with('user')
                ->where('auditable_type',GameTrack::class)
                ->orWhere('auditable_type',ExchangeTicket::class)
                ->where('user_id',Auth::user()->id)
                ->where('created_at',Carbon::today())
                ->orderBy('created_at', 'desc')
                ->get();
        return view('backend.users.point.pointlog',['auditLog'=>$auditLog]);
    }

    public function log()
    {
        $auditLog = \OwenIt\Auditing\Models\Audit::with('user')
                ->where('auditable_type',GameTrack::class)
                ->orWhere('auditable_type',ExchangeTicket::class)
                ->where('user_id',Auth::user()->id)
                ->where('created_at',Carbon::today())
                ->orderBy('created_at', 'desc')
                ->get();
        return view('backend.ticket_exchange',['auditLog'=>$auditLog]);
    }

    public function exchangeTicket(Request $request){

        $exchangeTicket = new ExchangeTicket();
        $user = User::find(Auth::id());

        if($request->exchangeTicket <= $user->tickets){
            $exchangeTicket->ticket = $request->exchangeTicket;
            if($exchangeTicket->save()){
                $user->tickets = $user->tickets - $request->exchangeTicket;
                $user->save();

                return back();
            }
        }else{
            session()->flash('error', 'You do not have sufficient tickets');
            return back();
        }


    }

}
