<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function teamValidation($team_name , $user){
        $current_team_name = $user->currentTeam()->name;
        $current_team_name = strtolower($current_team_name);
        $team_name = strtolower($team_name);
        if(str_replace(' ','',$current_team_name) === str_replace(' ','',$team_name)){
            return true;
        }else{
            return false;
        }
        return false;
    }
    public function showTeamMatchingError(){
        echo "<br><br><br><br><div style='text-align:center;'> <h1 style='text-align:center;font-size:50px;'>You are now in other team</h1><a class='text-center' style='font-size:40px;' href='/logout'>Logout</a></div>";
    }
}
