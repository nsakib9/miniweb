<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GameTrack;
use Auth;
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
                ->where('user_id',Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
        return view('backend.users.point.pointlog',['auditLog'=>$auditLog]);
    }
    public function log()
    {
        return view('backend.ticket_exchange');
    }
}
