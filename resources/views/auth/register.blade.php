@extends('layouts.master')
@vite('resources/css/settings.css')
@vite('resources/css/login.css')

@section('navbar')
@stop

@section('navi')
<a href="{{ route('login') }}">Login</a>
<a class="selected">Register</a>
@stop

@section('calendar')
@show

@section('cost')
@show

@section('content')


<div>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label for="logo">Logo:</label>
        <input type="file" id="logo" name="logo" value="null"><br>

        <label for="company">Company name:</label>
        <input type="text" id="company" name="company" class="form-control @error('company') is-invalid @enderror" required><br>

        @error('cName')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <label for="name">Username:</label>
        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" required><br>

        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" required><br>

        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <label>E-mail to receive invoices:</label>
        <label class="form" style="font-weight: bold;">CompanyName@domain.com</label><br>

        <label for="emailto">E-mail to send documents:</label>
        <input type="email" id="emailto" name="emailto"><br>

        <label for="password">Password:</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required><br>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <div class="operations">
            <button type="submit" class="btn">Register</button>
        </div>
    </form>
</div>
@stop