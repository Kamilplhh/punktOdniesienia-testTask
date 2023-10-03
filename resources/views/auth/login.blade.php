@extends('layouts.master')
@vite('resources/css/index.css')

@section('navbar')
@stop

@section('calendar')
@show

@section('content')

<div class="container mt-4">
    <div class="list-container">
        <h4 class="container text-secondary">Logowanie</h4>
    </div>
</div>
<main class="container">
    <div class="list-container">
        <div class="bg-body-tertiary p-3 rounded mt-4">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="col-md-12 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>

                @error('email')
                        
                @enderror

                <div class="col-md-12 mb-3">
                    <label for="inputPassword" class="col-form-label">Hasło</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="inputPassword" name="password" required>
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
                    <a href="{{ route('register') }}"><button type="button" class="btn btn-primary btn-sm me-3">Stwórz konto</button></a>
                    <button type="submit" class="btn btn-primary btn-sm">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</footer>
@stop