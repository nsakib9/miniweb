<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UserCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get('https://ap-lamp.com/wp-json/wp/v2/users');
        $request = $response->json();
        foreach($request as $req){
            if(User::find($req['id'])){
                $user = User::find($req['id']);
                $user->id = $req['id'];
                $user->name =$req['name'];
                $user->email =$req['user_em'];
                $user->save();
            }else{
                $user = new User();
                $user->id = $req['id'];
                $user->name =$req['name'];
                $user->email =$req['user_em'];
                $user->save();
            }
        }
    }
}
