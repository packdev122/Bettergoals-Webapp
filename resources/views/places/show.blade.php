@extends('layouts/app')
@section('content')
<div class="row">
    <div class="m-people col-md-4 col-md-offset-4">
        <!-- Application Details -->
        <h3 class="text-center"><span class="m-back"><a href="/{{ Auth::user()->currentTeamName() }}/dashboard"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>Places</h3>
        
        <div class="row">
        <span><a class="btn btn-default plus-button" href="/{{ Auth::user()->currentTeamName() }}/places/add">
        </a><a href="/{{ Auth::user()->currentTeamName() }}/places/add"><p style="padding: 10px; color: rgb(31, 132,114);font-size: 18px;">Add Places</p></a></span>
        </div>
        
        @foreach ($places as $place)
            <div class="row">
                <div class="col-xs-3"><img @if($place->photo) src='{{ $place->photo }}' @else src="/img/icon-where.svg" @endif alt="Place Image" class="img-responsive"></div>
                <div class="col-xs-6"><a target="_blank" href="{{$place->map}}" class="name">{{$place->name}}<br>{{$place->address}}</a></div>
                <div class="col-xs-3">
                    <form method = "post" action="/{{ Auth::user()->currentTeamName() }}/places/{{$place->getUrlName()}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="place_id" value="{{$place->id}}">
                        <button type='submit' class='btn_edit_contact'><img class="edit-photo" src="/img/icon-edit-grey.svg"></button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
