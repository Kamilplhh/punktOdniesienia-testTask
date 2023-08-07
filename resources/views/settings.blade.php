@extends('layouts.master')
@vite('resources/css/settings.css')


@section('navi')
<a class="selected">Account settings</a>
@stop

@section('calendar')
@show

@section('cost')
@show

@section('content')

<form action="">
    <label for="Logo">Logo:</label>
    <input type="file" id="logo" name="firstname"><br>

    <label for="cName">Company name:</label>
    <input type="text" id="cName" name="cName" placeholder="" required><br>

    <label for="login">User name:</label>
    <input type="text" id="login" name="login" placeholder="" required><br>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" placeholder="" required><br>

    <label>E-mail to receive invoices:</label>
    <label class="form" style="font-weight: bold;">CompanyName@domain.com</label><br>

    <label for="postEmail">E-mail to send documents:</label>
    <input type="text" id="postEmail" name="postEmail" placeholder=""><br>

    <div class="operations">
        <a href="/" class="btn">Cancel</a>
        <button type="submit" class="btn">Save</button>
    </div>
</form>

@stop