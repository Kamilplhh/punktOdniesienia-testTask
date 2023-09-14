@extends('layouts.master')
@vite('resources/css/index.css')
@vite('resources/js/settings.js')

@section('calendar')
@show

@section('content')
<div class="container">
    <div class="list-container">
        <h4 class="container text-secondary">Lista dostawców</h4>
    </div>
</div>

<main class="container">
    <div class="list-container">
        <div class="bg-body-tertiary p-3 rounded mt-4">
            <div class="d-flex justify-content-between">
                <div class="d-flex" data-bs-toggle="collapse" data-bs-target="#1" aria-expanded="false" aria-controls="1">
                    <div class="pe-3">
                        <div><span class="material-symbols-outlined ">apartment</span></div>
                        <div><span class="material-symbols-outlined text-secondary">expand_more</span></div>
                    </div>
                    <div>
                        <div class="mb-1">IKEA Retail sp. z o.o.</div>
                        <small class="text-secondary">6.08.2023</small>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="mb-0 d-flex flex-row d-flex align-items-center">
                        <button type="button" class="btn btn-sm btn-dark d-flex align-items-center rounded-pill ms-2" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="material-symbols-outlined">more_vert</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Edytuj</a></li>
                            <li><a class="dropdown-item" href="#">Usuń</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="collapse" id="1">

                <div class="col-12 mb-3">
                    <label for="email" class="form-label">Powiązany adres e-mail</label>
                    <div class="input-group">
                        <input class="form-control" type="text" placeholder="you@example.com" aria-label="Disabled input example">
                        <button class="btn btn-outline-secondary d-flex align-items-center" type="button" id="button-addon2"><span class="material-symbols-outlined">content_copy</span></button>
                        <button class="btn btn-outline-secondary rounded-end d-flex align-items-center" type="button" id="button-addon2"><span class="material-symbols-outlined">add</span></button>
                        <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div>
                    </div>
                </div>

                <p class="fs-5 text-secondary">Dane dostawcy</p>

                <form class="row g-3">
                    <div class="col-12">
                        <label for="companyName" class="form-label">Nazwa dostawcy</label>
                        <div class="input-group">
                            <input type="text" class="form-control" aria-label="Text input with segmented dropdown button">
                            <button class="btn btn-outline-secondary d-flex align-items-center" type="button" id="button-addon2"><span class="material-symbols-outlined">content_copy</span></button>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputAddress" class="form-label">Address</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="inputAddress" placeholder="">
                            <button class="btn btn-outline-secondary rounded-end d-flex align-items-center" type="button" id="button-addon2"><span class="material-symbols-outlined">content_copy</span></button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputAddress" class="form-label">Address</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="inputCity" placeholder="">
                            <button class="btn btn-outline-secondary rounded-end d-flex align-items-center" type="button" id="button-addon2"><span class="material-symbols-outlined">content_copy</span></button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="kwota" class="form-label">Numer rachunku dostawcy</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="Numerrachunku">
                            <button class="btn btn-outline-secondary rounded-end d-flex align-items-center" type="button" id="button-addon2"><span class="material-symbols-outlined">content_copy</span></button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="nip" class="form-label">NIP</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="nip" placeholder="">
                            <button class="btn btn-outline-secondary rounded-end d-flex align-items-center" type="button" id="button-addon2"><span class="material-symbols-outlined">content_copy</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<footer class="footer mt-auto py-3 bg-body-tertiary fixed-bottom z-5">
    <div class="container">
        <div class="list-container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-0">Dodaj dostawcę</p>
                </div>
                <div class="d-flex flex-row">
                    <button type="button" class="btn btn-sm btn-dark d-flex align-items-center rounded-pill ms-3" data-bs-toggle="modal" data-bs-target="#cost1">
                        <span class="material-symbols-outlined c2">domain_add</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</footer>

@stop