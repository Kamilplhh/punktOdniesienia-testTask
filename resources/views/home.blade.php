@extends('layouts.master')
@vite('resources/js/home.js')

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
<h6 class="off" id="noFiles">There are no files in this month</h6>

@foreach($files as $file)
<div class="dataBlock off">
    <div>
        @if(substr($file->file, -3) == "pdf")
        <i class="fa-solid fa-file-pdf"></i>
        @else
        <i class="fa-solid fa-image"></i>
        @endif
        <div>
            {{ $file->title }} <br>
            <i class="fileDate">{{ date('m-d-Y',strtotime($file->created_at)) }}</i>
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
            {{ date('m-d-Y',strtotime($file->created_at)) }}
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


</div>

<div class="operations">
    <button class="btn">Send all documents <i class="fa-solid fa-play"></i></button>
</div>

@stop