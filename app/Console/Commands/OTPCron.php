<?php

namespace App\Console\Commands;

use App\Models\GameOTP;
use Carbon\Carbon;
use Illuminate\Console\Command;

class OTPCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:cron';

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
        
        $otps = GameOTP::all();
        foreach($otps as $otp){
            if($otp->date == Carbon::now()){
                \Log::info($otp->id);
                $otpUpdate = GameOTP::find($otp->id);
                $otpUpdate->status = 1;
                $otpUpdate->save();
            }
        }

        foreach($otps as $otp){
            if($otp->date_valid_to == Carbon::now()){
                $otpUpdate = GameOTP::find($otp->id);
                $otpUpdate->status = 0;
                $otpUpdate->save();
            }
        }
    }
}
