@extends('layouts.master')
@vite('resources/css/index.css')
@vite('resources/js/register.js')

@section('navbar')
@stop

@section('calendar')
@show

@section('content')
<div class="container mt-4">
    <div class="list-container">
        <h4 class="container text-secondary">Pierwsze ustawienia konta</h4>
    </div>
</div>

<main class="container">
    <div class="list-container">

        <div class="bg-body-tertiary p-3 rounded mt-4 block" id="0">
            <div class="col-md-12 mb-3">
                <label for="inputAddress" class="form-label">Login</label>
                <div class="input-group">
                    <input type="login" class="form-control" id="login" name="login">
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <label for="inputAddress" class="form-label">Hasło</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="inputPassword" name="password">
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <label for="inputPassword" class="col-form-label">Powtórzenie hasła</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="inputPassword" name="passwordRepeat">
                </div>
            </div>
        </div>

        <div class="bg-body-tertiary p-3 rounded mt-4 off block" id="1">

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

            <div class="col-md-12">
                <label for="inputAddress" class="form-label">E-mail do księgowości</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="inputAddress" placeholder="">
                </div>
            </div>

        </div>


        <div class="bg-body-tertiary p-3 rounded mt-4 off block" id="2">
            <div class="col-md-12 mb-3">
                <label for="inputAddress" class="form-label">Adres e-mail do odbioru faktur</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="inputAddress" placeholder="">
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <label for="inputAddress" class="form-label">Hasło</label>
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
    </div>

    <footer class=" footer mt-auto py-3 bg-body-tertiary fixed-bottom z-5">
        <div class="container">
            <div class="list-container">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <button type="button" class="btn btn-primary btn-sm back" value=0>Cofnij</button>
                    </div>
                    <div class="d-flex flex-row">
                        <button type="submit" id="skip" class="btn btn-outline-secondary btn-sm me-3 off">Pomiń</button><button type="button" class="btn btn-primary btn-sm submit">Dalej</button>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</main>

@stop

