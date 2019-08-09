@extends('layouts/app')
@section('content')

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<mobile-appointment :appointment="{{json_encode($appointment)}}" inline-template>
<div class="row m-detail-appointment">
    <div class="t-banner" >
        <div class="bg-img" style="background: url({{ $appointment->photo }}) center center no-repeat; background-size: cover;"></div>
        <img src="{{ $appointment->photo }}" class="img-circle">
    </div>
    <div class=" m-appoint col-md-4 col-md-offset-4">
        <!-- Application Details -->
        <h3 class="text-center"><span class="m-back"><a href="{{ URL::previous() }}"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>{{ $appointment->title }}</h3>
        <div class="row">
            <div class="col-xs-3">
                <img src="/img/icon-calendar.svg" alt="Calendar">
            </div>
            <div class="col-xs-9">
                <p>{{ $appointment->start_date?$appointment->start_date->format('l'):"" }}<br>{{ $appointment->start_date?$appointment->start_date->format('d/m/Y'):"" }}</p>
             
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <img src="/img/icon-time.svg" alt="Apponintment Image" class="img-responsive">
            </div>
            <div class="col-xs-9">
                <p>From {{ $appointment->start_date?$appointment->start_date->format('g:ia'):"" }}<br>to {{ $appointment->end_date?$appointment->end_date->format('g:ia'):"" }}</p>
            </div>
        </div>
        @if ($map != '#')
        <div class="row">
            <div class="col-xs-3">
                <a href="{{ $map }}"><img @if($appointment->organisation && $appointment->organisation->photo) src='{{ $appointment->organisation->photo }}' style='margin-top: 5px;' @else src="/img/icon-where.svg" @endif alt="Apponintment Image" class="img-responsive"></a>
            </div>
            <div class="col-xs-9">
                <p> <a href="{{ $map }}">
                @if ($appointment->organisation) {{$appointment->organisation->name}} @endif
                <br>{{ $address }}</a></p>
            </div>
        </div>
        @endif
        @if ($appointment->organisation && $appointment->organisation->phone != '')
        <div class="row">
            <a href="tel:{{ $appointment->organisation->phone}}">
                <div class="col-xs-3">
                    <img src="/img/icon-call.svg" alt="Apponintment Image" class="img-responsive">
                </div>
                <div class="col-xs-9">
                    <p>Call {{$appointment->organisation->name}}<br> <span class="phone-number">{{$appointment->organisation->phone}}</span></p>
                </div>
            </a>
        </div>
        @endif
        @if ($appointment->contact)
        <div class="row">
            <a href="tel:{{ $appointment->contact->phone}}">
            <div class="col-xs-3">
                <img @if($appointment->contact->photo) src='{{ $appointment->contact->photo }}' style='margin-top: 5px;' @else src="/img/icon-with.svg" @endif alt="Apponintment Image" class="img-responsive">
            </div>
            <div class="col-xs-9">
                <p>With {{ $appointment->contact->name }}<br> <span class="phone-number">{{ $appointment->contact->phone}}</span></p>
            </div>
            </a>
        </div>
        @endif
        
        <div class="row">
            @if($appointment->detail || $appointment->video)
            <div class="col-xs-3">
                <img src="/img/icon-details.svg" alt="Detail Icon">
            </div>
            @endif
            @if($appointment->detail)
            <div class="col-xs-9">
                <p>{{$appointment->detail}}</p>
            </div>
            @endif
        </div>
        
        <div style="padding-top: 20px;">
            @if($appointment->video)
            <video width="100%" controls style='border: 1px solid #e8eaec;' poster="/thumbnails/{{$appointment->thumbnail}}">
                <source src="/videos/{{$appointment->video}}" type="video/mp4">
                <source src="/videos/{{$appointment->video}}" type="video/avi">
                <source src="/videos/{{$appointment->video}}" type="video/ogg">
            </video>
            @elseif($appointment->thumbnail)
                <img src="/thumbnails/{{$appointment->thumbnail}}" class="img-responsive">
            @endif

            @foreach($activity_photos as $activity_photo)
                <img src="/thumbnails/{{$activity_photo->photo}}" class="img-responsive">
            @endforeach

        </div>

        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 text-center">
                <label type="button" class="btn btn-default btn-icon btn-upload btn-block" :disabled="form.busy">
                    <i class="fa fa-2x fa-thumbs-up" aria-hidden="true"></i><span>Check in</span>
                    <input class="btn-hide" type="Submit" @click.prevent="checkIn">
                </label>
                
                <div class="alert alert-warning" v-show="checkin=='0'">Great 👍</div>
                <div class="alert alert-success" v-show="checkin=='1'">Great 👍</div>
                <div class="alert alert-success" v-show="checkin=='2'">Whoops, you should only check in when you arrive</div>
                <!-- <form method="POST" @submit.prevent="" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <label type="button" class="btn btn-default btn-icon btn-upload btn-block" :disabled="form.busy">
                        <i class="fa fa-camera fa-2x" aria-hidden="true"></i><span>Add photo</span>
                        <input id="file" v-on:change="createPhoto"  type="file" accept="image/*" >
                    </label>
                </form> -->
            </div>
        </div>
        <hr>
        <div class="no-border">
            <a class="btn-diary"  href="javascript:;">
                Diary
            </a>
        </div>
        <div class="panel-collapse " id="collapse-diary">
            @if($diary)
            @if($diary->note)
            <div class="row  no-border no-margin-bottom">
                <div class="col-xs-3">
                    <img src="/img/icon-diary-1.svg" alt="Apponintment Image" class="img-responsive">
                </div>
                <div class="col-xs-9">
                    <p>{{ $diary->note }}</p>
                </div>
            </div>
            @endif
            @if($diary->state)
            <div class="row no-border no-margin-bottom">
                <div class="col-xs-3">
                    <span class="span-face">
                        @if($diary->state == "good")
                            <img src="/img/face_good_2.svg"class='img-responsive'>
                        @endif
                        @if($diary->state == "ok")
                            <i class="fa fa-meh-o"></i>
                        @endif
                        @if($diary->state == "bad")
                            <img src="/img/face_bad_2.svg" class='img-responsive'>
                        @endif
                    </span>
                </div>
                <div class="col-xs-9">
                    <p>It was {{ $diary->state }}</p>
                </div>
            </div>
            @endif
            <div style="padding-top: 20px;">
                @foreach($diary->medias as $media)
                    @if($media->video)
                    <video width="100%" controls style='border: 1px solid #e8eaec;' poster="/thumbnails/{{$media->thumbnail}}">
                        <source src="/videos/{{$media->video}}" type="video/mp4">
                        <source src="/videos/{{$media->video}}" type="video/avi">
                        <source src="/videos/{{$media->video}}" type="video/ogg">
                    </video>
                    @elseif($media->thumbnail)
                        <img src="/thumbnails/{{$media->thumbnail}}" class="" style="max-width:100%;margin:auto;display:block">
                        <br>
                    @endif
                @endforeach
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 text-center"> 
                <a href="/{{ Auth::user()->currentTeamName() }}/diary/edit/{{ $appointment->id }}" class="btn btn-primary btn-block edit-diary"><img src="/img/icon-edit-fill.svg">Add or edit diary entry</a>
            </div>
        </div>
        <hr>
        @foreach ($tasks as $key => $task)
        <h5>
            @if ($task->order === 10) Get ready @endif
            @if ($task->order === 20) Getting there @endif
            @if ($task->order === 30) After appointment @endif
        </h5>
        <div class="row">
            <a href="/{{ Auth::user()->currentTeamName() }}/task/{{$task->id}}">
                <div class="col-xs-3">
                    <img src="/img/icon-time.svg" alt="Appointment Photo" class=" img-responsive">
                </div>
                <div class="col-xs-9">   
                    <p><strong>{{ $task->start_date->format('g:ia') }}</strong> </br>
                    {{ $task->title }}
                    </p> 
                </div>
            </a>
        </div>
        <div class="row">
            @if($task->video)
            <div class="col-xs-3">
                <img src="/img/icon-details.svg" alt="Detail Icon">
            </div>
            @endif
        </div>
        <div style="">
            @if($task->video)
            <video width="100%" controls style='border: 1px solid #e8eaec;'poster="/thumbnails/{{$task->thumbnail}}" >
                <source src="/videos/{{$task->video}}" type="video/mp4">
                <source src="/videos/{{$task->video}}" type="video/avi">
                <source src="/videos/{{$task->video}}" type="video/ogg">
            </video>
            @elseif($task->thumbnail)
                <img src="/thumbnails/{{$task->thumbnail}}" class="img-responsive">
            @endif
        </div>
        @endforeach


        <!-- Photo -->

        <!--
        <div class="row" v-show="photos.length > 0">
            <div class="col-xs-12" v-for="photo in photos">
                <img :src="'/public/photo/' + photo.photo" class="img-responsive" alt="event photos">
            </div>
        </div>
        -->


        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 text-center"> 
                <a href="/{{Auth::user()->currentTeamName()}}/activities/edit/{{ $appointment->id }}" class="btn btn-primary btn-block edit-appointment">Edit appointment</a>
            </div>
        </div>
    </div>
</div>
</mobile-appointment>
@endsection

@section('scripts')
<script src="/js/exif.js"></script>
<script src="/js/load-image.all.min.js"></script>
@endsection
