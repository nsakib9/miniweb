<?php

namespace App\Http\Controllers;

use App\Mail\notifyTicket;
use App\Models\ExchangeTicket;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GameTrack;
use Auth;
use Carbon\Carbon;
use App\Mail\ticketExchange;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

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
    public function index(Request $request)
    {
        return view('backend.dashboard');
    }

    public function pointlog($user_id)
    {
        $user_id = decrypt($user_id);
        $auditLog = \OwenIt\Auditing\Models\Audit::with('user')
            ->where('auditable_type', GameTrack::class)
            ->orWhere('auditable_type', ExchangeTicket::class)
            ->where('user_id', $user_id)
            ->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('backend.users.point.pointlog', ['auditLog' => $auditLog]);
    }

    public function log()
    {
        $auditLog = \OwenIt\Auditing\Models\Audit::with('user')
            ->where('auditable_type', GameTrack::class)
            ->orWhere('auditable_type', ExchangeTicket::class)
            ->where('user_id', Auth::user()->id)
            ->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('backend.ticket_exchange', ['auditLog' => $auditLog]);
    }

    public function exchangeTicket(Request $request)
    {

        $exchangeTicket = new ExchangeTicket();
        $user = User::find(Auth::id());

        if ($request->exchangeTicket <= $user->tickets) {
            $exchangeTicket->ticket = $request->exchangeTicket;
            if ($exchangeTicket->save()) {
                $user->tickets = $user->tickets - $request->exchangeTicket;
                $user->save();
                $data = [
                    'tickets' => $request->exchangeTicket
                ];
                Mail::to($user->email)->send(new notifyTicket($data));
                return back();
            }
        } else {
            session()->flash('error', 'You do not have sufficient tickets');
            return back();
        }
    }
}
