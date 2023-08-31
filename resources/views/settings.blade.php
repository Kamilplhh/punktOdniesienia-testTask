@extends('layouts.master')
@vite('resources/css/settings.css')
@vite('resources/css/login.css')


@section('navi')
<a class="selected">Account settings</a>
@stop

@section('calendar')
@show

@section('cost')
@show

@section('content')

<form enctype="multipart/form-data" method="POST" action="{{ route('profileUpdate') }}">
    @csrf
    <label for="logo">Logo:</label>
    <input type="file" id="logo" name="logo"><br>

    <label for="company">Company name:</label>
    <input type="text" id="company" name="company" value="{{ Auth::user()->company }}" placeholder="{{ Auth::user()->company }}" class="form-control @error('company') is-invalid @enderror"><br>

    @error('cName')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

    <label for="name">Firstname and lastname:</label>
    <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" placeholder="{{ Auth::user()->name }}" class="form-control @error('name') is-invalid @enderror"><br>

    @error('name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" placeholder="{{ Auth::user()->email }}" class="form-control @error('email') is-invalid @enderror"><br>

    @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

    <label>E-mail to receive invoices:</label>
    <label class="form" style="font-weight: bold;" id="labelEmail">{{ Auth::user()->company . '@domain.com'}}</label><br>

    <label for="emailto">E-mail to send documents:</label>
    <input type="email" id="emailto" name="emailto" value="{{ Auth::user()->emailto }}" placeholder="{{ Auth::user()->emailto }}" class="form-control"><br>

    <label for="password">Password:</label>
    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required><br>
    @error('password')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

    <div class="operations">
        <a href="/" class="btn">Cancel</a>
        <button type="submit" class="btn">Save</button>
    </div>
</form>

@stop