<?php

namespace App\Console;

require_once('vendor/autoload.php');
use App\Mail\ScholarshipEmailAlert;
use App\User;
use paytm\checksum\PaytmChecksumLibrary;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;
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
        //$schedule->command('inspire')->hourly();
        
      /*  $schedule->call(function () {
            $users = User::all();

            foreach ($users as $user) {
                Mail::to($user->email)->send(new ScholarshipEmailAlert());
            }
        })->hourly();

        $schedule->command('schedule:run')->daily()
    ->appendOutputTo(storage_path('logs/scheduler.log'));

        */
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
