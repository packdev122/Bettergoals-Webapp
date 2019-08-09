@extends('layouts/app')
@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/select2/4.0.3/css/select2.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
@endsection
@section('content')
<div class="row">
    <div class="m-diary-add col-md-4 col-md-offset-4">
        <span class="m-back"><a href="/{{ Auth::user()->currentTeamName() }}/diary/edit/{{$id}}"><i class="fa fa-chevron-left"></i></a></span>
        <form role="form" enctype="" method="post" action="/{{Auth::user()->currentTeamName()}}/diary/save/{{ $id }}">
        {{ csrf_field() }}

        <!-- Application Details -->

        <h3 class="text-center"><span class="m-back"><a href="/{{ Auth::user()->currentTeamName() }}/diary/edit/{{$id}}"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>Write Note</h3>
        <br>
        <div class="no-border">
            <textarea class='form-control' name="diary_note" placeholder="Write a note here" style='height:150px'>{{$note}}</textarea>
            <span class="help-block">
                {{$errors->first('diary_note')}}
            </span>
        </div>
        <br>
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 text-center"> 
                <button type="submit" class="btn btn-primary btn-block save-diary">
                     Save Note
                </button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection

@section('bottom-scripts')

<script type="text/javascript">
    
</script>
@endsection
