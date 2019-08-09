@extends('layouts/app')
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
@endsection
@section('content')

<div class="add-appointment-click" style="    max-width: 360px;
    margin: auto;">
        <span><a class="btn btn-default plus-button" href="/{{ Auth::user()->currentTeamName() }}/activities/add">
        </a><a href="/{{ Auth::user()->currentTeamName() }}/activities/add"><p style="padding: 10px; color: rgb(31, 132,114);font-size: 18px; margin-top: 15px; margin-bottom: 20px;}">Add Activity</p></a></span>
</div>

<span class="m-back"><a href="/{{ Auth::user()->currentTeamName() }}/dashboard"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>
<div class="row">
    <div class="m-dash col-md-4 col-md-offset-4">
        <!-- Application Dashboard -->
        @forelse ($appointments as $myDate => $events)
            <div class="row m-row">
                <div class="col-xs-4">
                    <img class="icon-size" src="/img/icon-calendar.svg" alt="Calendar">
                </div>
                <div class="col-xs-8">
                    <div class="m-head">
                        @foreach(explode(',', $myDate) as $head) 
                            <h3>{{$head}}</h3>
                        @endforeach
                    </div>        
                </div>
            </div>
            @foreach ($events as $event)
            <div class="row">
                <div class="col-xs-4">
                 <a href="/{{Auth::user()->currentTeamName()}}/activities/view/{{ $event->id }}">
                    <img src="{{ $event->photo }}" alt="Appointment Photo" class="img-responsive">
                </a>
                </div>
                <div class="col-xs-8">
                    @if($event->is_reminder)
                        <a href="/{{Auth::user()->currentTeamName()}}/reminder/{{ $event->id }}">
                            <p><strong>{{ $event->start_date->format('g:ia') }}</strong></p>
                            <p>{{ $event->title }}</p>
                        </a>
                    @else
                        <a href="/{{Auth::user()->currentTeamName()}}/activities/view/{{ $event->id }}">
                            <p><strong>{{ $event->start_date->format('g:ia') }}</strong></p>
                            <p>{{ $event->title }}</p>
                        </a>
                    @endif
                </div>
            </div>
            @endforeach
            @empty 
        @endforelse
                <p class="text-center" id="no-activities-msg" style="display: none;"></p>
    </div>
</div>
@endsection

@section('bottom-scripts')

<script type="text/javascript">

    $( document ).ready(function() {

        //Number of activities loaded, will be increased in blocks of 10, used to skip elments in our sql statement

        var loaded_activities = 10;

        // Boolean to check later if everything is already loaded, not to make unnecesary requests:

        var all_loaded = 0;

        /* 

        When users scrolls down, check if they reached the bottom of the screen@

        */

        $(window).scroll(function() {
            if($(window).scrollTop() == $(document).height() - $(window).height()) {

                // We'll only make a request to the server if there's still something to get:

                if(all_loaded == 0){
                
                // Post request, passing number of already loaded activities:

                axios.post('/api/activities/load-more', {
                      loaded_activities: loaded_activities
                    })
                    .then(function (response) {
                
                        // Append the response, it's a partial blade (load-more-activities):
                        $('.m-dash').append(response.data);

                        // If response is empty, it means we already loaded everything, change boolean not 
                        // to make more requests:

                        if(response.data == ""){
                            all_loaded = 1;
                        }
                        // Increase number of loaded elements

                        loaded_activities += 10;
                    });

                }

            }
        }); 

    })


</script>

@endsection
