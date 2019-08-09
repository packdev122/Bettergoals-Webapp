<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Team;
use App\Common;
use App\Reminder;
use App\Task;
use App\User;
use App\Photo;
use App\SmsService;
use App\DiaryMedia;
use App\Organisation;
use Carbon\Carbon;
use App\Contact;
use App\Diary;
use Thumbnail; 
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Laravel\Spark\Contracts\Repositories\NotificationRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ActivityController extends Controller
{
    private $a_start, $a_end, $a_ready_start, $a_ready_end, $a_getting_start, $a_getting_end,
        $a_after_start, $a_after_end, $a_re_occurance;

    public function __construct(NotificationRepository $notifications)
    {
        $this->middleware('auth');
        $this->notifications = $notifications;
        // $this->middleware('subscribed');
    }
    /**
     * Create a new Appointment.
     *
     * @return Response
     */
    public function add(Request $request , $team_name)
    {
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $team_owner = $request->user()->currentTeam->owner_id;
        $carer = User::where('id', $team_owner)->first();
        $newcontact = new Contact;
        if (isset($request->user()->currentTeam)) {
            $contacts =  $request->user()->currentTeam->contacts;
            $organisations =  $request->user()->currentTeam->organisations;
        }
        return view('activity/add-activity', compact('carer', 'contacts', 'organisations', 'newcontact'));
    }

    public function edit(Request $request,$team_name, $id)
    {
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $team_id = $request->user()->currentTeam->id;
        $apt = Appointment::where([['id', $id], ['team_id', $team_id]])->with('contact','organisation')->first();
        $team_owner = $request->user()->currentTeam->owner_id;
        $carer = User::where('id', $team_owner)->first();
        /* tack how many time appointment is viewed by carer or pwd */
        if ($request->user()->pwd == 1) {
            $apt->pwd_count = $apt->pwd_count + 1;
            $apt->save();
        } else {
            $apt->carer_count = $apt->carer_count + 1;
            $apt->save();
        }
        $get_task = Task::where(['appointment_id' => $id, 'order' => '10'])->with('contact','organisation')->first();
        if (!isset($get_task)) $get_task = new Task;
        $getting_task = Task::where(['appointment_id' => $id, 'order' => '20'])->with('contact','organisation')->first();
        if (!isset($getting_task)) $getting_task = new Task;
        $after_task = Task::where(['appointment_id' => $id, 'order' => '30'])->with('contact','organisation')->first();
        if (!isset($after_task)) $after_task = new Task;

        if (isset($request->user()->currentTeam)) {
            $contacts =  $request->user()->currentTeam->contacts;
            $organisations =  $request->user()->currentTeam->organisations;
        }
        $newcontact = new Contact;

        $activity_photos = Photo::where('appointment_id', $id)->get();

        return view('activity/edit-activity', compact('apt', 'contacts', 'organisations', 'get_task', 'getting_task', 'after_task', 'newcontact', 'carer', 'activity_photos' ));
    }

    public function editDiary(Request $request ,$team_name, $id){
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $team_id = $request->user()->currentTeam->id;
        $apt = Appointment::where([['id', $id], ['team_id', $team_id]])->with('contact','organisation')->first();
        $team_owner = $request->user()->currentTeam->owner_id;
        $carer = User::where('id', $team_owner)->first();
        /* tack how many time appointment is viewed by carer or pwd */
        $diary = Diary::where("appointment_id",$id)->first();
        if(!$diary)$diary=new Diary;
        $note = "";
        $edited = false;
        return view('activity/edit-diary', compact('apt', 'diary' , "note" , "edited"));
    }

    public function diarySaveNote(Request $request ,$team_name, $id){
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $this->validate($request,[
            "diary_note" => "required",
        ]);
        $team_id = $request->user()->currentTeam->id;
        $apt = Appointment::where([['id', $id], ['team_id', $team_id]])->with('contact','organisation')->first();
        $team_owner = $request->user()->currentTeam->owner_id;

        $diary = Diary::where("appointment_id",$id)->first();
        if(!$diary)$diary=new Diary;
        $note = $request->diary_note;
        $edited = true;
        return view('activity/edit-diary', compact('apt', 'diary' , "note" , "edited"));
    }

    public function editDiaryNote(Request $request ,$team_name, $id){
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        // $diary = Diary::where("appointment_id",$id)->first();
        $note = $request->diary_note;
        return view('activity/edit-diary-note', compact('id',"note"));
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */

    public function list(Request $request,$team_name)
    {
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $team_id = $request->user()->currentTeam->id;
    	$t_date = new Carbon();
        $user = User::where('id', Auth::id())->first();
        if ($user->emergency_phone == null) {
            $team = Team::find($request->user()->currentTeam->id);
            $carer_id = $team->owner_id;
            $carer = User::find($carer_id);
            $user->emergency_name = $carer->name;
            $user->emergency_phone = $carer->phone;
        }
    	$today = $t_date->format('d/m/Y');
    	// $appointments = Appointment::whereBetween('start_date', [Carbon::today(), Carbon::today()->addDays(10)])
        $appointments = Appointment::where('team_id',$team_id)->where('start_date', '>=', Carbon::today())
            ->orderBy('start_date', 'asc')->limit(10)->get();
        $appointments = $appointments->groupBy('simpleDate');
        return view('activity/list', compact('today', 'appointments', 'user'));

    }
     
     
    public function loadMore(Request $request)
        {
      

            $team_id = $request->user()->currentTeam->id;
            $t_date = new Carbon();
            $user = User::where('id', Auth::id())->first();
            if ($user->emergency_phone == null) {
                $team = Team::find($request->user()->currentTeam->id);
                $carer_id = $team->owner_id;
                $carer = User::find($carer_id);
                $user->emergency_name = $carer->name;
                $user->emergency_phone = $carer->phone;
            }
            $today = $t_date->format('d/m/Y');
            // $appointments = Appointment::whereBetween('start_date', [Carbon::today(), Carbon::today()->addDays(10)])

            $skip = $request->loaded_activities;

            $appointments = Appointment::where('team_id',$team_id)->where('start_date', '>=', Carbon::today())
                ->orderBy('start_date', 'asc')->skip($skip)->limit(10)->get();
            $appointments = $appointments->groupBy('simpleDate');

             return view ('partials.load-more-activities', compact('today', 'appointments', 'user'))->render() ;
           //  return Response::json(array("today"=>$today,"appointments"=>$appointments, "user"=>$user));

        }

    // View Detail Appointment
    public function activity(Request $request, $team_name , $id)
    {
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $team_id = $request->user()->currentTeam->id;
        $appointment = Appointment::where([['id', $id], ['team_id', $team_id]])->with('contact','organisation')->first();
        // dd($appointment->organisation->address);
        /* tack how many time appointment is viewed by carer or pwd */
        if ($request->user()->pwd == 1) {
            $appointment->pwd_count = $appointment->pwd_count + 1;
            $appointment->save();
        } else {
            $appointment->carer_count = $appointment->carer_count + 1;
            $appointment->save();
        }
        $map = '#';
        $address = '';
        if (isset($appointment->organisation->address)) {
            $map = "http://maps.google.com/maps?daddr=". urlencode($appointment->organisation->address) . "&directionsmode=transit";
            $address = $appointment->organisation->address;
        }
        if ($appointment->address) {
            $map = "http://maps.google.com/maps?daddr=". urlencode($appointment->address) . "&directionsmode=transit";
            $address = $appointment->address;
        }
        $diary = Diary::where("appointment_id",$id)->first();
        $address = Common::getAddressWithoutCountry($address);
        $tasks = Task::where('appointment_id', $id)->orderBy('order', 'asc')->get();
        $activity_photos = Photo::where('appointment_id', $id)->get();

        //dump($activity_photos);

        return view('activity/detail-activity', 
            compact('appointment', 'tasks', 'map', 'address',"diary", "activity_photos"));

    }

    public function reminder(Request $request ,$team_name, $id){
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $user_id = $request->user()->id;
        $team_id = $request->user()->currentTeam->id;
        $reminder = Appointment::where([['id', $id], ['team_id', $team_id]])->first();

        return view('activity/detail-reminder', compact('reminder'));
    }

    public function editReminder(Request $request ,$team_name, $id){
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $user_id = $request->user()->id;

        $team_id = $request->user()->currentTeam->id;
        $reminder = Appointment::where([['id', $id], ['team_id', $team_id]])->with('contact','organisation')->first();

        return view('activity/edit-reminder', compact('reminder'));
    }

      // View Detail Task
    public function task(Request $request,$team_name, $id)
    {
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $team_id = $request->user()->currentTeam->id;
        $task = Task::where([['id', $id], ['team_id', $team_id]])->with('contact','organisation')->first();
        // dd($task->organisation->address);
        if ($request->user()->pwd == 1) {
            $task->pwd_count = $task->pwd_count + 1;
            $task->save();
        } else {
            $task->carer_count = $task->carer_count + 1;
            $task->save();
        }
        $map = '#';
        $address = '';
        if (isset($task->organisation->address)) {
            $map = "http://maps.google.com/maps?daddr=". urlencode($task->organisation->address) . "&directionsmode=transit";
            $address = $task->organisation->address;
        }
        if ($task->address) {
            $map = "http://maps.google.com/maps?daddr=". urlencode($task->address) . "&directionsmode=transit";
            $address = $task->address;
        }
        $address = Common::getAddressWithoutCountry($address);
        return view('activity/detail-task', compact('task', 'map', 'address'));

    }

    public function editTask(Request $request,$team_name, $id)
    {
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $team_id = $request->user()->currentTeam->id;
        $task = Task::where([['id', $id], ['team_id', $team_id]])->with('contact','organisation')->first();
        // dd($task->organisation->address);
        if ($request->user()->pwd == 1) {
            $task->pwd_count = $task->pwd_count + 1;
            $task->save();
        } else {
            $task->carer_count = $task->carer_count + 1;
            $task->save();
        }
        $map = '#';
        $address = '';
        if (isset($task->organisation->address)) {
            $map = "http://maps.google.com/maps?daddr=". urlencode($task->organisation->address) . "&directionsmode=transit";
            $address = $task->organisation->address;
        }
        if ($task->address) {
            $map = "http://maps.google.com/maps?daddr=". urlencode($task->address) . "&directionsmode=transit";
            $address = $task->address;
        }
        $address = Common::getAddressWithoutCountry($address);
        return view('activity/edit-task', compact('task', 'map', 'address'));

    }

    public function updateReminder(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'main_photo' => 'image|max:5048',
            'start_date' => 'required_with:title',
        ]);


        $reminder = Appointment::find($id);
        // Update photo
        $file = '/img/default.png';
        if ($request->file('main_photo')) {
            $file = $request->file('main_photo')->store('public/appointment');
            Image::make($file)->orientate()->fit(500,500, function ($constraint) {
                $constraint->aspectRatio();
            })->save( public_path($file) );
            $file = '/'.$file;
            $reminder->photo = $file;
        }
        
        $reminder->title = $request->title;
        $reminder->start_date = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->start_time));
        $reminder->detail = $request->detail;
        $reminder->video = $request->video_upload;
        $reminder->thumbnail = $request->thumb_upload;
        $reminder->save();

        return  redirect($request->user()->currentTeamName().'/reminder/'.$reminder->id);
    }

    public function videoupload(Request $request)
    {
        if($request->video){
            $file = request()->file('video');
            $mime_type = $file->getMimeType();
            $timestamp = uniqid();
            if(substr($mime_type , 0 , 5) == "video"){
                $name = $timestamp."_video";
                $fileName = $name . '.' . $file->guessClientExtension();
                $destination_path = public_path().'/videos';

                $upload_status    = $file->move($destination_path, $fileName);
                if($upload_status)
                {
                    $thumbnail_path   = public_path().'/thumbnails';
                    $video_path       = $destination_path.'/'.$fileName;
                    $thumbnail_image  = $timestamp."_thumb.jpg";
                    $time_to_image    = 1;
                    $thumbnail_status = Thumbnail::getThumbnail($video_path,$thumbnail_path,$thumbnail_image,$time_to_image);
                    if($thumbnail_status)
                    {
                        return Response::json(array("video"=>$fileName,"thumb"=>$thumbnail_image));
                    }
                    else
                    {
                        return Response::json(array("video"=>$fileName,"thumb"=>""));
                    }
                }else{
                    return Response::json(array("video"=>""));
                }
            }else if(substr($mime_type , 0 , 5) == "image"){
                $name = $timestamp."_thumb";
                $fileName = $name . '.' . $file->guessClientExtension();
                $destination_path = public_path().'/thumbnails';
                Image::make($file)->orientate()->save( public_path("thumbnails/".$fileName));
                return Response::json(array("video"=>"" , "thumb"=>$fileName));
            }else{
                return Response::json(array("video"=>"invalid_type"));
            }
        }
    }
    // Check in
    public function checkin(Request $request, $id)
    {
        $user = $request->user();
        $appointment = Appointment::where('id', $id)->with('contact','organisation')->first();

        if (!$appointment->checkin) {
            // dd($appointment->start_date->format('Y/m/d'));
            $appointment->checkin = true;
            $appointment->checkin_datetime = Carbon::now('Australia/Sydney');
            if ($appointment->checkin_datetime->format('Y/m/d') != ($appointment->start_date->format('Y/m/d'))) {

                return 2;
            }

            $appointment->save();
            //Send Notification
            if ($user->currentTeam) {
                $owner_id = DB::table('team_users')->select('user_id')
                    ->where([['team_id', '=', $user->currentTeam->id],['role', '=', 'owner'],])->first();
                $owner = \App\User::find($owner_id->user_id);
                $this->notifications->create($owner, [
                    'icon' => 'fa-users',
                    'body' => $user->name . ' checked in at ' . $appointment->title . ' | ' . $appointment->checkin_datetime->format('d/m/Y g:ia'),
                ]);
            }
        return "1";    
        } 
        return "0";
    }
    public function reminder_checkin(Request $request, $id)
    {
        $user = $request->user();
        $reminder = Reminder::where('id', $id)->first();

        if (!$reminder->checkin) {
            // dd($appointment->start_date->format('Y/m/d'));
            $reminder->checkin = true;
            $reminder->checkin_datetime = Carbon::now('Australia/Sydney');
            if ($reminder->checkin_datetime->format('Y/m/d') != ($reminder->start_date->format('Y/m/d'))) {

                return 2;
            }
            $reminder->save();
            //Send Notification
            if ($user->currentTeam) {
                $owner = \App\User::find($user->id);
                $this->notifications->create($owner, [
                    'icon' => 'fa-users',
                    'body' => $user->name . ' checked in at ' . $reminder->title . ' | ' . $reminder->checkin_datetime->format('d/m/Y g:ia'),
                ]);
            }
        return "1";    
        } 
        return "0";
    }
    // Task Check in
    public function taskCheckin(Request $request, $id)
    {
        $user = $request->user();
        $task = Task::where('id', $id)->first();

        if (!$task->checkin) {
            // dd($task->start_date->format('Y/m/d'));
            $task->checkin = true;
            $task->checkin_datetime = Carbon::now('Australia/Sydney');
            if ($task->checkin_datetime->format('Y/m/d') != ($task->start_date->format('Y/m/d'))) {

                return 2;
            }

            $task->save();
            //Send Notification
            if ($user->currentTeam) {
                $owner_id = DB::table('team_users')->select('user_id')
                    ->where([['team_id', '=', $user->currentTeam->id],['role', '=', 'owner'],])->first();
                $owner = \App\User::find($owner_id->user_id);
                $this->notifications->create($owner, [
                    'icon' => 'fa-users',
                    'body' => $user->name . ' completed task ' . $task->title . ' | ' . $task->checkin_datetime->format('d/m/Y g:ia'),
                ]);
            }
        return "1";    
        } 
        return "0";
    }

    public function savePhoto(Request $request){
        $this->validate($request, [
            'photo' => 'image|max:5048',
        ]);
        $file = '/img/default.png';
        if ($request->file('photo')) {
            $file = $request->file('photo')->store('public/appointment');
            Image::make($file)->orientate()->fit(500,500, function ($constraint) {
                $constraint->aspectRatio();
            })->save( public_path($file) );
            $file = '/'.$file;
        }
        return $file;
    }
    public function store(Request $request)
    {   
        $this->validate($request, [
            'title' => 'required|max:255',
            'main_photo' => 'image|max:5048',
            'start_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        if (isset($request->from_mobile)) {
            $this->a_start = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->start_time));
        
            $this->a_end = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->end_time));
        } else {
            $this->a_start = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->start_time));
        
            $this->a_end = Carbon::createFromTimestamp(strtotime($request->end_date . " " . $request->end_time));
        }
    
        $this->a_re_occurance = Carbon::createFromTimestamp(strtotime($request->re_occurance_end_date));
        if ($this->a_end->lt($this->a_start)) {
            $this->a_end = clone $this->a_start;
        }

        $this->a_ready_start= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->get_ready_start_time));
        $this->a_ready_end= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->get_ready_end_time));
        if ($this->a_ready_end <  $this->a_ready_start) {
            $this->a_ready_end = clone $this->a_ready_start;
        }

        $this->a_getting_start= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->getting_there_start_time));
        $this->a_getting_end= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->getting_there_end_time));
        if ($this->a_getting_end <  $this->a_getting_start) {
            $this->a_getting_end = clone $this->a_getting_start;
        }
        
        $this->a_after_start= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->after_appointment_start_time));
        $this->a_after_end = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->after_appointment_end_time));
        if ($this->a_after_end <  $this->a_after_start) {
            $this->a_after_end = clone $this->a_after_start;
        }

        $repeat = $request->repeat_appointment;
        // Save Photo... and use Same photo for all repeated appointments
        $file = $request->apt_photo;


        if ($repeat == 'none') {
            $req = $this->create_appointment_with_tasks($request, $file);
            return  redirect($request->user()->currentTeamName().'/activities/view/'.$req->id);
        } else  {
            $req = $this->repeat_appointment($request, $file);
            return  redirect($request->user()->currentTeamName().'/activities');
        }

        $request->session()->flash('alert-success', 'Activity / Tasks successfully created!');
        return  redirect($request->user()->currentTeamName().'/activities');
    }


    private function repeat_appointment(Request $request, $file) {

        $repeat = $request->repeat_appointment;
        while ($this->a_start <= $this->a_re_occurance) {
           // var_dump($start);
            $activity = $this->create_appointment_with_tasks($request, $file);
            
            switch ($repeat) {
                case 'daily':
                    $this->a_start->addDay();
                    $this->a_end->addDay();
                    $this->a_ready_start->addDay();
                    $this->a_ready_end->addDay();
                    $this->a_getting_start->addDay();
                    $this->a_getting_end->addDay();
                    $this->a_after_start->addDay();
                    $this->a_after_end ->addDay();
                    break;
                case 'weekly':
                    $this->a_start = $this->a_start->addWeek();
                    $this->a_end = $this->a_end->addWeek();
                    $this->a_ready_start= $this->a_ready_start->addWeek();
                    $this->a_ready_end= $this->a_ready_end->addWeek();
                    $this->a_getting_start= $this->a_getting_start->addWeek();
                    $this->a_getting_end= $this->a_getting_end->addWeek();
                    $this->a_after_start= $this->a_after_start->addWeek();
                    $this->a_after_end = $this->a_after_end ->addWeek();
                    break;
                case 'monthly':
                    $this->a_start = $this->a_start->addMonth();
                    $this->a_end = $this->a_end->addMonth();
                    $this->a_ready_start= $this->a_ready_start->addMonth();
                    $this->a_ready_end= $this->a_ready_end->addMonth();
                    $this->a_getting_start= $this->a_getting_start->addMonth();
                    $this->a_getting_end= $this->a_getting_end->addMonth();
                    $this->a_after_start= $this->a_after_start->addMonth();
                    $this->a_after_end = $this->a_after_end ->addMonth();
                    break;
                case 'yearly':
                    $this->a_start = $this->a_start->addYear();
                    $this->a_end = $this->a_end->addYear();
                    $this->a_ready_start= $this->a_ready_start->addYear();
                    $this->a_ready_end= $this->a_ready_end->addYear();
                    $this->a_getting_start= $this->a_getting_start->addYear();
                    $this->a_getting_end= $this->a_getting_end->addYear();
                    $this->a_after_start= $this->a_after_start->addYear();
                    $this->a_after_end = $this->a_after_end ->addYear();
                    break;
            }
        }
    }

    private function create_appointment_with_tasks(Request $request, $file) {
        $team_id = $request->user()->currentTeam->id;
        
        $appointment = Appointment::create([
            'team_id' => $team_id,
            'category_id' => $request->category_id,
            'contact_id' => $request->contact_id,
            'photo' => $file,
            'detail' => $request->detail,
            'organisation_id' => $request->organisation_id,
            'title' => $request->title,
            'start_date' => $this->a_start,
            'end_date' => $this->a_end,
            'send_sms' => ($request->send_sms == "on") ? true : false,
            'address' => $request->address,
            'video' => $request->video_upload?$request->video_upload:"",
            'thumbnail' => $request->thumb_upload?$request->thumb_upload:"",
        ]);


        // Create Get ready task
        if ($request->get_ready_title) {
            Task::create([
                'team_id' => $team_id,
                'contact_id' => $request->get_ready_contact_id,
                'appointment_id' => $appointment->id,
                'organisation_id' => $request->get_ready_organisation_id,
                'title' => $request->get_ready_title,
                'start_date' => $this->a_ready_start,
                'end_date' => $this->a_ready_end,
                'send_sms' => ($request->get_ready_send_sms == "on") ? true : false,
                'address' => $request->get_ready_address,
                'order' => 10,
                'detail' => $request->get_ready_detail,
                'video' => $request->ready_video_upload?$request->ready_video_upload:"",
                'thumbnail' => $request->ready_thumb_upload?$request->ready_thumb_upload:"",
            ]);
        }
        
        if ($request->getting_there_title) {
            Task::create([
                'team_id' => $team_id,
                'contact_id' => $request->getting_there_contact_id,
                'appointment_id' => $appointment->id,
                'organisation_id' => $request->getting_there_organisation_id,
                'title' => $request->getting_there_title,
                'start_date' => $this->a_getting_start,
                'end_date' => $this->a_getting_end,
                'send_sms' => ($request->getting_there_send_sms == "on") ? true : false,
                'address' => $request->getting_there_address,
                'order' => 20,
                'detail' => $request->getting_there_detail,
                'video' => $request->there_video_upload?$request->there_video_upload:"",
                'thumbnail' => $request->there_thumb_upload?$request->there_thumb_upload:"",
            ]);
        }

        if ($request->after_appointment_title) {
            Task::create([
                'team_id' => $team_id,
                'contact_id' => $request->after_appointment_contact_id,
                'appointment_id' => $appointment->id,
                'organisation_id' => $request->after_appointment_organisation_id,
                'title' => $request->after_appointment_title,
                'start_date' => $this->a_after_start,
                'end_date' => $this->a_after_end ,
                'send_sms' => ($request->after_appointment_send_sms == "on") ? true : false,
                'address' => $request->after_appointment_address,
                'order' => 30,
                'detail' => $request->after_appointment_detail,
                'video' => $request->after_video_upload?$request->after_video_upload:"",
                'thumbnail' => $request->after_thumb_upload?$request->after_thumb_upload:"",
            ]);
        }
        return $appointment;
    }
    public function saveDiary(Request $request , $id){

        $diary = Diary::where('appointment_id', $id)->first();
        if(!$diary){
            $diary = new Diary;
        }
        $diary->appointment_id = $id;
        $diary->note = $request->diary_note;
        $diary->state = $request->diary_status;
        $diary->save();
        DiaryMedia::where("diary_id",$diary->id)->delete();
        if($request->video_upload){
            for($i=0;$i<count($request->video_upload);$i++){
                $media = new DiaryMedia;
                $media->diary_id = $diary->id;
                $media->video = $request->video_upload[$i];
                $media->thumbnail = $request->thumb_upload[$i];
                $media->save();
            }
        }
        return  redirect($request->user()->currentTeamName().'/activities/view/'.$id);
    }
    public function updateAppointment(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'main_photo' => 'image|max:5048',
            'start_date' => 'required_with:title',
            'get_ready_title' => 'required_with:get_ready_start_time|max:255',
            'get_ready_start_time' => 'required_with:get_ready_title',
            'getting_there_title' => 'required_with:getting_there_start_time|max:255',
            'getting_there_start_time' => 'required_with:getting_there_title',
            'after_appointment_title' => 'required_with:after_appointment_start_time|max:255',
            'after_appointment_start_time' => 'required_with:after_appointment_title'
        ]);

        if (isset($request->from_mobile)) {
            $this->a_start = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->start_time));
            $this->a_end = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->end_time));
        } else {
            $this->a_start = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->start_time));
            $this->a_end = Carbon::createFromTimestamp(strtotime($request->end_date . " " . $request->end_time));
        }
       
        $this->a_re_occurance = Carbon::createFromTimestamp(strtotime($request->re_occurance_end_date));
        if ($this->a_end->lt($this->a_start)) {
            $this->a_end = clone $this->a_start;
        }

        $this->a_ready_start= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->get_ready_start_time));
        $this->a_ready_end= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->get_ready_end_time));
        if ($this->a_ready_end <  $this->a_ready_start) {
            $this->a_ready_end = clone $this->a_ready_start;
        }

         $this->a_getting_start= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->getting_there_start_time));
        $this->a_getting_end= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->getting_there_end_time));
        if ($this->a_getting_end <  $this->a_getting_start) {
            $this->a_getting_end = clone $this->a_getting_start;
        }
        
         $this->a_after_start= Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->after_appointment_start_time));
        $this->a_after_end = Carbon::createFromTimestamp(strtotime($request->start_date . " " . $request->after_appointment_end_time));
        if ($this->a_after_end <  $this->a_after_start) {
            $this->a_after_end = clone $this->a_after_start;
        }

        $appointment = Appointment::find($id);
        
 
        // Update photo
        $file = $request->apt_photo;
        
        $appointment->photo = $file;
        
        $appointment->category_id = $request->category_id;
        $appointment->contact_id = $request->contact_id;
        $appointment->organisation_id = $request->organisation_id;
        $appointment->title = $request->title;
        $appointment->start_date = $this->a_start;
        $appointment->end_date = $this->a_end;
        $appointment->address = $request->address;
        $appointment->detail = $request->detail;
        $appointment->video = $request->video_upload?$request->video_upload:"";
        
        //$appointment_picture->thumbnail = $request->thumb_upload?$request->thumb_upload:"";
        
        // $appointment->send_sms = ($request->send_sms == "on") ? true : false;
       

        $appointment->save();

        if($request->thumb_upload){
            $appointment_picture = new Photo;
            $appointment_picture->photo = $request->thumb_upload?$request->thumb_upload:"";
            $appointment_picture->team_id = $team_id = $request->user()->currentTeam->id;;
            $appointment_picture->appointment_id = $id;

            $appointment_picture->save();
        }
        // Update tasks

        //Get ready
        $task = Task::firstOrNew(['id' => $request->get_ready_id]);
        if (!empty($request->get_ready_title)) {
            $task->appointment_id = $request->apt_id;
            $task->team_id = $request->team_id;
            $task->order = 10;
            $task->title = $request->get_ready_title;
            $task->contact_id = $request->get_ready_contact_id;
            $task->organisation_id = $request->get_ready_organisation_id;
            $task->start_date = $this->a_ready_start;
            $task->end_date = $this->a_ready_end;
            $task->send_sms = ($request->get_ready_send_sms == "on") ? true : false;
            $task->address = $request->get_ready_address;
            $task->detail = $request->get_ready_detail;
            $task->video = $request->ready_video_upload?$request->ready_video_upload:'';
            $task->thumbnail = $request->ready_thumb_upload?$request->ready_thumb_upload:"";
            $task->save();
        }
        

        $task = Task::firstOrNew(['id' => $request->getting_there_id]);
        if (!empty($request->getting_there_title)) {
            $task->appointment_id = $request->apt_id;
            $task->team_id = $request->team_id;
            $task->order = 20;
            $task->title = $request->getting_there_title;
            $task->contact_id = $request->getting_there_contact_id;
            $task->organisation_id = $request->getting_there_organisation_id;
            $task->start_date = $this->a_getting_start;
            $task->end_date = $this->a_getting_end;
            $task->send_sms = ($request->getting_there_send_sms == "on") ? true : false;
            $task->address = $request->getting_there_address;
            $task->detail = $request->getting_there_detail;
            $task->video = $request->there_video_upload?$request->there_video_upload:"";
            $task->thumbnail = $request->there_thumb_upload?$request->there_thumb_upload:"";
            $task->save();
        }

        $task = Task::firstOrNew(['id' => $request->after_appointment_id]);
        if (!empty($request->after_appointment_title)) {
            $task->appointment_id = $request->apt_id;
            $task->team_id = $request->team_id;
            $task->order = 30;
            $task->title = $request->after_appointment_title;
            $task->contact_id = $request->after_appointment_contact_id;
            $task->organisation_id = $request->after_appointment_organisation_id;
            $task->start_date = $this->a_after_start;
            $task->end_date = $this->a_after_end;
            $task->send_sms = ($request->after_appointment_send_sms == "on") ? true : false;
            $task->address = $request->after_appointment_address;
            $task->detail = $request->after_appointment_detail;
            $task->video = $request->after_video_upload?$request->after_video_upload:"";
            $task->thumbnail = $request->after_thumb_upload?$request->after_thumb_upload:"";
            $task->save();
        }
        $request->session()->flash('alert-success', 'Appointment / Tasks successfully updated!');
        return  redirect($request->user()->currentTeamName().'/activities/view/'.$id);
    }

        /**
     * View the Appointment.
     *
     * @return Response
     */
    public function viewTask(Request $request, $id)
    {
        $task = Task::where('id', $id)->first();
        if (isset($request->user()->currentTeam)) {
            $contacts =  $request->user()->currentTeam->contacts;
            $organisations =  $request->user()->currentTeam->organisations;
        }
        return view('view-task', compact('task', 'contacts', 'organisations'));
    }

    /**
     * Add the Appointment.
     *
     * @return Response
     */

     /**
     * Destroy the given appointment.
     *
     * @param  Request  $request
     * @param  contact  $contact
     * @return Response
     */
}
