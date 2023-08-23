@extends('layouts.master')
@vite('resources/js/admin.js')

@section('navi')
@if((Auth::user()->id) == 1)
<a class="homeNavi selected" id="adminPanel">Admin panel</a>
<a class="homeNavi" id="scanner">Scanner data</a>
@endif
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