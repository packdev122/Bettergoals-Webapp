<div class='team-settings' style='background:white'>
    <div class='m-user-main'>
        @if($has_photo)
            <a href="/switchTeam/{{ $my_team_id }}" id="goto_myteam"><img src="{{ $user->photo_url }}" class="img-circle" style='width:124px;'></a>
        @else
            <a href="/switchTeam/{{ $my_team_id }}" id="goto_myteam"><i class="fa fa-3x fa-user" aria-hidden="true"></i></a>
        @endif
    </div>
    <h2 style="text-align: center;margin-bottom: 30px;">
        {{$user->name}}
    </h2>
    <div class='button-group row'>
        <div class='col-xs-6 button'>
            <a href="/{{ Auth::user()->currentTeamName() }}/settings"><i class="fa fa-3x fa-cogs" aria-hidden="true"></i></a><br>
            <p class='button-labels'>Settings</p>
        </div>
        <div class='col-xs-6 button'>
            <a href="/{{ Auth::user()->currentTeamName() }}/notifications"><i class="fa fa-3x fa-bell" aria-hidden="true"></i></a>
            <p class='button-labels'>Notification</p>
        </div>
    </div>
    <hr>
    <h3 class='myteams_label'>
        <img src="/img/icon-users-1.svg"> My teams
    </h3>
    <div class='team-group row'>
        @foreach($my_teams as $team)
            <?php
                $owner = \App\User::find($team->owner_id);
            ?>
            <div class='col-xs-6 button'>
                <a href="/switchTeam/{{ $team->id }}">
                    @if($owner->hasPhoto())
                        <img src="{{$owner->photo_url}}" width="90px" class='img-circle'>
                    @else
                        <i class="fa fa-3x fa-user" aria-hidden="true"></i>
                    @endif
                </a>
                <br>
                <p class='button-labels'>{{ $team->name }}</p>
            </div>
        @endforeach
    </div>
    <hr>
    <div class="logout text-center">
        <a href="/logout"><img src="/img/icon-logout.svg" class="img-circle" width="50px"></a>
        <p>Logout</p>
    </div>
</div>