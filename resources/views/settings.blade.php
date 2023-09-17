@extends('layouts.master')
@vite('resources/css/index.css')
@vite('resources/js/settings.js')

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

<form enctype="multipart/form-data" method="POST" action="{{ route('profileUpdate') }}">
    @csrf
    <main class="container">

        <div class="list-container">

            <div class="bg-body-tertiary p-3 rounded mt-4 block account">

                <div class="col-md-12 mb-3">
                    <label for="company" class="form-label">Nazwa firmy</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="company" name="company" value="{{ Auth::user()->company }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="icon" class="form-label">Logo firmy</label>
                    <input class="form-control" type="file" id="icon" name="icon">
                </div>

                <hr class="divider">

                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" readonly class="form-control-plaintext" id="email" value="{{ Auth::user()->email }}">
                    </div>
                </div>

                <hr class="divider">

                <div class="col-md-12">
                    <label for="emailTo" class="form-label">E-mail do księgowości</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="emailTo" name="emailTo" value="{{ Auth::user()->emailTo }}">
                    </div>
                </div>
            </div>

            <div class="bg-body-tertiary p-3 rounded mt-4 block password off">

                <div class="col-md-12 mb-3">
                    <label for="password1" class="form-label">Hasło</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password1" name="password">
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
                    <label for="invoiceEmail" class="form-label">Adres e-mail do odbioru faktur</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="invoiceEmail" name="invoiceEmail" value="{{ Auth::user()->invoiceEmail }}">
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="emailPassword" class="form-label">Hasło dla e-maila do odbioru faktur</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="emailPassword" name="emailPassword">
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="emailPort" class="form-label">Port SMTP</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="emailPort" name="emailPort" value="{{ Auth::user()->emailPort }}">
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
                        <button class="btn btn-primary btn-sm submit">Zapisz</button>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</form>

@stop