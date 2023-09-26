@extends('layouts.master')
@vite('resources/js/home.js')
@vite('resources/js/download.js')
@vite('resources/css/index.css')

@section('content')
<input id="token" name="_token" type="hidden" value="{{csrf_token()}}">
<div class="container">
    <div class="d-flex justify-content-center mt-3">
        <div class="btn-group " role="group" aria-label="Basic example">
            <button type="button" id="all" class="btn btn-dark d-flex align-items-center text-primary homeNavi">Wszystkie</button>
            <button type="button" id="incoming" class="btn btn-dark d-flex align-items-center text-secondary homeNavi">Nieopłacone</button>
            <button type="button" id="paid" class="btn btn-dark d-flex align-items-center text-secondary homeNavi">Opłacone</button>
        </div>
    </div>
</div>
<main class="container off" id="empty">
    <div class="list-container">
        <div class="flex-column d-flex justify-content-center">
            <h1 class="display-6 d-flex justify-content-center mt-3 text-center text-secondary">Czekamy na Twoje dokumenty</h1>
            <img src="img/Listening To Feedback.png" class="mt-3">
        </div>
    </div>
    </div>
</main>

<main class="container" id="main">

    <div class="list-container">
        @php($i = 0)
        @foreach($files as $file)
        @php($i++)

        {{--Dla maili--}}
        @if($file->type == "mail")
        <div class="bg-body-tertiary p-3 rounded mt-2 dataBlock">
            <form enctype="multipart/form-data" method="POST" action="{{ route('editFile') }}">
                @csrf
                <div class="d-flex justify-content-between">
                    <div class="d-flex pointer" data-bs-toggle="collapse" data-bs-target="#{{ $i }}" aria-expanded="false" aria-controls="{{ $i }}">
                        <div class="pe-3">
                            <div><span class="material-symbols-outlined {{($file->type)}}">{{($file->type)}}</span></div>
                            <div><span class="material-symbols-outlined text-secondary">expand_more</span></div>
                        </div>
                        <div>
                            <div class="mb-1">{{ $file->title }}</div>
                            <small class="text-secondary fileDate">{{ date('m-d-Y',strtotime($file->created_at)) }}</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="mb-0 d-flex flex-row d-flex align-items-center">
                            <div class="pe-2 price">{{ $file->price }}</div>
                            @if($file->paid == 0)
                            <button type="button" class="btn btn-sm btn-dark d-flex align-items-center rounded-pill">
                                <span class="material-symbols-outlined text-primary status">send_money</span>
                            </button>
                            @else
                            <button type="button" class="btn btn-sm d-flex align-items-center rounded-pill">
                                <span class="material-symbols-outlined text-success status" id="p">paid</span>
                            </button>
                            @endif
                            <button type="button" class="btn btn-sm btn-dark d-flex align-items-center rounded-pill ms-2" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">more_vert</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <input type="hidden" name="id" value="{{ $file->id }}">
                                <li><a class="dropdown-item edit pointer">Edytuj</a></li>
                                <li><a class="dropdown-item" href="/deletefile/{{ $file->id }}">Usuń</a></li>
                                <li><a class="dropdown-item pointer showcase">Podgląd</a></li>
                                <button type="button" class="invisible" data-bs-toggle="modal" data-bs-target="{{'#mail' . $file->id}}"></button>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="collapse data" id="{{ $i }}">

                    <div class="col-sm-12 mt-3 mb-3">
                        @if($file->paid == 0)
                        <button type="button" class="btn paidStatus btn-outline-primary w-100" autocomplete="off">Nie zapłacono</button>
                        <input type="hidden" class="paidHidden" name="paid" value="0">
                        @else
                        <button type="button" class="btn paidStatus btn-success w-100" autocomplete="off">Zapłacono</button>
                        <input type="hidden" class="paidHidden" name="paid" value="1">
                        @endif
                    </div>

                    <div class="imail col-12 mb-3">
                        <label class="form-label">Wysłane z adresu e-mail</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="email" value="{{ $file->email }}" disabled>
                            <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                        </div>
                    </div>

                    <p class="fs-5 text-secondary">Dane pobrane z faktury</p>

                    <div class="col-12 mb-3">
                        <label class="form-label pe-2">Załącznik</label>
                        @if($file->file == 0)
                        <button type="button" class="btn btn-dark">Dodaj</button>
                        @else
                        <a class="download" href="{{url('uploads/file/'. $file->file)}}" target="_blank">
                            <button type="button" class="btn btn-dark fileName">{{ $file->file}}</button>
                        </a>
                        @endif
                    </div>

                    @if(!empty($file->contractor_id))
                    @php($object = $file->Contractor)
                    @php($contractor_id = $object->id)
                    @else
                    @php($object = $file)
                    @php($contractor_id = $object->contractor_id)
                    @endif
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nazwa kontrahenta</label>
                            <div class="input-group">
                                <input type="text" class="form-control" aria-label="Text input with segmented dropdown button" name="contractor" value="{{ $object->contractor }}">
                                <button class="btn btn-outline-secondary d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                                <button class="btn btn-outline-secondary d-flex align-items-center addon addContractor" type="button"><span class="material-symbols-outlined">domain_add</span></button>
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end contractorDiv">
                                    <input type="hidden" class="skip" name='contractor_id' value="{{ $contractor_id }}">
                                    <input class="form-control form-control-sm skip search" type="text" placeholder="Search" aria-label=".form-control-sm example">
                                    <li class="skip">
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li value=""><a class="dropdown-item pointer">None</a></li>
                                    @foreach($contractors as $contractor)
                                    <li value="{{ $contractor->id }}"><a class="dropdown-item pointer">{{ $contractor->contractor }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputAddress" class="form-label">Address</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="inputAddress" name="address1" value="{{ $object->address1 }}">
                                <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputCity" class="form-label">Address</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="inputCity" name="address2" value="{{ $object->address2 }}">
                                <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="numerRachunku" class="form-label">Numer rachunku kontrahenta</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="numerRachunku" name="bank" value="{{ $object->bank }}">
                                <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="nip" class="form-label">NIP</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="nip" name="nip" value="{{ $object->nip }}">
                                <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="opisplatnosci" class="form-label">Opis płatności</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="opisplatnosci" name="description" value="{{ $file->description }}">
                                <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="kwota" class="form-label">Kwota na fakturze</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="kwota" name="price" value="{{ $file->price }}">
                                <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal fade" id="{{'mail' . $file->id}}" tabindex="-1" aria-labelledby="{{'mail' . $file->id}}" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen-sm-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="{{'mail' . $file->id}}">Podgląd maila</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <p class="form-label">Treść maila:</p>
                        {{ $file->content }}"
                    </div>
                </div>
            </div>
        </div>
        {{--Dla płatności cyklicznych--}}
        @elseif($file->type == "avg_pace")
        <div class="bg-body-tertiary p-3 rounded mt-2 dataBlock">
            <form enctype="multipart/form-data" method="POST" action="{{ route('editFile') }}">
                @csrf
                <div class="d-flex justify-content-between">
                    <div class="d-flex pointer" data-bs-toggle="collapse" data-bs-target="#{{ $i }}" aria-expanded="false" aria-controls="{{ $i }}">
                        <div class="pe-3">
                            <div><span class="material-symbols-outlined {{($file->type)}}">{{($file->type)}}</span></div>
                            <div><span class="material-symbols-outlined text-secondary">expand_more</span></div>
                        </div>
                        <div>
                            <div class="mb-1">{{ $file->title }}</div>
                            <small class="text-secondary fileDate">{{ date('m-d-Y',strtotime($file->created_at)) }}</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="mb-0 d-flex flex-row d-flex align-items-center">
                            <div class="pe-2 price">{{ $file->price }}</div>
                            @if($file->paid == 0)
                            <button type="button" class="btn btn-sm btn-dark d-flex align-items-center rounded-pill">
                                <span class="material-symbols-outlined text-primary status">send_money</span>
                            </button>
                            @else
                            <button type="button" class="btn btn-sm d-flex align-items-center rounded-pill">
                                <span class="material-symbols-outlined text-success status" id="p">paid</span>
                            </button>
                            @endif
                            <button type="button" class="btn btn-sm btn-dark d-flex align-items-center rounded-pill ms-2" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">more_vert</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <input type="hidden" name="id" value="{{ $file->id }}">
                                <li><a class="dropdown-item edit pointer">Edytuj</a></li>
                                <li><a class="dropdown-item" href="#">Usuń tą płatność</a></li>
                                <li><a class="dropdown-item" href="/deletefile/{{ $file->id }}">Usuń tą płatność i kolejne</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="collapse data" id="{{ $i }}">

                    <div class="col-sm-12 mt-3 mb-3">
                        @if($file->paid == 0)
                        <button type="button" class="btn paidStatus btn-outline-primary w-100" autocomplete="off">Nie zapłacono</button>
                        <input type="hidden" class="paidHidden" name="paid" value="0">
                        @else
                        <button type="button" class="btn paidStatus btn-success w-100" autocomplete="off">Zapłacono</button>
                        <input type="hidden" class="paidHidden" name="paid" value="1">
                        @endif
                    </div>

                    <p class="fs-5 text-secondary">Ustawienie płatności</p>

                    <div class="imail col-12 mb-3">
                        <label class="form-label pe-2">Załącznik</label>
                        @if($file->file == 0)
                        <button type="button" class="btn btn-dark">Dodaj</button>
                        @else
                        <a class="download" href="{{url('uploads/file/'. $file->file)}}" target="_blank">
                            <button type="button" class="btn btn-dark fileName">{{ $file->file}}</button>
                        </a>
                        @endif
                    </div>

                    <div class="row g-3">

                        <div class="col-12">
                            <label for="companyName" class="form-label">Nazwa płatności</label>
                            <input type="text" class="form-control" id="companyName" name="title" value="{{ $file->title }}">
                        </div>

                        <div class="col-12">
                            <label for="startDate" class="form-label">Cykl płatności od dnia</label>
                            <input id="startDate" class="form-control" type="date" />
                            <span id="startDateSelected"></span>
                        </div>

                        <div class="col-12">
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Nie powtarza się</option>
                                <option value="1">Codziennie</option>
                                <option value="2">Co tydzień w:X</option>
                                <option value="3">Co miesiąc w:X</option>
                                <option value="4">Co rok w dniu:X</option>
                            </select>
                        </div>

                        @if(!empty($file->contractor_id))
                        @php($object = $file->Contractor)
                        @php($contractor_id = $object->id)
                        @else
                        @php($object = $file)
                        @php($contractor_id = $object->contractor_id)
                        @endif
                        <div class="col-12">
                            <label class="form-label">Nazwa kontrahenta</label>
                            <div class="input-group">
                                <input type="text" class="form-control" aria-label="Text input with segmented dropdown button" name="contractor" value="{{ $object->contractor }}">
                                <button class="btn btn-outline-secondary d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                                <button class="btn btn-outline-secondary d-flex align-items-center addon addContractor" type="button"><span class="material-symbols-outlined">domain_add</span></button>
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end contractorDiv">
                                    <input type="hidden" class="skip" name='contractor_id' value="{{ $contractor_id }}">
                                    <input class="form-control form-control-sm skip search" type="text" placeholder="Search" aria-label=".form-control-sm example">
                                    <li class="skip">
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li value=""><a class="dropdown-item pointer">None</a></li>
                                    @foreach($contractors as $contractor)
                                    <li value="{{ $contractor->id }}"><a class="dropdown-item pointer">{{ $contractor->contractor }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputAddress" class="form-label">Address</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="inputAddress" name="address1" value="{{ $object->address1 }}">
                                <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputCity" class="form-label">Address</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="inputCity" name="address2" value="{{ $object->address2 }}">
                                <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="numerRachunku" class="form-label">Numer rachunku kontrahenta</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="numerRachunku" name="bank" value="{{ $object->bank }}">
                                <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="nip" class="form-label">NIP</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="nip" name="nip" value="{{ $object->nip }}">
                                <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="opisplatnosci" class="form-label">Opis płatności</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="opisplatnosci" name="description" value="{{ $file->description }}">
                                <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                            </div>
                        </div>
                        @php($file = $file)
                        <div class="col-md-6">
                            <label for="kwota" class="form-label">Kwota</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="kwota" name="price" value="{{ $file->price }}">
                                <button class="btn btn-outline-secondary rounded-end d-flex align-items-center addon" type="button"><span class="material-symbols-outlined">content_copy</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        {{--Dla skanów--}}
        @else
        <div class="bg-body-tertiary p-3 rounded mt-2 dataBlock">
            <form enctype="multipart/form-data" method="POST" action="{{ route('editFile') }}">
                @csrf
                <div class="d-flex justify-content-between">
                    <div class="d-flex pointer" data-bs-toggle="collapse" data-bs-target="#{{ $i }}" aria-expanded="false" aria-controls="{{ $i }}">
                        <div class="pe-3">
                            <div><span class="material-symbols-outlined {{($file->type)}}">{{($file->type)}}</span></div>
                            <div><span class="material-symbols-outlined text-secondary">expand_more</span></div>
                        </div>
                        <div>
                            <div class="mb-1">{{ $file->title }}</div>
                            <small class="text-secondary fileDate">{{ date('m-d-Y',strtotime($file->created_at)) }}</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="mb-0 d-flex flex-row d-flex align-items-center">
                            <div class="pe-2 price">{{ $file->price }}</div>
                            @if($file->paid == 0)
                            <button type="button" class="btn btn-sm d-flex align-items-center rounded-pill">
                                <span class="material-symbols-outlined text-danger status">paid</span>
                            </button>
                            @else
                            <button type="button" class="btn btn-sm d-flex align-items-center rounded-pill">
                                <span class="material-symbols-outlined text-success status" id="p">paid</span>
                            </button>
                            @endif
                            <button type="button" class="btn btn-sm btn-dark d-flex align-items-center rounded-pill ms-2" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">more_vert</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <input type="hidden" name="id" value="{{ $file->id }}">
                                <li><a class="dropdown-item edit pointer">Edytuj</a></li>
                                <li><a class="dropdown-item" href="/deletefile/{{ $file->id }}">Usuń</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="{{ $i }}">

                    <div class="col-sm-12 mt-3 mb-3">
                        @if($file->paid == 0)
                        <button type="button" class="btn paidStatus btn-outline-primary w-100" autocomplete="off">Nie zapłacono</button>
                        <input type="hidden" class="paidHidden" name="paid" value="0">
                        @else
                        <button type="button" class="btn paidStatus btn-success w-100" autocomplete="off">Zapłacono</button>
                        <input type="hidden" class="paidHidden" name="paid" value="1">
                        @endif
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label pe-2">Załącznik</label>
                        @if($file->file == 0)
                        <button type="button" class="btn btn-dark">Dodaj</button>
                        @else
                        <a class="download" href="{{url('uploads/file/'. $file->file)}}" target="_blank">
                            <button type="button" class="btn btn-dark fileName">{{ $file->file}}</button>
                        </a>
                        @endif
                    </div>

                    <p class="fs-5 text-secondary">Informacje nt. skanu</p>

                    <form class="row g-3">

                        <div class="col-12">
                            <label class="form-label">Nazwa skanu</label>
                            <input type="text" class="form-control" id="Nazwaplatnosci" name="title" value="{{ $file->title }}">
                        </div>

                        <div class="col-12">
                            <label for="typeNumber" class="form-label">Kwota</label>
                            <input type="number" class="form-control" id="typeNumber" name="price" value="{{ $file->price }}" min="0">
                        </div>

                    </form>

                </div>
            </form>
        </div>
        @endif
        @endforeach

        <div class="footer_list d-flex mt-4 justify-content-end">
            <div class="flex-column">
                <div class="total d-flex justify-content-end fullPrice"></div>
                <div class="d-flex mt-4 justify-content-end">
                    <button type="button" class="btn btn-outline-primary d-flex align-items-center rounded-pill">Opłać wszystkie<span class="material-symbols-outlined ps-2">send_money</span></button>
                </div>
            </div>
        </div>
    </div>

</main>

<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
    <div class="container">
        <div class="list-container">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasBottomLabel">Akcje na kosztach z miesiąca</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body small">
                <div class="d-grid gap-3">
                    <button class="btn btn-primary d-flex justify-content-center" id="downloadAll" type="button">Pobierz wszystkie dokumenty
                        <span class="material-symbols-outlined ms-1">download</span>
                    </button>
                    <button class="btn btn-primary d-flex justify-content-center" type="button">Wyślij wszystkie dokumenty
                        <span class="material-symbols-outlined ms-2">forward_to_inbox</span>
                    </button>
                    <small class="text-secondary">Dokumenty wysłane na adres: {{ Auth::user()->emailTo }}</small>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal-platnosc cykliczna -->
<div class="modal fade data" id="cost" tabindex="-1" aria-labelledby="cost" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
            <form enctype="multipart/form-data" method="POST" action="{{ route('addFile') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="cost">Dodaj koszt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="col-sm-12 mb-2">
                        <button type="button" class="btn paidStatus btn-outline-primary w-100" autocomplete="off">Nie zapłacono</button>
                        <input type="hidden" class="paidHidden" name="paid" value="0">
                    </div>

                    <p class="fs-5 text-secondary">Ustawienie płatności</p>

                    <div class="row g-3">

                        <div class="imail col-12">
                            <label for="companyName" class="form-label">Nazwa płatności</label>
                            <input type="text" class="form-control skip" id="companyName" name="title">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control skip" id="email" name="email">
                        </div>

                        <div class="col-12">
                            <label for="startDate" class="form-label">Cykl płatności od dnia</label>
                            <input id="startDate" class="form-control skip" type="date" />
                            <span id="startDateSelected"></span>
                        </div>

                        <div class="col-12">
                            <select class="form-select" aria-label="Default select example">
                                <option selected value="0">Nie powtarza się</option>
                                <option value="1">Codziennie</option>
                                <option value="2">Co tydzień</option>
                                <option value="3">Co miesiąc</option>
                                <option value="4">Co rok</option>
                            </select>
                        </div>

                        <div class="col-12 align-items-center">
                            <button type="button" class="btn btn-primary fileNameAdd">Dodaj załącznik</button>
                            <input type="file" class="invisible" id="fileScan" name="fileName"></input>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nazwa kontrahenta</label>
                            <div class="input-group">
                                <input type="text" class="form-control skip" aria-label="Text input with segmented dropdown button" name="contractor">
                                <button class="btn btn-outline-secondary d-flex align-items-center addContractor" type="button"><span class="material-symbols-outlined">domain_add</span></button>
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end contractorDiv">
                                    <input type="hidden" class="skip" name='contractor_id'>
                                    <input class="form-control form-control-sm skip search" type="text" placeholder="Search" aria-label=".form-control-sm example">
                                    <li class="skip">
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li value=""><a class="dropdown-item pointer">None</a></li>
                                    @foreach($contractors as $contractor)
                                    <li value="{{ $contractor->id }}"><a class="dropdown-item pointer">{{ $contractor->contractor }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputAddress" class="form-label">Address1</label>
                            <div class="input-group">
                                <input type="text" class="form-control skip" id="inputAddress" name="address1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputCity" class="form-label">Address2</label>
                            <div class="input-group">
                                <input type="text" class="form-control skip" id="inputCity" name="address2">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="numerRachunku" class="form-label">Numer rachunku kontrahenta</label>
                            <div class="input-group">
                                <input type="text" class="form-control skip" id="numerRachunku" name="bank">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="nip" class="form-label">NIP</label>
                            <div class="input-group">
                                <input type="text" class="form-control skip" id="nip" name="nip">
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="opisplatnosci" class="form-label">Opis płatności</label>
                            <div class="input-group">
                                <input type="text" class="form-control skip" id="opisplatnosci" name="description">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="kwota" class="form-label">Kwota</label>
                            <div class="input-group">
                                <input type="text" class="form-control skip" id="kwota" name="price">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                    <button type="submit" class="btn btn-primary scanSubmit">Dodaj</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal-scan -->
<div class="modal fade" id="addScan" tabindex="-1" aria-labelledby="addScan" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
            <form enctype="multipart/form-data" method="POST" action="{{ route('scanUpload') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addScan">Dodaj scan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-12">
                            <label for="title" class="form-label">Nazwa płatności</label>
                            <input class="form-control skip" type="text" id="title" name="title" required>
                        </div>

                        <div class="col-12">
                            <label for="price" class="form-label">Kwota</label>
                            <input class="form-control skip" type="number" id="price" name="price" min="0" step="0.01" required>
                        </div>

                        <div class="col-sm-12">
                            <button type="button" class="btn paidStatus btn-outline-primary w-100" autocomplete="off">Nie zapłacono</button>
                            <input type="hidden" class="paidHidden" name="paid" value="0">
                        </div>

                        <div class="col-12 align-items-center">
                            <button type="button" class="btn btn-primary fileNameAdd">Dodaj załącznik</button>
                            <input type="file" class="invisible" id="fileScan" name="fileName"></input>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                    <button type="submit" class="btn btn-primary scanSubmit">Dodaj</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal-draft -->
<div class="modal fade" id="addDraft" tabindex="-1" aria-labelledby="addDraft" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down">
        <div class="modal-content">
            <form enctype="multipart/form-data" method="POST" action="{{ route('pdfUpload') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addScan">Zeskanuj dokument</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-12">
                            <label for="title" class="form-label">Nazwa płatności</label>
                            <input class="form-control skip" type="text" id="title" name="title" required>
                        </div>

                        <div class="col-12">
                            <label for="price" class="form-label">Kwota</label>
                            <input class="form-control skip" type="number" id="price" name="price" min="0" step="0.01" required>
                        </div>

                        <div class="col-sm-12">
                            <button type="button" class="btn paidStatus btn-outline-primary w-100" autocomplete="off">Nie zapłacono</button>
                            <input type="hidden" class="paidHidden" name="paid" value="0">
                        </div>

                        <div class="col-12 align-items-center">
                            <button type="button" class="btn btn-primary fileNameAdd">Dodaj załącznik</button>
                            <input type="file" class="invisible" id="fileScan" name="fileName"></input>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                    <button type="button" class="btn btn-primary scanSubmit">Dodaj</button>
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
                    <p class="mb-0">Dodaj koszt</p>
                </div>
                <div class="d-flex flex-row">
                    <button type="button" class="btn btn-sm btn-dark d-flex align-items-center rounded-pill ms-3" data-bs-toggle="modal" data-bs-target="#cost">
                        <span class="material-symbols-outlined avg_pace">avg_pace</span>
                    </button>
                    <button type="button" class="btn btn-sm btn-dark d-flex align-items-center rounded-pill ms-3" data-bs-toggle="modal" data-bs-target="#addScan">
                        <span class="material-symbols-outlined scan">scan</span>
                    </button>
                    <button type="button" class="btn btn-sm btn-dark d-flex align-items-center rounded-pill ms-3" data-bs-toggle="modal" data-bs-target="#addDraft">
                        <span class="material-symbols-outlined draft">draft</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</footer>

@stop