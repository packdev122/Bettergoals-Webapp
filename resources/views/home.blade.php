@extends('layouts/app')
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>   
@endsection
@section('content')
<div id="spark-app-main" v-cloak>
    <span class="m-back"><a id="btn_sidebar"><img src = "/img/icon-list.svg" id="icon-list"><img src = "/img/icon-cross.svg" id="icon-cross"></a></span>
    <div class="m-user-main">
        @if($owner->hasPhoto())
            <a href="/{{ Auth::user()->currentTeamName() }}/about"><img src="{{ $owner->photo_url }}" class="img-circle" style='width:124px;'></a>
        @else
            <a href="/{{ Auth::user()->currentTeamName() }}/about"><i class="fa fa-3x fa-user" aria-hidden="true"></i></a>
        @endif
    </div>
</div>
<h2 style="text-align: center;margin-bottom: 30px;">
    {{$owner->name}}
</h2>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="col-md-6 col-sm-6 col-xs-6 mobile-home-nav-item" style="padding-right:7px;">
            <div class="background-about-me">
                <a class="lg-icon-btn-1 calendar btn btn-lg" href="/{{ Auth::user()->currentTeamName() }}/about"><p style="padding-top: 70px; ">About Me</p></a>
        </div> 
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6 mobile-home-nav-item" style="padding-left:7px;">
            <div class="background-1">
                <a class="lg-icon-btn-1 calendar btn btn-lg" href="/{{ Auth::user()->currentTeamName() }}/activities"><p style="padding-top: 70px; ">Activities</p></a>
        </div> 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="col-md-6 col-sm-6 col-xs-6 mobile-home-nav-item" style="padding-right: 7px;">
            <div class="background-diary">
                <a class="lg-icon-btn-2 people btn btn-lg" href="/{{ Auth::user()->currentTeamName() }}/diary"><p style="padding-top: 70px; ">Diary</p></a>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6 mobile-home-nav-item" style="padding-right: 7px;">
            <div class="background-gallery">
                <a class="lg-icon-btn-2 people btn btn-lg" href="/{{ Auth::user()->currentTeamName() }}/gallery"><p style="padding-top: 70px; ">Gallery</p></a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="col-md-6 col-sm-6 col-xs-6 mobile-home-nav-item" style="padding-right: 7px;">
            <div class="background-2">
                <a class="lg-icon-btn-2 people btn btn-lg" href="/{{ Auth::user()->currentTeamName() }}/people"><p style="padding-top: 70px; ">People</p></a>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6 mobile-home-nav-item" style="padding-left: 7px;">
            <div class="background-3">
                <a class="lg-icon-btn-3 places btn btn-lg" href="/{{ Auth::user()->currentTeamName() }}/places"><p style="padding-top: 70px; ">Places</p></a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="col-md-6 col-sm-6 col-xs-6 mobile-home-nav-item" style="padding-right: 7px;">
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6 mobile-home-nav-item" style="padding-right: 7px;">
        </div>
    </div>
</div>
<div class="row">
    <div class='col-md-4 col-md-offset-4' style="padding-left:20px;padding-right:20px;">
        <a class="dashboard-help-btn btn" href="tel:{{$owner->emergencyContact()->phone}}" style='text-align:center;'><img src = "/img/icon-call-white.svg" style='height:40px;'>&nbsp;&nbsp;Call {{ $owner->emergencyContact()->name }}</a>
    </div>
</div>
@endsection

@section('bottom-scripts')

<script type="text/javascript">
    var max_height = $(".container").height();
    var body_width = $("body").width();
    $(".sidebar-menu").css("width",(body_width)+"px");
    $(".sidebar-menu").css("height",max_height+"px");
    var side_width = $(".sidebar-menu").width();
    $(".sidebar-inner").css("width",(side_width-60)+"px");
    $(".sidebar-inner").css("height",max_height+"px");
    var is_shown = false;
    var switchSideBar = function(){  
        max_height = $(".container").height();
        $(".sidebar-menu").css("height",max_height+"px");
        $(".sidebar-inner").css("height",max_height+"px");
        if(!is_shown){
            $(".sidebar-menu").animate({
                width: 0
            });
            is_shown = true;
            $("#icon-cross").hide();
            $("#icon-list").show();
        }else{
            $(".sidebar-menu").show();
            $(".sidebar-menu").animate({
                width: side_width
            });
            is_shown = false;
            $("#icon-cross").show();
            $("#icon-list").hide();
            $(".sidebar-inner").focus();
        }
    }
    
    switchSideBar();
	$(window).on("orientationchange",function(){
	  if(window.orientation == 0) // Portrait
	  {
	    $(".fixed-bottom").css({"position":"fixed"});
	  }
	  else // Landscape
	  {
	    $(".fixed-bottom").css({"position":"initial"});
	  }
	});
    $("#btn_teams").on("click",function(){
        switchSideBar();
    })
    $("#btn_sidebar").on("click",function(){
        switchSideBar();
    })
    $(".sidebar-menu").on("click",function(e){
        switchSideBar();
    })
    $(".sidebar-inner").on("click",function(e){
        e.stopPropagation();
    })
    // $(".mobile-nav").on("click",function(){
    //     switchSideBar();
    // })
</script>
@endsection