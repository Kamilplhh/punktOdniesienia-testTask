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
        <div>
            01.08.2023
        </div>
    </div>
    <div>
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
        <div>
            01.08.2023 <br>
            <h6 class="late">exceeded 3 days</h6>
        </div>
    </div>
    <div>
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
    test
    <button class="all btn">Send all documents -></button>
</div>

@stop