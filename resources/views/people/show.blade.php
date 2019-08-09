@extends('layouts/app')
@section('content')
<div class="row">
    <div class="m-people col-md-4 col-md-offset-4">
        <!-- Application Details -->
        <h3 class="text-center"><span class="m-back"><a href="/{{ Auth::user()->currentTeamName() }}/dashboard"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>People</h3>
       
       <div class="row">
        <span><a class="btn btn-default plus-button" href="/{{ Auth::user()->currentTeamName() }}/people/add">
        </a><a href="/{{ Auth::user()->currentTeamName() }}/people/add"><p style="padding: 10px; color: rgb(31, 132,114);font-size: 18px;">Add People</p></a></span>
        </div>
       
       @foreach ($people as $person)
            <div class="row">
                <div class="col-xs-3"><img @if($person->photo) src='{{ $person->photo }}' @else src="/img/icon-with.svg" @endif alt="Apponintment Image" class="img-responsive"></div>
                <div class="col-xs-6"><span class="name">{{$person->name}}</span><br><a href="tel:{{$person->phone}}" class="phone">{{$person->phone}}</a></div>
                <div class="col-xs-3">
                    <form method = "post" action="/{{ Auth::user()->currentTeamName() }}/people/{{$person->getUrlName()}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="person_id" value="{{$person->id}}">
                        <button type='submit' class='btn_edit_contact'><img class="edit-photo" src="/img/icon-edit-grey.svg"></button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
