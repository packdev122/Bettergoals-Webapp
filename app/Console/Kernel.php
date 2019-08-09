<?php

namespace App\Console;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // 'App\Console\Commands\SmsService',
    ];
    
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		
        $schedule->call(function () {
            Log::debug("*******************************started scheduling***********************************************");
            $tz = env('BG_TIMEZONE', 'Australia/Sydney');
            $appointments = \App\Appointment::whereBetween('start_date', 
                [Carbon::now($tz) , Carbon::now($tz)->addMinutes(5)])->get();
            Log::debug("Current Time : ".Carbon::now($tz));
            foreach ($appointments as $appointment) {
                // Get first PWD from Team, if there are more PWDs in a team then they are ignored. 
                Log::debug("Appointment Name : ".$appointment->title);
                $pwd = $this->get_pwd($appointment->team_id);
                Log::debug("Phone Number : ".$pwd->phone);
                $this->send_sms($appointment, $pwd, 'A');
            }
            // Repeat same for Tasks
            $tasks = \App\Task::whereBetween('start_date', 
                [Carbon::now($tz) , Carbon::now($tz)->addMinutes(5)])->get();
            foreach ($tasks as $task) {
                // Get first PWD from Team, if there are more PWDs in a team then they are ignored.
                Log::debug("Appointment Name : ".$task->title);
                $pwd = $this->get_pwd($task->team_id);
                Log::debug("Appointment Name : ".$pwd->phone);
                $this->send_sms($task, $pwd, 'T');
            }
        })->everyMinute();

        //Perform daily backup
        // $schedule->command('backup:clean')->daily()->at('01:00');
        // $schedule->command('backup:run')->daily()->at('02:00');

    }

    // GET PWD from Team ID

    private function get_pwd($team_id) {
        $pwd_id = DB::table('team_users')->select('user_id')
            ->where([['team_id', '=', $team_id],['role', '=', 'owner'],])->first();
        return \App\User::find($pwd_id->user_id);
    }

    /**** 
        Send SMS using OpenMarket API
    ***/
    private function send_sms($appointment, $pwd, $type) {
        if ($appointment->send_sms) {
            $client = new Client([
                'headers' => [ 
                    'Content-Type' => 'application/json; charset=UTF-8', 
                    'Authorization' => 'Basic MDAwLTAwMC0xMTYtNzQzNjI6YjN0dDNyZzBhTHNA', ]
            ]);
            $team_name = strtolower(\App\Team::find($appointment->team_id)->name);
            $team_name = str_replace(' ','',$team_name);
            if ($type == 'A') {
                if($appointment->is_reminder){
                    $content = $appointment->start_date->format('g:ia '). " " . substr($appointment->title, 0, 113) . ".. " . url($team_name.'/'.'reminder/' . $appointment->id);
                }else{
                    $content = $appointment->start_date->format('g:ia '). " " . substr($appointment->title, 0, 113) . ".. " . url($team_name.'/'.'activity/' . $appointment->id);
                }
            }else if($type == "T"){
                $content = $appointment->start_date->format('g:ia '). " " . substr($appointment->title, 0, 113) . ".. " . url($team_name.'/'.'task/' . $appointment->id);
            }
            
            $body['mobileTerminate']['interaction'] = "one-way";
            $body['mobileTerminate']['source']['address'] = "bettergoals";
            $body['mobileTerminate']['source']['ton'] = "5";
            $body['mobileTerminate']['destination']['address'] = $pwd->phone;
            $body['mobileTerminate']['message']['content'] = $content;
            $body['mobileTerminate']['message']['type'] = "text";

            $response = $client->post('https://smsc.openmarket.com:443/sms/v4/mt',
                ['body' => json_encode($body)]
            );
            $code = $response->getStatusCode();
            $request_id = $response->getHeader('Location');
            Log::debug("---------------------------sms sent---------------------------");
            Log::debug($content);
            Log::debug($request_id);
            Log::debug("------------------------------------");
        }
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
