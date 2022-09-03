<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index()
    {
        $users = User::whereHas(
            'roles', function($q){
                $q->where('name', 'agent');
            }
        )->where('status', '=', '1')->get();
        return view('backend.users.agents', with(['users'=>$users]));
    }

    public function pendingAgent(){
        $users = User::where('status', '=', '0')->get();
        return view('backend.users.pending_agents', with(['users'=>$users]));
    }

    public function approveAgent($id){
        $user = User::find($id);
        $user->status = 1;
        $user->save();
        return redirect('/admin/agent/list');
    }
}
