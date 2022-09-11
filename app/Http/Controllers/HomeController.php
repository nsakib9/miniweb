<?php

namespace App\Http\Controllers;

use App\Models\ExchangeTicket;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $auditLog = Auth::user()->audits()->where('auditable_type',User::class)->get();
        return view('backend.users.point.pointlog',['auditLog'=>$auditLog]);
    }

    public function log()
    {
        return view('backend.ticket_exchange');
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
