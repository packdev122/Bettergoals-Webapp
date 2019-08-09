@extends('layouts/app')
@section('scripts')
<link rel="stylesheet" type="text/css" href="/css/jquery.timepicker.css" />
<link rel="stylesheet" type="text/css" href="/css/bootstrap-datepicker.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/select2/4.0.3/css/select2.min.css">
@endsection
@section('content')
<div class="row">
    <div class="m-appoint-add col-md-4 col-md-offset-4">
        <span class="m-back"><a href="/{{Auth::user()->currentTeamName()}}/reminder/{{$reminder->id}}"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>
        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
              @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
              @endif
            @endforeach
        </div> <!-- end .flash-message -->
        <form role="form" enctype="multipart/form-data" method="post" action="/reminder/update/{{ $reminder->id }}">
        {{ csrf_field() }}
        <input type="hidden" name="from_mobile" value="1">
        <input type="hidden" name="reminder_id" value="{{ old('reminder_id', $reminder->id) }}">
        <!-- Application Details -->
        <div class="main-group form-group">
          <div class="t-banner" >
            <div class="bg-img" style="background: url({{ $reminder->photo }}) center center no-repeat; background-size: cover;"></div>
            <img src="{{ $reminder->photo }}" class="img-circle" class="img-responsive">
          </div>
        </div>
        <div class="main-group form-group upload-box center {{ $errors->has('main_photo') ? 'has-error' :'' }}">
          <label type="button" class="btn btn-default btn-upload" >
            <span>Upload an image</span>
            <input ref="main_photo" type="file" class="form-control" name="main_photo" onchange='getFilename(this)' >
            <div id="select-file"></div>
          </label>
          
          <span class="help-block" >
             {{$errors->first('main_photo')}}
          </span>
        </div>
        <div class="main-group row form-group center {{ $errors->has('title') ? 'has-error' :'' }}">
            <div class="col-xs-12">
                <label class="label-title">Title</label>
                <input type="text" name="title" value="{{ old('title', $reminder->title) }}">
            </div>
        </div>
        <div class="main-group row form-group {{ $errors->has('start_date') ? 'has-error' :'' }}">
            <div class="col-xs-4">
                <label class="label-image" for="datestart"><img src="/img/icon-calendar.svg" alt="Calendar" class="img-responsive">
            </div>
            <div class="col-xs-8">
                <label>Date it starts</label>
                <input id="datestart" type="text" name="start_date" value="{{ old('start_date', $reminder->start_date->format('d-m-Y')) }}">
            </div>
        </div>
        <div class="main-group row form-group {{ $errors->has('start_time') ? 'has-error' :'' }}">
            <div class="col-xs-4">
                <label class="label-image" for="timestart"><img src="/img/icon-time.svg" alt="Apponintment Start Time" class="img-responsive">
            </div>
            <div class="col-xs-8">
                <label>Time it starts</label>
                <input id="timestart" type="text" name="start_time" value="{{ old('start_time', $reminder->start_date->format('g:ia')) }}">
            </div>
        </div>
        <div class="main-group row form-group {{ $errors->has('$apt->detail') ? 'has-error' :'' }}">
            <div class="col-xs-4">
                <img src="/img/icon-details.svg" style="margin-top: 5px;" alt="Detail Icon" class="img-responsive">
            </div>
            <div class="col-xs-8">
                <label class="control-label">Details</label>
                <textarea id="detail" class="form-control" rows="5" name="detail">{{ old('detail', $reminder->detail) }}</textarea>
                <span class="help-block">
                    {{$errors->first('detail')}}
                </span>
            </div>
        </div>
        <div class="main-group">
            @if($reminder->video)
            <video width="100%" controls style='border: 1px solid #e8eaec;' poster="/thumbnails/{{$reminder->thumbnail}}">
                <source src="/videos/{{$reminder->video}}" type="video/mp4">
                <source src="/videos/{{$reminder->video}}" type="video/avi">
                <source src="/videos/{{$reminder->video}}" type="video/ogg">
            </video>
            @elseif($reminder->thumbnail)
                <img src="/thumbnails/{{$reminder->thumbnail}}" class="" style="max-width:100%;margin:auto;display:block">
            @endif
        </div>
        <div class='main-group row form-group center'>
            <div class="dropzone" id="myAwesomeDropzone"></div>
            <input class="video_upload" type="hidden" name="video_upload" value="{{ $reminder->video }}">
            <input class="thumb_upload" type="hidden" name="thumb_upload" value="{{ $reminder->thumbnail }}">
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
        <script type="text/javascript">
            Dropzone.options.myAwesomeDropzone = {
                  url: '/video-upload',
                  paramName: 'video',
                  maxFilesize: 20, // MB
                  method :'post',
                  addRemoveLinks: 'true',
                  dictDefaultMessage: 'Add a photo or video details', // MB 
                    init: function () {
                        this.on("sending", function(file, xhr, formData) {
                            // Will send the filesize along with the file as POST data.
                            formData.append("_token", "{{ csrf_token() }}");
                            formData.append("appointment", "");
                            $("#myAwesomeDropzone .dz-success-mark").hide();
                            $("#myAwesomeDropzone .dz-error-mark").hide();
                            $(".dz-remove").on("click",function(){
                                $("#myAwesomeDropzone .dz-default").show();
                            })
                        });
                        this.on('success', function (file, result) {
                            if(result.video == "invalid_type"){
                                $("#myAwesomeDropzone .dz-error-message span").html("Invalid File Type");
                            }
                            else{
                                $('.video_upload').val(result.video);
                                $('.thumb_upload').val(result.thumb);
                                $("#myAwesomeDropzone .dz-image img").attr("src","/thumbnails/"+result.thumb);
                                $("#myAwesomeDropzone .dz-image img").css("max-width","200px");
                            }
                            $("#myAwesomeDropzone .dz-default").hide();
                            $("#myAwesomeDropzone .dz-details").hide();
                        })
                        this.on("error",function(file, errormessage, xhr){
                            if(errormessage.length > 100){
                                $("#myAwesomeDropzone .dz-error-message span").html("File Upload Error");
                            }else{
                                $("#myAwesomeDropzone .dz-error-message span").html(errormessage);
                            }
                            $("#myAwesomeDropzone .dz-success-mark").hide();
                            $("#myAwesomeDropzone .dz-error-mark").hide();
                        })
                    }
                };
            var myDropzone = new Dropzone(".dropzone");
            
        </script>
        <hr>
        <button type="submit" class="btn btn-primary btn-block save-btn">
        Save Reminder
        </button>
        </form>
    </div>
</div>
@endsection

@section('bottom-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.timepicker.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/js/datepair.min.js"></script>
<script type="text/javascript" src="/js/jquery.datepair.min.js"></script>
<script type="text/javascript">
    $('input[name="start_date"]').datepicker({
      'format': 'd-m-yyyy',
      'weekStart' : 1,
      'autoclose': true
    });
    $('input[name="start_time"]').timepicker({
      'showDuration': true,
      'scrollDefault': '06:30',
      'timeFormat': 'g:ia'
    });
</script>
@endsection
