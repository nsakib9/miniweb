<?php

namespace App\Console\Commands;

use App\Models\GameTrack;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TrackPlayCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trackplay:cron';

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
        $tracks = GameTrack::all();
        $newDateTime = Carbon::now()->subHour(24);
        foreach($tracks as $track){
            // \Log::info(date('Y-m-d', strtotime($otp->date_valid_to. ' + 1 days')));
            if($track->trackTime <= $newDateTime){
                $trackTimeUpdate = GameTrack::find($track->id);
                $trackTimeUpdate->track = 0;
                $trackTimeUpdate->save();
            }
        }
    }
}
