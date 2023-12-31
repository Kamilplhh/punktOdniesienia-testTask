@extends('layouts.master')
@vite('resources/css/index.css')
@vite('resources/js/contractor.js')

@section('calendar')
@show

@section('content')
<div class="container">
    <div class="list-container">
        <h4 class="container text-secondary">Lista dostawców</h4>
    </div>
</div>

<main class="container my-5">
    <div class="list-container">
        @php($i = 0)
        @foreach($files as $file)
        @php($i++)
        <form method="POST" action="{{ route('editContractor') }}">
            @csrf
            <input type="hidden" name="id" value="{{ $file->id }}">
            <div class="bg-body-tertiary p-3 rounded mt-2 dataDiv">
                <div class="d-flex justify-content-between">
                    <div class="d-flex pointer" data-bs-toggle="collapse" data-bs-target="#{{ $i }}" aria-expanded="false" aria-controls="{{ $i }}">
                        <div class="pe-3">
                            <div><span class="material-symbols-outlined ">apartment</span></div>
                            <div><span class="material-symbols-outlined text-secondary">expand_more</span></div>
                        </div>
                        <div>
                            <div class="mb-1">{{ $file->contractor }}</div>
                            <small class="text-secondary">{{ date('m-d-Y',strtotime($file->created_at)) }}</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="mb-0 d-flex flex-row d-flex align-items-center">
                            <button type="button" class="btn btn-sm btn-dark d-flex align-items-center rounded-pill ms-2" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">more_vert</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item edit pointer">Edytuj</a></li>
                                <li><a class="dropdown-item" href="/deleteContractor/{{ $file->id }}">Usuń</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="collapse" id="{{ $i }}">

                    <div class="col-12 mb-3">
                        <label for="email" class="form-label">Powiązany adres e-mail</label>
                        <div class="input-group">
                            <input class="form-control skip" type="text" name="email" value="{{ $file->email }}" aria-label="Disabled input example" disabled>
                            <button class="btn btn-outline-secondary d-flex align-items-center" type="button addon"><span class="material-symbols-outlined">content_copy</span></button>
                            <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon emailAdd" type="button"><span class="material-symbols-outlined">add</span></button>
                        </div>
                        @for($index = 1; $index <= 4; $index++)
                        @php($email = 'email' . $index)
                        <div class="input-group emails">
                            <input class="form-control" type="text" name="{{$email}}" value="{{ $file->$email }}" aria-label="Disabled input example" disabled>
                            <button class="btn btn-outline-secondary d-flex align-items-center remove" type="button"><span class="material-symbols-outlined">remove</span></button>
                            @if($email === 'email4')

                            @else
                            <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon emailAdd" type="button"><span class="material-symbols-outlined">add</span></button>
                            @endif
                        </div>
                        @endfor
                    </div>

                    <p class="fs-5 text-secondary">Dane dostawcy</p>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nazwa dostawcy</label>
                            <div class="input-group">
                                <input type="text" class="form-control" aria-label="Text input with segmented dropdown button" name="contractor" value="{{ $file->contractor }}" disabled>
                                <button class="btn btn-outline-secondary d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputAddress" class="form-label">Address</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="inputAddress" name="address1" value="{{ $file->address1 }}" disabled>
                                <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputAddress" class="form-label">Address</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="inputCity" name="address2" value="{{ $file->address2 }}" disabled>
                                <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="kwota" class="form-label">Numer rachunku dostawcy</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="Numerrachunku" name="bank" value="{{ $file->bank}}" disabled>
                                <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="nip" class="form-label">NIP</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="nip" name="nip" value="{{ $file->nip }}" disabled>
                                <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                            </div>
                        </div>

                        <div class="col-sm-12 buttons off">
                            <button type="button" class="btn btn-danger cancel" autocomplete="off">Anuluj</button>
                            <button type="submit" class="btn btn-success" autocomplete="off">Zapisz</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
        @endforeach
    </div>
</main>

<div class="modal fade" id="contractor" tabindex="-1" aria-labelledby="row" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="row">Dodaj kontrahenta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="row g-3" method="POST" action="{{ route('addContractor') }}">
                    @csrf
                    <div class="col-12">
                        <label for="contractor" class="form-label">Kontrahent</label>
                        <input type="text" class="form-control" id="contractor" name="contractor" required>
                    </div>

                    <div class="col-12">
                        <label for="address1" class="form-label">Adres1</label>
                        <input type="text" class="form-control" id="address1" name="address1" required>
                    </div>

                    <div class="col-12">
                        <label for="address2" class="form-label">Adres2</label>
                        <input type="text" class="form-control" id="address2" name="address2" required>
                    </div>

                    <div class="col-12">
                        <label for="bank" class="form-label">Nr. rachunku</label>
                        <input type="numeric" class="form-control" id="bank" name="bank" min="0" required>
                    </div>

                    <div class="col-12">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="numeric" class="form-control" id="nip" name="nip" min="0" required>
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
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
                    <p class="mb-0">Dodaj dostawcę</p>
                </div>
                <div class="d-flex flex-row">
                    <button type="button" class="btn btn-sm btn-dark d-flex align-items-center rounded-pill ms-3" data-bs-toggle="modal" data-bs-target="#contractor">
                        <span class="material-symbols-outlined c2">domain_add</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</footer>

@stop