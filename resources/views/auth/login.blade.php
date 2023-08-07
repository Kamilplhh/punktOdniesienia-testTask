@extends('layouts.master')
@vite('resources/css/settings.css')
@vite('resources/css/login.css')

@section('navbar')
@stop

@section('navi')
<a class="selected" id="login">Login</a>
<a href="{{ route('register') }}" id="register">Register</a>
@stop

@section('calendar')
@show

@section('cost')
@show

@section('content')

<div>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" required><br>

        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <label for="email">Password</label>

        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required><br>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <div class="operations">
            <button type="submit" class="btn">Login</button>
        </div>
    </form>
</div>
@stop