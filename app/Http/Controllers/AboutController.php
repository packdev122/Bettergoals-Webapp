<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\About;
use App\Common;
use App\Reminder;
use App\Appointment;
use App\FavouriteThings;
use App\Medications;
use App\User;
use App\Contact;
use Intervention\Image\Facades\Image;
use Auth;
use Carbon\Carbon;
class AboutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('subscribed');
    }

    public function show(Request $request,$team_name)
    {
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $user = User::where('id', $request->user()->currentTeam->owner_id)->first();
        $about = About::where('user_id', $request->user()->currentTeam->owner_id)->first();
        $has_photo = $user->hasPhoto();

        $live_map = "";
        $live_address = "";
        if($about && $about->live_place_id){
            $live_address = $about->live_place->address;
            $live_map = "http://maps.google.com/maps?daddr=". urlencode($live_address) . "&directionsmode=transit";
        }

        $work_map = "";
        $work_address = "";
        if($about && $about->work_place_id){
            $work_address = $about->work_place->address;
            $work_map = "http://maps.google.com/maps?daddr=". urlencode($work_address) . "&directionsmode=transit";
        }

        $doctor_map = "";
        $doctor_address = "";
        if($about && $about->doctor_id){
            $doctor_address = $about->doctor->address;
            $doctor_map = "http://maps.google.com/maps?daddr=". urlencode($doctor_address) . "&directionsmode=transit";
        }

        $live_address = Common::getAddressWithoutCountry($live_address);
        $work_address = Common::getAddressWithoutCountry($work_address);
        $doctor_address = Common::getAddressWithoutCountry($doctor_address);

        $favourite_things = array();
        if($about)$favourite_things = $about->favouritethings();

        $medications = array();
        if($about)$medications = $about->medications();

        $favourite_people = array();
        if($about){
            if($about->contact_id)$favourite_people = $about->favourite_people();
        }
        return view('about/show', compact('user','about',"has_photo","live_map","live_address","work_map","work_address","medications","favourite_things","doctor_map","doctor_address","favourite_people"));
    }
    public function edit(Request $request , $team_name){
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $user = User::where('id', $request->user()->currentTeam->owner_id)->first();
        
        $newcontact = new Contact;
        if (isset($request->user()->currentTeam)) {
            $contacts =  $request->user()->currentTeam->contacts;
            $organisations =  $request->user()->currentTeam->organisations;
        }
        $about = About::where('user_id', $request->user()->currentTeam->owner_id)->first();
        $has_photo = $user->hasPhoto();
        
        $favourite_things = array();
        if($about)$favourite_things = $about->favouritethings();

        $medications = array();
        if($about)$medications = $about->medications();
        
        $favourite_people = array();
        if($about){
            if($about->contact_id)$favourite_people = $about->favourite_people();
        }
        return view('about/edit', compact('user','organisations','contacts',"newcontact","about","has_photo","medications","favourite_things","favourite_people"));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'main_photo' => 'image|max:5048',
            'live_organisation_id' => 'required',
            'work_organisation_id' => 'required',
        ]);

        $about = About::where("user_id" , $request->user()->currentTeam->owner_id)->first();
        $user = User::where('id', $request->user()->currentTeam->owner_id)->first();
        $datas = [
            'user_id' => $request->user()->currentTeam->owner_id,
            'live_place_id' => $request->live_organisation_id,
            'work_place_id' => $request->work_organisation_id,
            'contact_id' => $request->contact_id ? implode("," , $request->contact_id) : "",
            'doctor_id' => $request->doctor_id,
            'emergency_id' => $request->emergency_id,
        ];
        // $user->emergency_name = $request->emergency_name;
        // $user->emergency_phone = $request->emergency_phone;
        $user->photo_url = $request->profile_photo;
        $user->save();

        if($about == null){
            About::create($datas);
        }else{
            $about->update($datas);
        }
        //Delete all the favourtie things and restore those newly
        FavouriteThings::where("user_id",$request->user()->currentTeam->owner_id)->delete();
        $favourite_things = $request->favourite_things;
        $favourite_photos = $request->favourite_photos;
        if($favourite_things){
            foreach($favourite_things as $key=>$name){
                $data = [
                    'user_id' => $request->user()->currentTeam->owner_id,
                    'name' => $name,
                    'photo' => $favourite_photos[$key], 
                ];
                FavouriteThings::create($data);
            }
        }
        //Delete all the favourtie things and restore those newly
        Medications::where("user_id",$request->user()->currentTeam->owner_id)->delete();
        $medications = $request->medications;
        $medication_photos = $request->medication_photos;
        // dd($medications);
        if($medications){
            foreach($medications as $key=>$name){
                $data = [
                    'user_id' => $request->user()->currentTeam->owner_id,
                    'name' => $name,
                    'photo' => $medication_photos[$key], 
                ];
                Medications::create($data);
            }
        }
        
        return  redirect($request->user()->currentTeamName().'/about');
    }
    public function savePhoto(Request $request){
        $this->validate($request, [
            'photo' => 'image|max:5048',
        ]);
        $path = "";
        if ($request->file('photo')) {
            $file = $request->file('photo');
            
            $path = $file->store('public/profiles');
            Image::make($file)->orientate()->fit(500,500, function ($constraint) {
                $constraint->aspectRatio();
            })->save( public_path($path) );
            $path = '/'.$path;
        }
        return $path;
    }

}