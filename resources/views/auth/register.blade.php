@extends('layouts.master')
@vite('resources/css/index.css')
@vite('resources/css/register.css')
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
        <form enctype="multipart/form-data" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="bg-body-tertiary p-3 rounded mt-4 block" id="0">

                <div class="col-md-12 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <input type="email" class="form-control @error('email')  is-invalid" placeholder="Email jest już zajęty"  @enderror name="email" id="email" >
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="password" class="form-label">Hasło</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="col-form-label">Powtórzenie hasła</label>
                    <div class="input-group">
                        <input type="password" class="form-control passwordRepeat">
                    </div>
                </div>

            </div>

            <div class="bg-body-tertiary p-3 rounded mt-4 block off" id="1">

                <div class="col-md-12 mb-3">
                    <label for="company" class="form-label">Nazwa firmy</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="company" id="company">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="logo" class="form-label">Logo firmy</label>
                    <input class="form-control skip" type="file" name="logo" id="logo" value="null">
                </div>

                <hr class="divider">

                <div class="col-md-12">
                    <label for="emailTo" class="form-label">E-mail do księgowości</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="emailTo" id="emailTo">
                    </div>
                </div>

            </div>


            <div class="bg-body-tertiary p-3 rounded mt-4 block off" id="2">

                <div class="col-md-12 mb-3">
                    <label for="invoiceEmail" class="form-label">Adres e-mail do odbioru faktur</label>
                    <div class="input-group">
                        <input type="text" class="form-control skip" name="invoiceEmail" id="invoiceEmail">
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="emailPassword" class="form-label">Hasło</label>
                    <div class="input-group">
                        <input type="password" class="form-control skip" name="emailPassword" id="emailPassword">
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="emailPort" class="form-label">Port SMTP</label>
                    <div class="input-group">
                        <input type="text" class="form-control skip" name="emailPort" id="emailPort">
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
                        <button type="button" id="skip" class="btn btn-outline-secondary btn-sm me-3 off">Pomiń</button><button type="button" class="btn btn-primary btn-sm submit">Dalej</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</main>

@stop