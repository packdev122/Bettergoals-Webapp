@extends('layouts/app')
@section("scripts")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
@endsection
@section('content')
<about-me inline-template>

<div class="row">
    <div class="m-people col-md-4 col-md-offset-4">
        <span class="m-back"><a href="/{{ Auth::user()->currentTeamName() }}/dashboard"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>
        <div class="panel panel-content panel-default page-about-me">
            <div class="panel-heading no-border">
                <div class="about-me-heading">
                    @if($has_photo)
                        <div class='user_photo'>
                            <img src="{{ $user->photo_url }}" class="img-circle">
                        </div>
                    @else
                        <h1 class="text-center" style="font-size:60px"><i class="fa fa-user-circle-o" aria-hidden="true"></i></h1>
                    @endif
                    <h2 class="text-center">{{ $user->name }}</h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="eidt-about-me-click">
                    <a href="/{{ Auth::user()->currentTeamName() }}/about/edit" class='btn_edit_about_me'><img src="/img/icon-edit-grey.svg" class="edit_about_me_icon">Edit About Me</a>
                </div>
                <div class="row about-me-row">
                    <div class="col-xs-3">
                        <label class="label-image" for="home">
                            <img @if($about && $about->live_place) @if($about->live_place->photo) src='{{ $about->live_place->photo }}' @else src="/img/icon-home.svg" @endif @else src="/img/icon-home.svg" @endif alt="Home" class="img-responsive">
                        </label>
                    </div>
                    <div class="col-xs-9">
                        <p>I live at</p>
                        <p>
                            <a href="{{ $live_map }}" target="_blank" class='address_link'>
                                {{ $about ? $about->live_place?$about->live_place->name:"" : "" }}<br>
                                {{ $live_address }}
                            </a>
                        </p>
                    </div>
                </div>
                <div class="row about-me-row">
                    <div class="col-xs-3">
                        <label class="label-image" for="home">
                            <img @if($about && $about->work_place) @if($about->work_place->photo) src='{{ $about->work_place->photo }}' @else src="/img/icon-work.svg" @endif @else src="/img/icon-work.svg" @endif alt="home" class="img-responsive">
                        </label>
                    </div>
                    <div class='col-xs-9'>
                        <p>I work at</p>
                        <p class="pvalue">
                            <a href="{{ $work_map }}" target="_blank" class='address_link'>
                                {{ $about ? $about->work_place?$about->work_place->name:"" : "" }}<br>
                                {{ $work_address }}
                            </a>
                        </p>
                    </div>
                </div>
                
                <div class="row no-border">
                    <a class="btn btn-primary accordion_favourite_people" data-toggle="collapse" href="#collapse-my-fav-things">
                        <img src="/img/icon-users.svg" class='accordion_img'> My favorite people
                    </a>
                </div>
                <div class="row panel-collapse collapse no-border no-margin-bottom" id="collapse-my-fav-things">
                    @foreach($favourite_people as $people)
                    <div class="about-me-row div_favourite_people">
                        <div class="col-xs-3">
                            <label class="label-image" for="home"><img @if($people->photo)src="{{$people->photo}}" @else src="/img/icon-with.svg" @endif alt="home" class="img-responsive"></label>
                        </div>
                        <div class='col-xs-9'>
                            <p class="pvalue" >
                                {{ $people->name }}<br>
                                <a href="tel:{{ $people->phone }}" class="phone address_link">{{ $people->phone }}</a>
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row no-border">
                    <a class="btn btn-danger accordion_favourite_things" data-toggle="collapse" href="#collapse-favourite-things">
                        <i class="fa fa-check" aria-hidden="true"></i> My favourite things
                    </a>
                </div>
                <div class="row panel-collapse collapse no-border no-margin-bottom" id="collapse-favourite-things">
                    @foreach($favourite_things as $favourite)
                    <div class="about-me-row div_favourite_things">
                        <div class="col-xs-3">
                            <label class="label-image" for="home"><img @if($favourite->photo)src="{{$favourite->photo}}" @else src="/img/icon-check.svg" @endif alt="home" class="img-responsive"></label>
                        </div>
                        <div class='col-xs-9'>
                            <p class="pvalue" >
                                {{ $favourite->name }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row no-border">
                    <a class="btn btn-success accordion_my_health" data-toggle="collapse" href="#collapse-my-health">
                        <img src="/img/icon-health.svg" class='accordion_img'> My health
                    </a>
                </div>
                <div class="row panel-collapse collapse no-border" id="collapse-my-health">
                    @foreach($medications as $medication)
                    <div class="about-me-row div_medications">
                        <div class="col-xs-3">
                            <label class="label-image" for="home"><img @if($medication->photo)src="{{$medication->photo}}" @else src="/img/icon-medication.png" @endif alt="home" class="img-responsive"></label>
                        </div>
                        <div class='col-xs-9'>
                            <p>My medication is</p>
                            <p class="pvalue" >
                                {{ $medication->name }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                    <div class="about-me-row">
                        <div class="col-xs-3">
                            <label class="label-image" for="home">
                                <img @if($about && $about->doctor) @if($about->doctor->photo) src='{{ $about->doctor->photo }}' @else src="/img/icon-doctor.png" @endif @else src="/img/icon-doctor.png" @endif alt="Doctor" class="img-responsive">
                            </label>
                        </div>
                        <div class='col-xs-9'>
                            <p>My doctor is</p>
                            <p class="pvalue" >
                                <a href="{{ $doctor_map }}" target="_blank" class="address_link">
                                    {{ $about ? $about->doctor?$about->doctor->name:"" : "" }}<br>
                                    {{ $doctor_address }}
                                </a>
                            </p>
                        </div>
                    </div><br>
                    <div class="about-me-row">
                        <div class="col-xs-3">
                            <label class="label-image" for="home"><img src="/img/icon-call.svg" alt="home" class="img-responsive"></label>
                        </div>
                        <div class='col-xs-9'>
                            <p class="pvalue" >
                                Call {{ $about ? $about->doctor?$about->doctor->name:"" : "" }}<br>
                                <a href="tel:{{ $about ? $about->doctor?$about->doctor->phone:'' : '' }}" class='phone address_link'>{{ $about ? $about->doctor?$about->doctor->phone:"" : "" }}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row no-border">
                    <a class="btn btn-primary accordion_emergency" data-toggle="collapse" href="#collapse-my-emergency">
                        <img src="/img/icon-users.svg" class='accordion_img'> My emergency contact
                    </a>
                </div>
                <div class="row panel-collapse collapse no-border no-margin-bottom" id="collapse-my-emergency">
                    <!-- <div class="about-me-row div_favourite_people">
                        <div class="col-xs-3">
                            <img src="/img/icon-with.svg" alt="Calendar" class="img-responsive">
                        </div>
                        <div class='col-xs-9'>
                            <p class="pvalue" >
                                First & last name<br>
                                {{ $user->emergency_name }}
                            </p>
                        </div>
                    </div>
                    <div class="about-me-row div_favourite_people">
                        <div class="col-xs-3">
                            <img src="/img/icon-call.svg" alt="Calendar" class="img-responsive">
                        </div>
                        <div class='col-xs-9'>
                            <p class="pvalue" >
                                Mobile number<br>
                                {{ $user->emergency_phone }}
                            </p>
                        </div>
                    </div> -->
                    @if($about)
                        @if($about->emergency)
                        <div class="about-me-row div_favourite_people">
                            <div class="col-xs-3">
                                <label class="label-image" for="home">
                                    <img @if($about->emergency->photo)src="{{$about->emergency->photo}}" @else src="/img/icon-with.svg" @endif alt="home" class="img-responsive">
                                </label>
                            </div>
                            <div class='col-xs-9'>
                                <p class="pvalue" >
                                    {{ $about ? $about->emergency?$about->emergency->name:"" : "" }}<br>
                                    <a href='tel:{{ $about ? $about->emergency?$about->emergency->phone:"" : "" }}' class="phone address_link">{{ $about ? $about->emergency?$about->emergency->phone:"" : "" }}</a>
                                </p>
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</about-me>
@endsection