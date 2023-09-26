@extends('layouts.master')
@vite('resources/css/index.css')
@vite('resources/js/admin.js')

@section('calendar')
@show

@section('content')
<div class="container">
    <div class="list-container">
        <h4 class="container text-secondary aPanel">Lista użytkowników</h4>
        <h4 class="container text-secondary dPanel off">Słownik</h4>
    </div>
</div>

<main class="container">
    <div class="list-container">
        @php($i = 0)
        @foreach($users as $user)
        @php($i++)
        <div class="bg-body-tertiary p-3 rounded mt-2 aPanel">
            <div class="d-flex justify-content-between">
                <div class="d-flex pointer" data-bs-toggle="collapse" data-bs-target="#{{ $i }}" aria-expanded="false" aria-controls="{{ $i }}">
                    <div class="pe-3">
                        <div><span class="material-symbols-outlined">groups</span></div>
                        <div><span class="material-symbols-outlined text-secondary">expand_more</span></div>
                    </div>
                    <div>
                        <div class="mb-1">{{ $user->company }}</div>
                        <small class="text-secondary">{{ date('m-d-Y',strtotime($user->created_at)) }}</small>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="mb-0 d-flex flex-row d-flex align-items-center">
                        <button type="button" class="btn btn-sm btn-dark d-flex align-items-center rounded-pill ms-2" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="material-symbols-outlined">more_vert</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/deleteuser/{{ $user->id }}">Usuń</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="collapse" id="{{ $i }}">

                <p class="fs-5 text-secondary">Dane użytkownika</p>

                <div class="col-12">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <input type="text" class="form-control" aria-label="Text input with segmented dropdown button" value="{{ $user->email }}" disabled>
                        <button class="btn btn-outline-secondary d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Email do księgowej</label>
                    <div class="input-group">
                        <input type="text" class="form-control" aria-label="Text input with segmented dropdown button" value="{{ $user->emailTo }}" disabled>
                        <button class="btn btn-outline-secondary d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Email od faktur</label>
                    <div class="input-group">
                        <input type="text" class="form-control" aria-label="Text input with segmented dropdown button" value="{{ $user->invoiceEmail }}" disabled>
                        <button class="btn btn-outline-secondary d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    
    <table class="table table-striped dPanel off">
        <thead>
            <tr>
                <th scope="col">Kontrahent</th>
                <th scope="col">Adres</th>
                <th scope="col">Nr. rachunku</th>
                <th scope="col">NIP</th>
                <th scope="col">Cena</th>
                <th scope="col">User_id</th>
                <th scope="col"></th>
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
                <td>{{$scan->user_id}}</td>
                <td><a href="/deleteName/{{$scan->id}}"><button type="button" class="btn btn-danger" autocomplete="off">Usuń</button></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
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
                    <button type="button" class="btn btn-primary btn-sm back off">
                        Cofnij
                    </button>
                </div>
                <div class="d-flex flex-row">
                    <button type="button" class="btn btn-primary btn-sm next">
                        Dalej
                    </button>
                    <button type="button" class="btn btn-primary btn-sm dPanel off" data-bs-toggle="modal" data-bs-target="#row">
                        Dodaj
                    </button>
                </div>
            </div>
        </div>
    </div>
</footer>
@stop