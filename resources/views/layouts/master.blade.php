<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Punkt Odniesienia">

    <title>CostLinker</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/navbar-bottom/">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    @vite('resources/js/app.js')
    @vite('resources/js/color-modes.js')
</head>

<body>
    @section('navbar')
    <div class="container">
        <nav class="navbar navbar-dark bg-dark" aria-label="Oo">
            <div class="container-fluid">
                @auth
                <a class="navbar-brand" href="/">{{ Auth::user()->company }}</a>
                @if(!empty(Auth::user()->logo))
                <button class="profile" style="background-image: {{url('uploads/logo/'. Auth::user()->logo)}};" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
                    @else
                    <button class="profile" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
                        @endif
                        @endauth
                    </button>

                    <div class="collapse navbar-collapse" id="navbarsExample01">
                        <ul class="navbar-nav me-auto mb-2">
                            <li class="nav-item">
                                <a class="nav-link d-flex justify-content-end" href="/">Lista dostawców
                                    <span class="material-symbols-outlined ms-2">groups</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex justify-content-end" href="/settings">Ustawienia
                                    <span class="material-symbols-outlined ms-2">settings</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex justify-content-end" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Wyloguj się
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    <span class="material-symbols-outlined ms-2">logout</span>
                                </a>
                            </li>

                        </ul>
                    </div>
            </div>
        </nav>
    </div>
    @show

    @section('calendar')
    <div class="container">
        <div class="d-flex justify-content-between mt-1">

            <div class="d-flex align-items-center">
                <button class="btn btn-sm btn-dark d-flex align-items-center rounded-pill pe-2 arrow" type="button" value="1" id="back">
                    <span class="material-symbols-outlined">arrow_back</span>
                </button>
                <div class="text-primary px-2 month"></div>
                <button class="btn btn-sm btn-dark d-flex align-items-center rounded-pill" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">
                    <span class="material-symbols-outlined">more_horiz</span>
                </button>
            </div>

            <div class="d-flex align-items-center">
                <div class="px-2 text-secondary nextMonth"></div>
                <button class="btn btn-sm btn-dark d-flex align-items-center rounded-pill pe-2 arrow disabled" type="button" value="0" id="next">
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
        </div>
    </div>
    @show

    <div class="panel">
        <div class="data">
            @yield('content')
        </div>

    </div>
</body>

</html>