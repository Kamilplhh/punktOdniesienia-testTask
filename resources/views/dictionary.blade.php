@extends('layouts.master')
@vite('resources/css/index.css')

@section('calendar')
@show

@section('content')

<div class="container my-5">
    <div class="list-container">
        <h4 class="container text-secondary">Słownik</h4>
    </div>
</div>

<main class="container">

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Kontrahent</th>
                <th scope="col">Adres</th>
                <th scope="col">Nr. rachunku</th>
                <th scope="col">NIP</th>
                <th scope="col">Cena</th>
            </tr>
        </thead>
        <tbody>
            @foreach($scans as $scan)
            <tr>
                <td>{{$scan->contractorText}}</td>
                <td>{{$scan->addressText}}</td>
                <td>{{$scan->bankText}}</td>
                <td>{{$scan->nipText}}</td>
                <td>{{$scan->priceText}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</main>

<div class="modal fade" id="row" tabindex="-1" aria-labelledby="row" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="row">Dodaj słowo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="row g-3" method="POST" action="{{ route('addScanner') }}">
                    @csrf
                    <div class="col-12">
                        <label for="contractorText" class="form-label">Kontrahent</label>
                        <input type="text" class="form-control" id="contractorText" placeholder="Kontrahent" name="contractorText" value="">
                    </div>

                    <div class="col-12">
                        <label for="addressText" class="form-label">Adres</label>
                        <input type="text" class="form-control" id="addressText" placeholder="Adres" name="addressText" value="">
                    </div>

                    <div class="col-12">
                        <label for="bankText" class="form-label">Nr. rachunku</label>
                        <input type="text" class="form-control" id="bankText" placeholder="Bank" name="bankText" value="">
                    </div>

                    <div class="col-12">
                        <label for="nipText" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nipText" placeholder="NIP" name="nipText" value="">
                    </div>

                    <div class="col-12">
                        <label for="priceText" class="form-label">Cena</label>
                        <input type="text" class="form-control" id="priceText" placeholder="Cena" name="priceText" value="">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                <button type="submit" class="btn btn-primary">Dodaj</button>
            </div>
            </form>
        </div>
    </div>
</div>

<footer class="footer mt-auto py-3 bg-body-tertiary fixed-bottom z-5">
    <div class="container">
        <div class="list-container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                </div>
                <div class="d-flex flex-row">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#row">
                        Dodaj
                    </button>
                </div>
            </div>
        </div>
    </div>
</footer>

@stop