
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
