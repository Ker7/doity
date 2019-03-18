<?php

namespace App\Console;

use Carbon\Carbon;
use App\User;
use DB;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // @todo remove this or learn scheduled tasks | Schedule = cron job?
        //DB::table('dotilogs')->insert([
        //    'fieldhabit_id' => 2,
        //    
        //    'date_log' => Carbon::now()->format('Y-m-d'),//$faker->dateTime('-'.$i.' day')->format('Y-m-d'),
        //    'time_log' => Carbon::now()->format('H:i:s'),  // For Fieldlog it is okay to just use date, time is NULL
        //    
        //    'value_decimal' => Rand(2,10),
        //    'comment' => '',
        //    'created_at' => Carbon::now(),
        //]);
        //
        //$file = 'storage/logs/scheduler_output'. Carbon::now()->format('_Y-m-d_') . Carbon::now()->format('H-i-s').'.log';
        //$schedule->command('command1')
        //         ->sendOutputTo($file);
        //$schedule->call(function () {
        //    DB::table('users')->delete();
        //})->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
