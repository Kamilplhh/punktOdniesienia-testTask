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

@if(count($files) == 0)
<center>
    <h6>There are no files in this month</h6>
</center>
@else
@foreach($files as $file)
<div class="dataBlock">
    <div>
        @if(substr($file->file, -3) == "jpg")
        <i class="fa-solid fa-image"></i>
        @else
        <i class="fa-solid fa-file-pdf"></i>
        @endif
        <div>
            {{ $file->title }} <br>
            {{ date('d-m-Y',strtotime($file->created_at)) }}
        </div>
    </div>
    @if(!empty($file->email))
    <div>
        <i class="fa-solid fa-eye"></i>
        {{ $file->email }}
    </div>
    <div class="mailBlock off">
        <i class="exit">X</i>
        <p>
            <i>From:</i>
            {{ $file->email }}
        </p>
        <p>
            <i>Attachments:</i>
            {{ $file->file}}
        </p>
        <i>Content:</i>
        {{ $file->content }}
    </div>
    @endif
    <div>
        @if($file->paid == 0)
        <span class="btn unpaid">Unpaid</span>
        @else
        <span class="btn">Paid</span>
        @endif
        <div class="date">
            {{ date('d-m-Y',strtotime($file->date)) }}
        </div>
    </div>
    <div class="last">
        <div class="price">{{ $file->price }}</div>
        @if(isset($file->bank) && $file->paid == 0)
        <i class="fa-regular fa-credit-card"></i>
        <input type="hidden" name="bank" value="{{ $file->bank }}">
        @endif
    </div>
</div>
@endforeach
@endif

</div>

<div class="operations">
    <button class="all btn">Send all documents <i class="fa-solid fa-play"></i></button>
    <i class="incoming cost off"></i>
    <button class="incoming btn off">Pay all <i class="fa-brands fa-google-pay"></i></button>
    <button class="paid btn off doc">Add document <i class="fa-solid fa-file-circle-plus"></i></button>
    <button class="paid btn off">Scan receipts <i class="fa-solid fa-file-lines"></i></button>
</div>

@stop