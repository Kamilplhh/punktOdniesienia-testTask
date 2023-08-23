@extends('layouts.master')
@vite('resources/js/admin.js')

@section('navi')
@if((Auth::user()->id) == 1)
<a class="adminNavi selected" id="adminPanel">Admin panel</a>
<a class="adminNavi" id="scanner">Scanner data</a>
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
<div class="dataBlock sPanel off">
    <form method="POST" action="{{ route('addScanner') }}">
        @csrf
        <label for="pText">Price text:</label>
        <input type="text" id="pText" name="pText">

        <label for="tText">Time text:</label>
        <input type="text" id="tText" name="tText">

        <label for="bText">Bank text:</label>
        <input type="text" id="bText" name="bText">

        <div class="operations">
            <button type="submit" class="btn">Add</button>
        </div>
    </form>
</div>
</div>
@endif
@stop