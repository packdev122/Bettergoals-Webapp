@extends('layouts/app')
@section('content')
<mobile-reminder :reminder="{{json_encode($reminder)}}" inline-template>
<div class="row">
    <div class="t-banner" >
        <div class="bg-img" style="background: url({{ $reminder->photo?$reminder->photo:'/img/default.png' }}) center center no-repeat; background-size: cover;"></div>
        <img src="{{ $reminder->photo?$reminder->photo:'/img/default.png' }}" class="img-circle">
    </div>
    <div class=" m-appoint col-md-4 col-md-offset-4">
        <!-- Application Details -->
        <h3 class="text-center"><span class="m-back"><a href="/{{ Auth::user()->currentTeamName() }}/activities"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>{{ $reminder->title }}</h3>
        <div class="row">
            <div class="col-xs-3">
                <img src="/img/icon-calendar.svg" alt="Calendar">
            </div>
            <div class="col-xs-9">
                <p>{{ $reminder->start_date?$reminder->start_date->format('l'):"" }}<br>{{ $reminder->start_date?$reminder->start_date->format('d/m/Y'):"" }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <img src="/img/icon-time.svg" alt="Reminder Image" class="img-responsive">
            </div>
            <div class="col-xs-9">
                <p>{{ $reminder->start_date?$reminder->start_date->format('g:ia'):"" }} </p>
            </div>
        </div>
        
        <div class="main-group row form-group {{ $errors->has('$apt->detail') ? 'has-error' :'' }}">
            @if($reminder->detail || $reminder->video)
            <div class="col-xs-3">
                <img src="/img/icon-details.svg" style="margin-top: 5px;" alt="Detail Icon" class="img-responsive">
            </div>
            @endif
            @if($reminder->detail)
            <div class="col-xs-9">
                <p >{{ $reminder->detail }}</p>
            </div>
            @endif
        </div>
        <div style="" class='main-group form-group'>
            @if($reminder->video)
            <video width="100%" controls style='border: 1px solid #e8eaec;' poster="/thumbnails/{{$reminder->thumbnail}}">
                <source src="/videos/{{$reminder->video}}" type="video/mp4">
                <source src="/videos/{{$reminder->video}}" type="video/avi">
                <source src="/videos/{{$reminder->video}}" type="video/ogg">
            </video>
            @elseif($reminder->thumbnail)
                <img src="/thumbnails/{{$reminder->thumbnail}}" class="img-responsive">
            @endif
        </div>
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 text-center">
                <label type="button" class="btn btn-default btn-icon btn-upload btn-block" :disabled="form.busy">
                    <i class="fa fa-2x fa-thumbs-up" aria-hidden="true"></i><span>Done</span>
                    <input class="btn-hide" type="Submit" @click.prevent="checkIn">
                </label>
                
                <div class="alert alert-warning" v-show="checkin=='0'">Great 👍</div>
                <div class="alert alert-success" v-show="checkin=='1'">Great 👍</div>
                <div class="alert alert-success" v-show="checkin=='2'">Whoops, you should only done in when the Reminder starts</div>
                <form method="POST" @submit.prevent="" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <label type="button" class="btn btn-default btn-icon btn-upload btn-block" :disabled="form.busy">
                        <i class="fa fa-camera fa-2x" aria-hidden="true"></i><span>Add photo</span>
                        <input id="file" v-on:change="createPhoto"  type="file" accept="image/*" >
                    </label>
                </form>
            </div>
        </div>
        <hr>
        
        <!-- Photo -->
        <div class="row" v-show="photos.length > 0">
            <div class="col-xs-12" v-for="photo in photos">
                <img :src="'/public/photo/' + photo.photo" class="img-responsive" alt="reminder photos">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 text-center"> 
                <a href="/{{Auth::user()->currentTeamName()}}/reminder/edit/{{ $reminder->id }}" class="btn btn-primary btn-block edit-appointment">Edit Reminder</a>
            </div>
        </div>
    </div>
</div>
</mobile-reminder>
@endsection

@section('scripts')
<script src="/js/exif.js"></script>
<script src="/js/load-image.all.min.js"></script>
@endsection
