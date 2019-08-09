<div class="form-group">
    <div>
        <span role="img" class="contact-photo-preview" style="background-image: url(&quot;https://www.gravatar.com/avatar/b8a912ad0f9a535e168b7f82d710fe38.jpg?s=200&amp;d=mm&quot);"></span>
    </div>
</div>
<div class="form-group {{ $errors->has('photo') ? 'has-error' :'' }}">
    <label type="button" class="btn btn-default btn-upload" >
        <span>Select new photo</span>
        <input ref="photo" type="file" id="file" class="form-control" name="photo">
        <div id="select-file"></div>
    </label>
    <input class="photolink" type="hidden" name="photolink" value="">
    <span class="help-block photo-error" style="color: #a94442;display: none;">
        Photo must be less than 5MB.
    </span>
</div>            
<div id="locationField" class="form-group {{ $errors->has('name') ? 'has-error' :'' }}" >
    <label class="control-label">Title *</label>
    <input id="reminder_title" type="text" class="form-control" name="title">
    <span class="help-block">
        {{$errors->first('title')}}
    </span>
</div>
<div class="form-group {{ $errors->has('address') ? 'has-error' :'' }}" >
    <label class="control-label">Date it starts *</label>
    <input id="reminder_date" type="text" class="form-control" name="start_date">
    <span class="help-block" >
        {{$errors->first('start_date')}}
    </span>
</div>
<div class="form-group {{ $errors->has('phone') ? 'has-error' :'' }}" >
    <label class="control-label">Time it starts</label>
    <input id="reminder_time" type="text" class="form-control" name="start_time">
    <span class="help-block">
        {{$errors->first('start_time')}}
    </span>
</div>
<div class="send-reminder form-group {{ $errors->has('send_sms') ? 'has-error' :'' }}">
    <div class="checkbox">
    <label><input id="send_sms" type="checkbox"  name="send_sms" >
    Send a reminder</label>
    </div>
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' :'' }}" >
    <label class="control-label">Repeat reminder</label>
    <select class="form-control" name="repeat_reminder" id="repeat_reminder">
        <option value="none">None</option>
        <option value="daily">Daily</option>
        <option value="weekly">Weekly</option>
        <option value="monthly">Monthly</option>
        <option value="yearly">Yearly</option>
    </select>
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' :'' }}" >
    <label class="control-label">Repeat until</label>
    <input id="repeat_until" type="text" class="form-control" name="repeat_until" value="">
</div>
<div class="form-group {{ $errors->has('website') ? 'has-error' :'' }}" >
    <label class="control-label">Details</label>
    <textarea id="details" class="form-control" name="details"></textarea>
    <span class="help-block" >
        {{$errors->first('website')}}
    </span>
</div>
<div class='main-group form-group center'>
    <div class="dropzone" id="myAwesomeDropzone"></div>
    <input class="reminder_video_upload" type="hidden" name="video_upload">
    <input class="reminder_thumb_upload" type="hidden" name="thumb_upload">
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script type="text/javascript">
    Dropzone.options.myAwesomeDropzone = {
            url: '/video-upload',
            paramName: 'video',
            maxFilesize: 20, // MB
            method :'post',
            addRemoveLinks: 'true',
            dictDefaultMessage: 'Add photo or video details', // MB 
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
                        $('.reminder_video_upload').val(result.video);
                        $('.reminder_thumb_upload').val(result.thumb);
                        $("#myAwesomeDropzone .dz-image img").attr("src","/thumbnails/"+result.thumb);
                        $("#myAwesomeDropzone .dz-image img").css("max-width","150px");
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
    // var myDropzone = new Dropzone(".dropzone");
</script>
<button class="btn btn-primary btn-block save-reminder">Save Reminder</button>