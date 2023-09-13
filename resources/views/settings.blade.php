@extends('layouts.master')
@vite('resources/css/index.css')
@vite('resources/js/settings.js')

@section('navi')
<a class="selected">Account settings</a>
@stop

@section('calendar')
@show

@section('content')

<div class="container">
    <div class="list-container">
        <h4 class="container text-secondary">Ustawienia konta</h4>
    </div>
</div>

<div class="container">
    <div class="d-flex justify-content-center mt-3">
        <div class="btn-group " role="group" aria-label="Basic example">
            <button type="button" id="account" class="btn btn-dark d-flex align-items-center text-primary navi">Konto</button>
            <button type="button" id="password" class="btn btn-dark d-flex align-items-center text-secondary navi">Hasło</button>
            <button type="button" id="email" class="btn btn-dark d-flex align-items-center text-secondary navi">E-mail do faktur</button>
        </div>
    </div>
</div>


<main class="container">

    <div class="list-container">

        <div class="bg-body-tertiary p-3 rounded mt-4 block account">

            <div class="col-md-12 mb-3">
                <label for="inputAddress" class="form-label">Nazwa firmy</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="inputAddress" placeholder="">
                </div>
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Logo firmy</label>
                <input class="form-control" type="file" id="formFile">
            </div>

            <hr class="divider">

            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Email </label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com">
                </div>
            </div>

            <hr class="divider">

            <div class="col-md-12">
                <label for="inputAddress" class="form-label">E-mail do księgowości</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="inputAddress" placeholder="">
                </div>
            </div>
        </div>

        <div class="bg-body-tertiary p-3 rounded mt-4 block password off">

            <div class="col-md-12 mb-3">
                <label for="inputAddress" class="form-label">Hasło</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="inputPassword">
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <label for="inputPassword" class="col-form-label">Powtórzenie hasła</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="inputPassword">
                </div>
            </div>

        </div>

        <div class="bg-body-tertiary p-3 rounded mt-4 block email off">

            <div class="col-md-12 mb-3">
                <label for="inputAddress" class="form-label">Adres e-mail do odbioru faktur</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="inputAddress" placeholder="">
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <label for="inputAddress" class="form-label">Port SMTP</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="inputAddress" placeholder="">
                </div>
            </div>
        </div>

    </div>

</main>

<footer class="footer mt-auto py-3 bg-body-tertiary fixed-bottom z-5">
    <div class="container">
        <div class="list-container">
            <div class="d-flex justify-content-between align-items-center">
                <div>

                </div>
                <div class="d-flex flex-row">
                    <button type="button" class="btn btn-primary btn-sm">Zapisz</button>
                </div>
            </div>
        </div>
    </div>
</footer>

@stop