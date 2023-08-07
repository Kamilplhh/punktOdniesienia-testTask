<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
</head>
<body>
    @section('navbar')
    <div class="navbar">
        <div class="company">
        @auth
            <div class="img"></div>
            Company Name
        @endauth
        </div>

        <div class="navButton">
        @auth
            {{ Auth::user()->name }}
        @endauth
            <i class="fa-solid fa-ellipsis-vertical fa-xl dots"></i>
            <div class="dotsBar">
            @guest
                <a href="{{ route('login') }}">Login</a>
            @else
                <a>Account</a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endguest           
            </div>
        </div>
    </div>
    @show

    <div class="content">
        <div class="contentNavi">
            @yield('navi')
        </div>

        @section('calendar')
        <div class="calendar">
            <i class="fa-solid fa-arrow-left arrow" id="back"></i>
            <h2>
                July <sup>2023</sup>
            </h2>
            <i class="fa-solid fa-arrow-right arrow" id="next"></i>
        </div>
        @show

        <div class="panel">
            @section('cost')
            <div class="cost">1800 PLN</div>
            @show

            <div class="data">
                @yield('content')
            </div>

        </div>
</body>

</html>