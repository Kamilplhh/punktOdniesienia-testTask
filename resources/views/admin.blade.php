@extends('layouts.master')

@section('navi')
<a class="selected">Admin panel</a>
@stop

@section('calendar')
@show

@section('cost')
@show

@section('content')

@if((Auth::user()->id) == 1)
@foreach($users as $user)
<div class="dataBlock aPanel">
    <div>
        <div>
            {{ $user->company }}
        </div>
    </div>
    <div>
        {{ $user->email }}
    </div>
    <div class="last">
        <a href="/deleteuser/{{ $user->id }}" class="btn remove">Remove</a>
    </div>
</div>
@endforeach
</div>
@endif



@stop