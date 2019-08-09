@extends('layouts/app')
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>   
@endsection
@section('content')
<div class="row">
    <div class="m-diary-add col-md-4 col-md-offset-4">
        <span class="m-back"><a href="/{{Auth::user()->currentTeamName()}}/activities/view/{{$apt->id}}"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>
        <form role="form" enctype="" method="post" action="/activity/diary_save/{{ $apt->id }}">
        {{ csrf_field() }}
        <input type="hidden" name="from_mobile" value="1">
        <!-- Application Details -->
        <div class="main-group form-group">
          <div class="t-banner" >
            <div class="bg-img" style="background: url({{ $apt->photo }}) center center no-repeat; background-size: cover;"></div>
            
            <img src="{{ $apt->photo }}" class="img-circle" class="img-responsive">
          
        </div>
        </div>
        <h3 class="text-center">
            <span class="m-back"><a href="/{{Auth::user()->currentTeamName()}}/activities/view/{{$apt->id}}"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>{{ $apt->title }}
        </h3>
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 text-center">
                <label type="button" class="btn btn-default btn-icon btn-upload btn-block" id="checkin">
                    <i class="fa fa-2x fa-thumbs-up" aria-hidden="true"></i><span>Check in</span>
                    <input class="btn-hide" type="button">
                </label>
                
                <div class="alert alert-warning checkin-1" style='display:none'>Great 👍</div>
                <div class="alert alert-success checkin-2" style='display:none'>Great 👍</div>
                <div class="alert alert-success checkin-3" style='display:none'>Whoops, you should only check in when you arrive</div>
            </div>
        </div>
        <hr>
        <div class="no-border">
            <a class="btn-diary" data-toggle="collapse" href="#collapse-diary">
                Diary
            </a>
        </div><br>
        <div class="no-border {{ $errors->has('title') ? 'has-error' :'' }}">
            @if($edited || $diary->note)
                <div class="row  no-border no-margin-bottom">
                    <div class="col-xs-3">
                        <img src="/img/icon-diary-1.svg" alt="Apponintment Image" class="img-responsive">
                    </div>
                    <div class="col-xs-9">
                        <p>{{ $edited?$note:$diary->note }}</p>
                    </div>
                </div><br>
            @endif
            <button class="btn btn-primary btn-block write-note" type='button'>
                <img src="/img/icon-edit-fill.svg">{{ $edited?"Edit note":"Write a note"}}
            </button>
            <input type="hidden" value="{{ $edited?$note:$diary->note }}" name="diary_note">
            <span class="help-block">
                {{$errors->first('diary_note')}}
            </span>
        </div><br>
        @if($diary)
        <div class="main-group" id="media_display_container">
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
        <div class='main-group form-group center' id="media_container">
            <div class="dropzone" id="myAwesomeDropzone"></div>
            @if($diary)
                @foreach($diary->medias as $media)
                <input class="" type="hidden" name="video_upload[]" value="{{ $media->video }}">
                <input class="" type="hidden" name="thumb_upload[]" value="{{ $media->thumbnail }}">
                @endforeach
            @endif
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
        <script type="text/javascript">
            Dropzone.options.myAwesomeDropzone = {
                  url: '/video-upload',
                  paramName: 'video',
                  maxFilesize: 20, // MB
                  method :'post',
                  addRemoveLinks: 'true',
                  dictDefaultMessage: '<i class="fa fa-camera" aria-hidden="true"></i> Add photo or video', // MB 
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
                            }else{
                                $("#myAwesomeDropzone .dz-image img").attr("src","/thumbnails/"+result.thumb);
                                $("#myAwesomeDropzone .dz-image img").css("max-width","200px");
                                var html = "";
                                html += "<input class='' type='hidden' name='video_upload[]' value='"+result.video+"'>";
                                html += "<input class='' type='hidden' name='thumb_upload[]' value='"+result.thumb+"'>";
                                $("#media_container").append(html);
                                html = ""
                                if(result.video){
                                    html += "<video width='100%' controls style='border: 1px solid #e8eaec;' poster='/thumbnails/"+result.thumb+"'>";
                                    html += "<source src='/videos/"+result.video+"' type='video/mp4'>";
                                    html += "<source src='/videos/"+result.video+"' type='video/avi'>";
                                    html += "<source src='/videos/"+result.video+"' type='video/ogg'>";
                                    html += "</video>";
                                    $("#media_display_container").append(html);
                                }else if(result.thumb){
                                    html += "<img src='/thumbnails/"+result.thumb+"' class='' style='max-width:100%;margin:auto;display:block'><br>";
                                    $("#media_display_container").append(html);
                                }
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
        <div class="no-border">
            <a class="btn-diary-how">
                How was it?
            </a>
        </div><br>
        <div class='no-border'>
            <div class="btn-group colors btn-group-faces" data-toggle="buttons">
                <span class="btn btn-primary btn-good {{ $diary->state=='good'?'active':''}}">
                    <input type="radio" name="diary_status" value="good" autocomplete="off"> 
                    <label class='face_good'></label>
                    <br>
                    Good
                </span>
                <span class="btn btn-primary btn-ok {{ $diary->state=='ok'?'active':''}}">
                    <input type="radio" name="diary_status" value="ok" autocomplete="off"> 
                    <label class='face_ok'>
                        <i class='fa fa-meh-o'></i>
                    </label>
                    Ok
                </span>
                <span class="btn btn-primary btn-bad {{ $diary->state=='bad'?'active':''}}">
                    <input type="radio" name="diary_status" value="bad" autocomplete="off"> 
                    <label class='face_bad'></label>
                    <br>
                    Bad
                </span>
            </div>
            <span class="help-block">
                {{$errors->first('diary_status')}}
            </span>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 text-center"> 
                <button type="submit" class="btn btn-primary btn-block save-diary">
                    <img src='/img/icon-edit.svg' width="25px"> Save
                </button>
            </div>
        </div>
        </form>
        <form role="form" enctype="" id="write_note_form" method="post" action="/{{Auth::user()->currentTeamName()}}/diary/edit/{{ $apt->id }}">
            {{ csrf_field() }}
            <input type="hidden" value="{{ $edited?$note:$diary->note }}" name="diary_note">
        </form>
    </div>
</div>
@endsection

@section('bottom-scripts')

<script type="text/javascript">
    $(".write-note").on("click",function(){
        $("#write_note_form").submit();
    })
    $("#video_error").hide();
    $("#checkin").on("click",function(){
        axios.post('/api/checkin/{{ $apt->id }}')
            .then(response => {
                if(response.data == 0){
                    $(".checkin-1").show();
                    $(".checkin-2").hide();
                    $(".checkin-3").hide();
                }
                if(response.data == 1){
                    $(".checkin-2").show();
                    $(".checkin-1").hide();
                    $(".checkin-3").hide();
                }
                if(response.data == 2){
                    $(".checkin-3").show();
                    $(".checkin-1").hide();
                    $(".checkin-2").hide();
                }
            });
    })
</script>
@endsection
