<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Task;
use App\Photo;
use App\User;
use App\Team;
use App\DiaryMedia;
use DB;
use Illuminate\Http\Request;
use Auth;
use Laravel\Spark\Spark;
use Carbon\Carbon;
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('subscribed');
    }
    public function home(Request $request , $team_name)
    {
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $team_id = $request->user()->currentTeam->id;
        $owner_id = $request->user()->currentTeam->owner_id;
        $user = User::where('id', Auth::id())->first();
        $owner = User::where("id",$owner_id)->first();
        if ($user->emergency_phone == null) {
            $team = Team::find($request->user()->currentTeam->id);
            $carer_id = $team->owner_id;
            $carer = User::find($carer_id);
            $user->emergency_name = $carer->name;
            $user->emergency_phone = $carer->phone;
        }
        $has_photo = $user->hasPhoto();

        $my_teams = DB::select('SELECT a.name , a.id , a.owner_id FROM `teams` a LEFT JOIN `team_users` b ON(a.`id` = b.`team_id`) WHERE b.`user_id` = :id', ['id' => $user->id]);

        $own_team = $user->ownTeam();
        $my_team_id = $own_team ? $own_team->id : 0;
        //dd($my_team_id);

        $team_name = $request->user()->currentTeam->name;
        return view('home', compact('user',"has_photo",'my_teams','team_name','owner','my_team_id'));

    }
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function show(Request $request)
    {
        $user = $request->user();

        $this->createUserOwnTeam($user);
        if ($user->currentTeam) {
            if($user->ownTeam()->id != $user->currentTeam->id){
                $this->switchTeam($request , $user->ownTeam()->id);
                // return;
            }
            return redirect($user->currentTeamName().'/dashboard');
        } else {
            echo "<br><br><br><br><div style='text-align:center;'> <h1 style='text-align:center;font-size:50px;'>You don't have your own team!</h1><a class='text-center' style='font-size:40px;' href='/logout'>Logout</a></div>";
            exit;
        }
    } 
    protected function createUserOwnTeam($user){
        $own_team = Team::where("owner_id",$user->id)->first();
        // dd($own_team);
        if(!$own_team){
            $own_team = new Team;
            $own_team->owner_id = $user->id;
            $own_team->name = $user->name;
            $own_team->save();
            DB::table("team_users")->insert(
                array("team_id"=>$own_team->id , "user_id"=>$user->id , "role"=>"owner")
            );
            return true;
        }
        return true;
    }
 
    public function switchTeam(Request $request , $team_id){
        $team = Team::find($team_id);
        if($team_id == 0){
            echo "<br><br><br><br><div style='text-align:center;'> <h1 style='text-align:center;font-size:50px;'>You don't have your own team!</h1><a class='text-center' style='font-size:40px;' href='/logout'>Logout</a></div>";
            return;
        }
        abort_unless($request->user()->onTeam($team), 404);
        $request->user()->switchToTeam($team);
        return redirect($request->user()->currentTeamName().'/dashboard');
    }
    
    public function settings(Request $request , $team_name)
    {
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        
        // $user = User::where('id', $request->user()->currentTeam->owner_id)->first();
        // dd($user);
        // $teams = $user->teams;
        $team = Team::where("owner_id",$request->user()->id)->first();
        return view('settings',compact('team'));
    }

    
    public function gallery(Request $request , $team_name){
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $team_id = $request->user()->currentTeam->id;
        $results = DB::select( DB::raw(" Select diary.id FROM diary,appointments WHERE appointments.`team_id` = $team_id AND diary.`appointment_id` = appointments.`id`"));
        $id_array = [];
        foreach($results as $result)
        {
            $id_array[] = $result->id;
        }
        $diaries = DiaryMedia::whereIn('diary_id',$id_array)->get();
        return view("gallery",compact("diaries"));
    }
    public function notification(Request $request , $team_name){
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        return view("notification",compact(""));
    }
    /**
     * show the diary dashboard
     * 
     */
    public function diary(Request $request , $team_name)
    {
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $team_id = $request->user()->currentTeam->id;
    	$t_date = new Carbon();
        $today = $t_date->format('d/m/Y');
        $page = $request->page?$request->page:0;
    	// $appointments = Appointment::whereBetween('start_date', [Carbon::today(), Carbon::today()->addDays(10)])
        $diaries = Appointment::where('team_id',$team_id)->where('start_date', '<', Carbon::today())
            ->orderBy('start_date', 'desc')->limit(10)->offset($page*10)->get();
        $diaries = $diaries->groupBy('simpleDate');
        if ($request->ajax()) {
            $view = view('partials/diary-partial',compact('diaries'))->render();
            return response()->json(['html'=>$view,"count"=>count($diaries)]);
        }
        return view('diary-dashboard', compact('today', 'diaries'));

    }
}
