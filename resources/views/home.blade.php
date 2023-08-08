@extends('layouts.master')

@section('navi')
<a id="all" class="homeNavi selected">All</a>
<a id="incoming" class="homeNavi">Incoming payments</a>
<a id="paid" class="homeNavi">Paid</a>
@stop

@section('content')
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

<div class="dataBlock">
    <div>
        <i>i</i>
        <div>
            Title <br>
            01.08.2023
        </div>
    </div>
    <div>
        <i>i</i>
        email
    </div>
    <div>
        <span class="btn">Paid</span>
        <div class="date">
            01.08.2023
        </div>
    </div>
    <div class="last">
        <div class="price">550</div>
        <i>i</i>
    </div>
    <div class="mailBlock">
        <i class="exit">X</i>
        <p>
            <i>From:</i>
            retail@ikea.pl
        </p>
        <p>
            <i>Attachments:</i>
            XXX.pdf
        </p>
        <i>Content:</i>
        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sed ratione, incidunt tempore quas vel quia dolor! Delectus nesciunt quibusdam excepturi earum sit? Excepturi beatae alias dolores odio voluptatem ipsum facilis?
    </div>
</div>

<div class="dataBlock">
    <div>
        <i>i</i>
        <div>
            Title <br>
            01.08.2023
        </div>
    </div>
    <div>
        <i>i</i>
        email
    </div>
    <div>
        <span class="btn unpaid">Unpaid</span>
        <div class="date">
            08.01.2023 <br>
        </div>
    </div>
    <div class="last">
        <div class="price">550</div>
        <i>i</i>
    </div>
    <div class="mailBlock">
        <i class="exit">X</i>
        <p>
            <i>From:</i>
            retail@ikea.pl
        </p>
        <p>
            <i>Attachments:</i>
            XXX.pdf
        </p>
        <i>Content:</i>
        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sed ratione, incidunt tempore quas vel quia dolor! Delectus nesciunt quibusdam excepturi earum sit? Excepturi beatae alias dolores odio voluptatem ipsum facilis?
    </div>
</div>
</div>

<div class="operations">
    <button class="all btn">Send all documents <i class="fa-solid fa-play"></i></button>
    <i class="incoming cost off"></i>
    <button class="incoming btn off">Pay all <i class="fa-brands fa-google-pay"></i></button>
    <button class="paid btn off doc">Add document <i class="fa-solid fa-file-circle-plus"></i></button>
    <button class="paid btn off">Scan receipts <i class="fa-solid fa-file-lines"></i></button>
</div>

@stop