@extends('layouts/app')
@section("scripts")
    <link rel="stylesheet" type="text/css" href="/css/jquery.timepicker.css" />
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/select2/4.0.3/css/select2.min.css">
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
                            <img src="{{ $user->photo_url }}" class="img-circle" id="user_photo">
                        </div>
                    @else
                        <div class='user_photo'>
                        <!-- <h1 class="text-center" style="font-size:60px"><i class="fa fa-user-circle-o" aria-hidden="true"></i></h1> -->
                            <img src = "https://www.gravatar.com/avatar/b8a912ad0f9a535e168b7f82d710fe38.jpg?s=200&d=mm" class="img-circle" id='user_photo'>
                        </div>
                    @endif
                    <h2 class="text-center">{{ $user->name }}</h2><br>
                </div>
            </div>
            <div class="panel-body">
            <form role="form" enctype="multipart/form-data" method="post" action="/about-me/save">
                {{ csrf_field() }}
                <input type="hidden" name="from_mobile" value="1">
                <div class="main-group form-group upload-box center {{ $errors->has('main_photo') ? 'has-error' :'' }}">
                    <input type="hidden" name = "profile_photo" id="profile_photo" value="{{$user->photo_url}}">
                    <label type="button" class="btn btn-default btn-upload" style='width:auto'>
                        <span>Select new photo</span>
                        <input ref="main_photo" type="file" class="form-control" name="main_photo" onchange='getFilename(this)' >
                        <div id="select-file"></div>
                    </label>
                    <span class="help-block" >
                        {{$errors->first('main_photo')}}
                    </span>
                </div>
                <div class="row about-me-row">
                    <div class="col-xs-4">
                        <label class="label-image" for="home"><img src="/img/icon-home.svg" alt="Home" class="img-responsive icon-size"></label>
                    </div>
                    <div class="col-xs-8">
                        <p class="edit_p">I live at</p>
                        <select class="select2 form-control select_organisations" name="live_organisation_id" >
                            <option value="0">None</option>
                            @foreach ($organisations as $organisation)
                                <option id="whereareyougoing" value="{{$organisation->id}}" @if($about) @if ( $about->live_place_id == $organisation->id ) selected="selected" @endif @endif >{{$organisation->name}}</option>
                            @endforeach
                        </select>
                        <span class="help-block">
                            {{$errors->first('organisation_id')}}
                        </span>
                        <a data-toggle="collapse" data-target="#addliveorganisation">+Add place or organisation</a>
                        <div id="addliveorganisation" class="addorganisation collapse">
                        <span class="help-block" style="display: none;color: #a94442;">
                            Please fill in the required field.
                        </span>
                        @include('partials.addorganisation')
                        </div>
                    </div>
                </div>
                <div class="row about-me-row no-border">
                    <div class="col-xs-4">
                        <label class="label-image" for="home"><img src="/img/icon-work.svg" alt="home" class="img-responsive icon-size"></label>
                    </div>
                    <div class='col-xs-8'>
                        <p class="edit_p">I work at</p>
                        <select class="select2 form-control select_organisations" name="work_organisation_id">
                            <option value="0">None</option>
                            @foreach ($organisations as $organisation)
                                <option id="whereareyougoing" value="{{$organisation->id}}" @if($about) @if ($about->work_place_id == $organisation->id ) selected="selected" @endif @endif>{{$organisation->name}}</option>
                            @endforeach
                        </select>
                        <span class="help-block">
                            {{$errors->first('organisation_id')}}
                        </span>
                        <a data-toggle="collapse" data-target="#addworkorganisation">+Add place or organisation</a>
                        <div id="addworkorganisation" class="addorganisation collapse">
                        <span class="help-block" style="display: none;color: #a94442;">
                            Please fill in the required field.
                        </span>
                        @include('partials.addorganisation')
                        </div>
                    </div>
                </div>

                <div class="row no-border">
                    <a class="btn btn-primary accordion_favourite_people" data-toggle="collapse" href="#collapse-my-fav-things">
                        <img src="/img/icon-users.svg" class='accordion_img'> My favourite people
                    </a>
                </div>
                <div class="row panel-collapse collapse no-border" id="collapse-my-fav-things">
                    <div id='favourite_people_container'>
                        @foreach($favourite_people as $people)
                        <div class="about-me-row div_favourite_people">
                            <div class="col-xs-4">
                                <label class="label-image" for="home"><img @if($people->photo)src="{{$people->photo}}" @else src="/img/icon-with.svg" @endif alt="home" class="img-responsive icon-size"></label>
                            </div>
                            <div class='col-xs-8'>
                                <br>
                                <select class="select2 form-control contact_id" name="contact_id[]" >
                                    <option value="0">None</option>
                                    @foreach ($contacts as $contact)
                                    <option value="{{$contact->id}}" @if ($people->id == $contact->id ) selected="selected" @endif >{{$contact->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endforeach
                        @if(count($favourite_people) == 0)
                            <div class="about-me-row div_favourite_people">
                                <div class="col-xs-4">
                                    <label class="label-image" for="home"><img  src="/img/icon-with.svg" alt="home" class="img-responsive icon-size"></label>
                                </div>
                                <div class='col-xs-8'>
                                    <br>
                                    <select class="select2 form-control contact_id" name="contact_id[]" >
                                        <option value="0">None</option>
                                        @foreach ($contacts as $contact)
                                        <option value="{{$contact->id}}">{{$contact->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class='about-me-row'>
                        <div class='col-xs-4'>
                        </div>
                        <div class='col-xs-8'>
                            <a data-toggle="collapse" data-target="#addcontact">+Add person</a><br>
                            <div id="addcontact" class="addcontact collapse">
                                <span class="help-block" style="display: none;color: #a94442;">
                                    Please fill in the required field.
                                </span>
                                @include('partials.addcontact')
                            </div>
                            <br>
                            <a id="add_favourite_people" href="javascript:;">+Add more favourite people</a>
                        </div>
                    </div>
                </div>
                <div class="row no-border">
                    <a class="btn btn-danger accordion_favourite_things" data-toggle="collapse" href="#collapse-favourite-things">
                        <i class="fa fa-check" aria-hidden="true"></i> My favourite things
                    </a>
                </div>
                <div class="row panel-collapse collapse no-border" id="collapse-favourite-things">
                    <div id='favourite_things_container'>
                        @foreach($favourite_things as $favourite)
                        <div class="about-me-row div_favourite_things" id="">
                            <div class="col-xs-4">
                                <label class="label-image" for="home"><img @if($favourite->photo)src="{{$favourite->photo}}" @else src="/img/icon-check.svg" @endif alt="home" class="img-responsive icon-size"></label>
                            </div>
                            <div class='col-xs-8'>
                                <input type='text' maxlength="50" class='form-control' name="favourite_things[]" value="{{$favourite->name}}"><br>
                                <input type="hidden" name="favourite_photos[]" value="{{$favourite->photo}}" class='photo_link'>
                                <label type="button" class="btn btn-default btn-upload" style='width:auto'>
                                    <span>Select new photo</span>
                                    <input ref="main_photo" type="file" class="form-control" name="add_photo" onchange='savePhoto(this)' >
                                    <div id="select-file"></div>
                                </label>
                            </div>
                            </div>
                        @endforeach
                        @if(count($favourite_things) == 0)
                        <div class="about-me-row div_favourite_things" id="">
                            <div class="col-xs-4">
                                <label class="label-image" for="home"><img  src="/img/icon-check.svg" alt="home" class="img-responsive icon-size"></label>
                            </div>
                            <div class='col-xs-8'>
                                <input type='text' maxlength="50" class='form-control' name="favourite_things[]" value=""><br>
                                <input type="hidden" name="favourite_photos[]" value="" class='photo_link'>
                                <label type="button" class="btn btn-default btn-upload" style='width:auto'>
                                    <span>Select new photo</span>
                                    <input ref="main_photo" type="file" class="form-control" name="add_photo" onchange='savePhoto(this)' >
                                    <div id="select-file"></div>
                                </label>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class='about-me-row'>
                        <div class='col-xs-4'>
                        </div>
                        <div class='col-xs-8'>
                            <a id="add_favourite_things" href="javascript:;">+Add more favourite things</a>
                        </div>
                    </div>
                </div>
                <div class="row no-border">
                    <a class="btn btn-success accordion_my_health" data-toggle="collapse" href="#collapse-my-health">
                        <img src="/img/icon-health.svg" class='accordion_img'> My health
                    </a>
                </div>
                <div class="row panel-collapse collapse no-border" id="collapse-my-health">
                    <div id='medications_container'>
                    @foreach($medications as $medication)
                        <div class="about-me-row div_medications">
                            <div class="col-xs-4">
                                <label class="label-image" for="home"><img @if($medication->photo)src="{{$medication->photo}}" @else src="/img/icon-medication.png" @endif alt="home" class="img-responsive icon-size"></label>
                            </div>
                            <div class='col-xs-8'>
                                <p class='edit_p'>My medication is</p>
                                <input type='text' maxlength="50" class='form-control' name="medications[]" value="{{$medication->name}}"><br>
                                <input type="hidden" name="medication_photos[]" value="{{$medication->photo}}" class='photo_link'>
                                <label type="button" class="btn btn-default btn-upload" style='width:auto'>
                                    <span>Select new photo</span>
                                    <input ref="" type="file" class="form-control" name="add_photo" onchange='savePhoto(this)' >
                                    <div id="select-file"></div>
                                </label>
                            </div>
                        </div>
                        @endforeach
                        @if(count($medications) == 0)
                        <div class="about-me-row div_medications">
                            <div class="col-xs-4">
                                <label class="label-image" for="home"><img src="/img/icon-medication.png" alt="home" class="img-responsive icon-size"></label>
                            </div>
                            <div class='col-xs-8'>
                                <p class='edit_p'>My medication is</p>
                                <input type='text' maxlength="50" class='form-control' name="medications[]" value=""><br>
                                <input type="hidden" name="medication_photos[]" value="" class='photo_link'>
                                <label type="button" class="btn btn-default btn-upload" style='width:auto'>
                                    <span>Select new photo</span>
                                    <input ref="" type="file" class="form-control" name="add_photo" onchange='savePhoto(this)' >
                                    <div id="select-file"></div>
                                </label>
                            </div>
                        </div>
                        @endif
                        </div>
                    <div class='about-me-row'>
                        <div class='col-xs-4'>
                        </div>
                        <div class='col-xs-8'>
                            <a id="add_reminder" data-toggle="collapse" data-target="#addreminderform">+Add a reminder</a>
                            <br>
                            <div class="alert alert-success margin-top-10 no-margin-bottom padding-10" id="reminder_added_msg">Reminder Added</div>
                            <div id="addreminderform" class="addorganisation collapse">
                                <span class="help-block" style="display: none;color: #a94442;">
                                    Please fill in the required field.
                                </span>
                                @include('partials.addreminder')
                            </div>
                            <br>
                            <a id="add_medications" href="javascript:;">+Add more medications</a>
                        </div>
                    </div>
                    <br>
                    <div class="about-me-row">
                        <div class="col-xs-4">
                            <label class="label-image" for="home"><img src="/img/icon-doctor.png" alt="home" class="img-responsive icon-size"></label>
                        </div>
                        <div class='col-xs-8'>
                            <p class="edit_p">My doctor is</p>
                            <p class="pvalue" >
                                <select id="doctor_id" class="select2 form-control" name="doctor_id" >
                                    <option value="0">None</option>
                                    @foreach ($contacts as $contact)
                                    <option value="{{$contact->id}}" @if($about) @if ($about->doctor_id == $contact->id ) selected="selected" @endif @endif >{{$contact->name}}</option>
                                    @endforeach
                                </select>
                                <span class="help-block">
                                    {{$errors->first('doctor_id')}}
                                    </span>
                                <a data-toggle="collapse" data-target="#adddoctor">+Add person</a>
                                <div id="adddoctor" class="addcontact collapse">
                                    <span class="help-block" style="display: none;color: #a94442;">
                                        Please fill in the required field.
                                    </span>
                                    <div>
                                        @include('partials.addcontact')
                                    </div>
                                </div>
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
                        <div class="col-xs-4">
                            <img src="/img/icon-with.svg" alt="Calendar" class="img-responsive icon-size">
                        </div>
                        <div class='col-xs-8'>
                            <p class="pvalue" >
                                First & last name<br>
                                <input type="text" class="form-control" name="emergency_name" value="{{ $user->emergency_name }}">
                            </p>
                        </div>
                    </div>
                    <div class="about-me-row div_favourite_people">
                        <div class="col-xs-4">
                            <img src="/img/icon-call.svg" alt="Calendar" class="img-responsive icon-size">
                        </div>
                        <div class='col-xs-8'>
                            <p class="pvalue" >
                                Mobile number<br>
                                <input type="tel" class="form-control" name="emergency_phone" value="{{ $user->emergency_phone }}">
                            </p>
                        </div>
                    </div> -->
                    <div class="about-me-row">
                        <div class="col-xs-4">
                            <label class="label-image" for="home">
                                <img @if($about && $about->emergency && $about->emergency->photo)src="{{$about->emergency->photo}}" @else src="/img/icon-with.svg" @endif alt="home" class="img-responsive icon-size">
                            </label>
                        </div>
                        <div class='col-xs-8'>
                            <br>
                            <select class="select2 form-control " name="emergency_id" id="emergency_id" >
                                <option value="0">None</option>
                                @foreach ($contacts as $contact)
                                <option value="{{$contact->id}}" @if ($about && $about->emergency_id == $contact->id ) selected="selected" @endif >{{$contact->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class='about-me-row'>
                        <div class='col-xs-4'>
                        </div>
                        <div class='col-xs-8'>
                            <a data-toggle="collapse" data-target="#addemergency">+Add emergency contact</a><br>
                            <div id="addemergency" class="addcontact collapse">
                                <span class="help-block" style="display: none;color: #a94442;">
                                    Please fill in the required field.
                                </span>
                                @include('partials.addcontact')
                                </div>
                        </div>
                    </div>
                </div>

                <div class="row no-border">
                    <button type="submit" class="btn btn-primary btn-block save-btn">
                        Save About Me
                    </button>
                </div>
            </form>
                <div class='about_templates'>
                    <div id='favourite_things_template'>
                        <div class="about-me-row div_favourite_things">
                            <div class="col-xs-4">
                                <label class="label-image" for="home"><img src="/img/icon-check.svg" alt="home" class="img-responsive icon-size"></label>
                            </div>
                            <div class='col-xs-8'>
                                <input type='text' maxlength="50" class='form-control' name="favourite_things[]"><br>
                                <input type="hidden" name="favourite_photos[]" value="" class='photo_link'>
                                <label type="button" class="btn btn-default btn-upload" style='width:auto'>
                                    <span>Select new photo</span>
                                    <input ref="" type="file" class="form-control" name="add_photo" onchange='savePhoto(this)' >
                                    <div id="select-file"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div id='favourite_people_template'>
                        <div class="about-me-row div_favourite_people">
                            <div class="col-xs-4">
                                <label class="label-image" for="home"><img src="/img/icon-with.svg" alt="home" class="img-responsive icon-size"></label>
                            </div>
                            <div class='col-xs-8'>
                            <br>
                                <select class="form-control new_contact_id" name="contact_id[]" >
                                    <option value="0">None</option>
                                    @foreach ($contacts as $contact)
                                    <option value="{{$contact->id}}">{{$contact->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id='medications_template'>
                        <div class="about-me-row div_medications">
                            <div class="col-xs-4">
                                <label class="label-image" for="home"><img src="/img/icon-medication.png" alt="home" class="img-responsive icon-size"></label>
                            </div>
                            <div class='col-xs-8'>
                                <p class='edit_p'>My medication is</p>
                                <input type='text' maxlength="50" class='form-control' name="medications[]"><br>
                                <input type="hidden" name="medication_photos[]" value="" class='photo_link'>
                                <label type="button" class="btn btn-default btn-upload" style='width:auto'>
                                    <span>Select new photo</span>
                                    <input ref="" type="file" class="form-control" name="add_photo" onchange='savePhoto(this)' >
                                    <div id="select-file"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</about-me>
@endsection
@section('bottom-scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.timepicker.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/js/datepair.min.js"></script>
<script type="text/javascript" src="/js/jquery.datepair.min.js"></script>
<script src="https://cdn.jsdelivr.net/select2/4.0.3/js/select2.min.js"></script>
<script src="/js/jquery-autocapitalize.min.js"></script>
<script type="text/javascript">
    $('input[name="name"]').autocapitalize({mode:"words"});
    $("#addworkorganisation #organisation_address").attr("id", "organisation_address2");
    $("#adddoctor #contact_address").attr("id", "contact_address1");
    $("#addemergency #contact_address").attr("id", "contact_address2");
    $("#reminder_added_msg").hide();
    $('.addorganisation .save-organisation').on('click', function (evt) {
        evt.preventDefault();
        select =  $(this).parent().parent().find('select');
        where =  $(this).parent().parent().parent().parent().find('.form-address-input');
        name = $(this).parent().find("input[name='name']").val();
        phone = $(this).parent().find("input[name='phone']").val();
        email = $(this).parent().find("input[name='email']").val();
        website = $(this).parent().find("input[name='website']").val();
        address = $(this).parent().find("input[name='address']").val();
        photolink = $(this).parent().find("input[name='photolink']").val();
        axios.post('/api/new/organisation', {
        name: name,
        phone: phone,
        email: email,
        address: address,
        website: website,
        photolink: photolink
        })
        .then(function (response) {
            $(".addorganisation .help-block").hide();
        $(".addorganisation").removeClass('in');
        $(".addorganisation input[name='name']").val("");
        $(".addorganisation input[name='phone']").val("");
        $(".addorganisation input[name='email']").val("");
        $(".addorganisation input[name='organisation']").val("");
        $(".addorganisation input[type='address']").val("");
        $('.select_organisations').append($('<option>', {
            value: response.data["id"],
            text : response.data["name"]
        })).select2();
        $(select).val(response.data["id"]).trigger('change.select2');
        $(where).val(address);
        })
        .catch(function (error) {
            $(".addorganisation .help-block").show();
        });
    });

    $('.addcontact .save-contact').on('click', function (evt) {
        evt.preventDefault();
        select =  $(this).parent().parent().parent().parent().find('select').last();
        name = $(this).parent().find("input[name='name']").val();
        phone = $(this).parent().find("input[name='phone']").val();
        email = $(this).parent().find("input[name='email']").val();
        organisation = $(this).parent().find("input[name='organisation']").val();
        address = $(this).parent().find("input[name='address']").val();
        photolink = $(this).parent().find("input[name='photolink']").val();
        axios.post('/api/new/contact', {
            name: name,
            phone: phone,
            email: email,
            address: address,
            organisation: organisation,
            photolink: photolink
        })
        .then(function (response) {
            $(".addcontact .help-block").hide();
            $(".addcontact").removeClass('in');
            $(".addcontact input[name='name']").val("");
            $(".addcontact input[name='phone']").val("");
            $(".addcontact input[name='email']").val("");
            $(".addcontact input[name='organisation']").val("");
            $(".addcontact input[type='address']").val("");
            $('.contact_id').append($('<option>', {
                value: response.data["id"],
                text : response.data["name"]
            })).select2();
            $('.new_contact_id').append($('<option>', {
                value: response.data["id"],
                text : response.data["name"]
            }))
            $('#doctor_id').append($('<option>', {
                value: response.data["id"],
                text : response.data["name"]
            })).select2();
            $('#emergency_id').append($('<option>', {
                value: response.data["id"],
                text : response.data["name"]
            })).select2();
            $(select).val(response.data["id"]).trigger('change.select2');
        })
        .catch(function (error) {
            $(".addcontact .help-block").show();
        });
    });

    function getFilename(e) {
        photo = $(e).get(0).files[0];
        img = $("#user_photo");
        photo_link = $("#profile_photo");
        var formData = new FormData();
        formData.append("photo", photo);
        axios.post('/about-me/photo', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(function (response) {
            img.attr("src", response.data );
            photo_link.val(response.data);
        })
        .catch(function (error) {
            // $('#' + id + ' .photo-error').hide();
        });
    };
    function savePhoto(e){
        photo = $(e).get(0).files[0];
        img = $(e).parent().parent().parent().find(".img-responsive");
        photo_link = $(e).parent().parent().find(".photo_link");
        var formData = new FormData();
        formData.append("photo", photo);
        axios.post('/api/contact/photo', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(function (response) {
            img.attr("src", response.data );
            photo_link.val(response.data);
        })
        .catch(function (error) {
           // $('#' + id + ' .photo-error').hide();
        });
    }
    $('input[name="photo"]').on('change',function(){
        photo = $(this).get(0).files[0];
        id = $(this).parent().parent().parent().attr('id');
        var formData = new FormData();
        var imagefile = document.querySelector('#' + id + ' #file');
        formData.append("photo", imagefile.files[0]);
        axios.post('/api/contact/photo', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(function (response) {
            $('#' + id + ' .photo-error').hide();
            $('#' + id + ' .contact-photo-preview').css("background-image", "url(" + response.data + ")");
            $('#' + id + ' .photolink').val(response.data);
        })
        .catch(function (error) {
            $('#' + id + ' .photo-error').hide();
        });
    });
    var placeSearch, autocomplete;
    function initAutocomplete() {
        contact_autocomplete = new google.maps.places.Autocomplete((document.getElementById('contact_address')));
        contact_autocomplete.addListener('place_changed', function(){
            document.getElementById('contact_address').value = contact_autocomplete.getPlace().formatted_address;
        });

        contact1_autocomplete = new google.maps.places.Autocomplete((document.getElementById('contact_address1')));
        contact1_autocomplete.addListener('place_changed', function(){
            document.getElementById('contact_address1').value = contact1_autocomplete.getPlace().formatted_address;
        });

        contact2_autocomplete = new google.maps.places.Autocomplete((document.getElementById('contact_address2')));
        contact2_autocomplete.addListener('place_changed', function(){
            document.getElementById('contact_address2').value = contact2_autocomplete.getPlace().formatted_address;
        });

        organisation1_autocomplete = new google.maps.places.Autocomplete((document.getElementById('organisation_address')));
        organisation1_autocomplete.addListener('place_changed', function(){
            var places = organisation1_autocomplete.getPlace();
            document.getElementById('organisation_address').value = organisation1_autocomplete.getPlace().formatted_address;
        });

        organisation2_autocomplete = new google.maps.places.Autocomplete((document.getElementById('organisation_address2')));
        organisation2_autocomplete.addListener('place_changed', function(){
            document.getElementById('organisation_address2').value = organisation2_autocomplete.getPlace().formatted_address;
        });
    }
    function geolocate() {
        if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
        var geolocation = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        };
        var circle = new google.maps.Circle({
            center: geolocation,
            radius: position.coords.accuracy
        });
        autocomplete.setBounds(circle.getBounds());
        });
      }
  }
  $('#addreminderform .save-reminder').on('click', function (evt) {
        evt.preventDefault();

        title = $("#addreminderform #reminder_title").val();
        start_date = $("#addreminderform #reminder_date").val();
        start_time = $("#addreminderform #reminder_time").val();
        send_sms = $("#addreminderform #send_sms").prop("checked");
        repeat_reminder = $("#addreminderform #repeat_reminder").val();
        repeat_until = $("#addreminderform #repeat_until").val();
        details = $("#addreminderform #details").val();
        photolink = $("#addreminderform .photolink").val();
        video = $("#addreminderform .reminder_video_upload").val();
        thumb = $("#addreminderform .reminder_thumb_upload").val();
        axios.post('/api/new/reminder', {
            title: title,
            start_date: start_date,
            start_time: start_time,
            send_sms: send_sms,
            repeat_reminder: repeat_reminder,
            repeat_until: repeat_until,
            details: details,
            photolink: photolink,
            video: video,
            thumb: thumb,
        })
        .then(function (response) {
            $("#addreminderform").removeClass('in');
            $("#addreminderform .help-block").hide();
            $("#addreminderform #reminder_title").val("");
            $("#addreminderform #reminder_date").val("");
            $("#addreminderform #reminder_time").val("");
            $("#addreminderform #send_sms").val("");
            $("#addreminderform #repeat_reminder").val("");
            $("#addreminderform #repeat_until").val("");
            $("#addreminderform #details").val("");
            $("#addreminderform .photolink").val("");
            $("#reminder_added_msg").show();
        })
        .catch(function (error) {
            $("#addreminderform .help-block").show();
        });
  });
  $(".select2").select2();

  $("#add_favourite_things").on("click",function(){
      var favourite_html = document.getElementById("favourite_things_template").innerHTML;
      $("#favourite_things_container").append(favourite_html);
  });
  $("#add_favourite_people").on("click",function(){
      var favourite_html = document.getElementById("favourite_people_template").innerHTML;
      $("#favourite_people_container").append(favourite_html);
    //   $(".select2").select2();
      $("#favourite_people_container").children().last().find("select").removeClass("new_contact_id");
      $("#favourite_people_container").children().last().find("select").addClass("contact_id");
      $("#favourite_people_container").children().last().find("select").select2();
  });
  $("#add_medications").on("click",function(){
      var medication_html = $("#medications_template").html();
      $("#medications_container").append(medication_html);
  });
  $('#addreminderform #reminder_date').datepicker({
    'format': 'd-m-yyyy',
    'weekStart' : 1,
    'autoclose': true
    });
   $('#addreminderform #repeat_until').datepicker({
    'format': 'd-m-yyyy',
    'weekStart' : 1,
    'autoclose': true
    });
    $('#addreminderform #reminder_time').timepicker({
        'showDuration': true,
      'scrollDefault': '06:30',
      'timeFormat': 'g:ia'
    });
    $("#add_reminder").on("click",function(){
        $("#reminder_added_msg").hide();
    })
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5sK9v5PVMvhXUUFXnXvYwSOoB_CfndYM&libraries=places&callback=initAutocomplete"
  async defer></script>
@endsection
