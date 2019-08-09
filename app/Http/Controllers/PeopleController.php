<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Intervention\Image\Facades\Image;

class PeopleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('subscribed');
    }
    public function show(Request $request , $team_name)
    {
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $people =  $request->user()->currentTeam->contacts;
        return view('people/show', compact('people'));
    }
    public function edit(Request $request , $team_name , $name)
    {
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $id = $request->person_id;
        $contact = Contact::find($id);
        return view('people/edit', compact('contact'));
    }

    public function add(Request $request , $team_name)
    {
        if(!$this->teamValidation($team_name , $request->user())){
            $this->showTeamMatchingError();
            return;
        }
        $contact = new Contact;
        return view('people/edit', compact('contact'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:250',
            'email' => 'email',
            'phone' => 'required'
        ]);

        if ($request->photolink == null) {
            $request->photolink = '/img/icon-with.svg';
        }
        // TO DO:: Fill with TEAM ID and then save whole contact
        Contact::create([
            'team_id' => $request->user()->currentTeam->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'organisation' => $request->organisation,
            'photo' => $request->photolink
        ]);
        return  redirect($request->user()->currentTeamName().'/people');
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
        $this->validate($request, [
            'name'  => 'required|max:250',
            'phone' => 'required',
            'email' => 'email',
        ]);
        $team_id = $request->user()->currentTeam->id;
        $contact = Contact::where([['id', $id], ['team_id', $team_id]])->first();
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->address = $request->address;
        $contact->organisation = $request->organisation;
        if ($request->photolink) {
            $contact->photo = $request->photolink;
        }
        $contact->save();
        return  redirect($request->user()->currentTeamName().'/people');
    }

}