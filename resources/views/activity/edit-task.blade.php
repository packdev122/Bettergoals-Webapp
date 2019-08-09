@extends('layouts/app')
@section('content')
<mobile-task :task="{{json_encode($task)}}" inline-template>
<div class="edit-task">
<form  role="form" method="post" action="/task/update/{{ $task->id }}">
    {{ csrf_field() }}
    <input type="hidden" name="start_date" value="{{ $task->start_date->format('d-m-Y') }}">
    <input type="hidden" name="end_date" value="{{ $task->end_date->format('d-m-Y') }}">
    <div class="row">
        <div class="m-appoint col-md-4 col-md-offset-4">
            <!-- Application Details -->
            <h3 class="text-center"><span class="m-back"><a href="/{{Auth::user()->currentTeamName()}}/task/{{$task->id}}"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>{{ $task->title }}</h3>
            <div class="main-group form-group {{ $errors->has('title') ? 'has-error' :'' }}" >
                <label class="control-label">Title</label>
                <input id="title" type="text" class="form-control" name="title" value="{{ old('title', $task->title) }}">
                <span class="help-block">
                    {{$errors->first('title')}}
                </span>
            </div>
            <div id="date-time-ready">
                <div id="date-time" class="main-group form-group {{ $errors->has('start_time') ? 'has-error' :'' }}" >
                    <div class="row">
                        <div class="col-xs-3">
                            <label class="label-image" for="start_time"><img src="/img/icon-time.svg" alt="Apponintment Image" class="img-responsive"></label>
                        </div>
                        <div class="col-xs-9">
                            <label class="control-label">Time it starts</label>
                            <input id="" type="text" class="time start form-control" name="start_time" @if ($task->start_date)
                            value="{{ old('start_time', $task->start_date->format('g:ia')) }}"
                            @else 
                            value="{{ old('start_time') }}"
                            @endif>
                            <span class="help-block">
                                {{$errors->first('start_time')}}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- End Time -->
                <div id="date-time" class="main-group form-group {{ $errors->has('_end_time') ? 'has-error' :'' }}" >
                    <div class="row">
                        <div class="col-xs-3">
                            <label class="label-image" for="_end_time"><img src="/img/icon-time.svg" alt="Apponintment Image" class="img-responsive"></label>
                        </div>
                        <div class="col-xs-9">
                            <label class="control-label">Time it finishes</label>
                            <input id="" type="text" class="time end form-control" name="end_time" @if ($task->end_date)
                            value="{{ old('end_time', $task->end_date->format('g:ia')) }}"
                            @else 
                            value="{{ old('end_time') }}"
                            @endif>
                            <span class="help-block">
                                {{$errors->first('end_time')}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</form>
</div>
</mobile-task>
@endsection