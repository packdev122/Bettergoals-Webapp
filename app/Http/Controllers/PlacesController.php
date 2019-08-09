<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organisation;
use App\Common;
class PlacesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('subscribed');
    }

    public function show(Request $request ,$team_name)
    {

        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $map = '#';
        $address = '';
        $places =  $request->user()->currentTeam->organisations;
        foreach ($places as $place) {
            if (isset($place->address)) {
                $map = "http://maps.google.com/maps?daddr=". urlencode($place->address) . "&directionsmode=transit";
                $address = $place->address;
            }
            $address = Common::getAddressWithoutCountry($address);
            $place->address = $address;
            $place->map = $map;
        }
        return view('places/show', compact('places'));
    }

    

    public function edit(Request $request , $team_name , $name)
    {
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $id = $request->place_id;
        $organisation = Organisation::find($id);
        return view('places/edit', compact('organisation'));
    }

    public function add(Request $request , $team_name)
    {
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $organisation = new Organisation;
        return view('places/edit', compact('organisation'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required|max:250',
            'address' => 'required|max:250',
            'email' => 'email',
            'website'  => ['regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
        ]);

        if ($request->photolink == null) {
            $request->photolink = '/img/icon-where.svg';
        }

        // TO DO:: Fill with TEAM ID and then save whole contact
        // dd($request);
        Organisation::create([
            'team_id' => $request->user()->currentTeam->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'website' => $request->website,
            'photo' => $request->photolink
        ]);
        return  redirect($request->user()->currentTeamName().'/places');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 
         $this->validate($request, [
            'name' => 'required|max:250',
            'address' => 'required|max:250',
            'email' => 'email',
            'website'  => ['regex:/^((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)$/'],
        ]);
        $team_id = $request->user()->currentTeam->id;
        $contact = Organisation::where([['id', $id], ['team_id', $team_id]])->first();
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->address = $request->address;
        $contact->website = $request->website;
        if ($request->photolink) {
            $contact->photo = $request->photolink;
        }
        $contact->save();
        return  redirect($request->user()->currentTeamName().'/places');
    }
}
