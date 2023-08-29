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
        <a class="download" href="{{url('uploads/file/'. $file->file)}}" download>
            @if(substr($file->file, -3) == "pdf")
            <i class="fa-solid fa-file-pdf"></i>
            @else
            <i class="fa-solid fa-image"></i>
            @endif
        </a>
        <div>
            {{ $file->title }} <br>
            <i class="fileDate">{{ date('m-d-Y',strtotime($file->created_at)) }}</i>
        </div>
    </div>
    @if(!empty($file->email))
    <div>
        <i class="fa-solid fa-eye" id="{{ $file->id }}"></i>
        {{ $file->email }}
    </div>
    <div class="mailBlock off" id="{{ 'mailBlock' . $file->id }}">
        <i class="exit">X</i>
        <p>
            <i>From:</i>
            {{ $file->email }}
        </p>
        <p>
            <i>Attachments:</i>
            <a class="download" href="{{url('uploads/file/'. $file->file)}}" download>
                {{ $file->file}}
            </a>
        </p>
        <i>Content:</i>
        {{ $file->content }}
    </div>
    @endif
    <div>
        @if($file->paid == 0)
        <span class="btn unpaid">Unpaid</span>
        @else
        <span class="btn paid">Paid</span>
        @endif
        <div class="date">
            {{ date('m-d-Y',strtotime($file->paymentDate)) }}
        </div>
    </div>
    <div class="last">
        <div class="price">{{ $file->price }}</div>
        @if(isset($file->bank) && $file->paid == 0)
        <i class="fa-regular fa-credit-card credit" id="{{ $file->id }}" value="{{ $file->bank }}"></i>
        <div class="off">
            <input type="hidden" class="bankI" id="{{'bank' . $file->id}}" value="{{ $file->bank }}">
            <input type="hidden" class="nameI" id="{{'name' . $file->id}}" value="{{ $file->recipient }}">
            <input type="hidden" class="emailI" id="{{'email' . $file->id}}" value="{{ Auth::user()->email }}">
        </div>
        @endif
    </div>
</div>
@endforeach
</div>

<div class="operations">
    <button class="btn">Send all documents <i class="fa-solid fa-play"></i></button>
</div>

<div class="document block off">
    <form enctype="multipart/form-data" method="POST" action="{{ route('scanUpload') }}">
        @csrf
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>

        <label for="fileScan">File:</label>
        <input type="file" id="fileScan" name="fileScan" required><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" min="0" step="0.01" required><br>

        <label for="bank">Bank:</label>
        <input type="number" id="bank" name="bank" min="0" required><br>

        <label for="nip">NIP:</label>
        <input type="number" id="nip" name="nip" min="0" required><br>

        <label for="invoice_number">Invoice number:</label>
        <input type="text" id="invoice_number" name="invoice_number" required><br>

        <label for="date">Date of payment:</label>
        <input type="date" id="date" name="date" required><br>

        <label for="adress">Adress:</label>
        <input type="text" id="adress" name="adress" required><br>

        <label for="recipient">Recipient:</label>
        <input type="text" id="recipient" name="recipient" required><br>

        <label for="paid">Paid:</label>
        <input type="checkbox" id="paid" name="paid" value="0"><br>

        <center><button class="doc btn" type="submit">Add document <i class="fa-solid fa-file-circle-plus"></i></button></center>
    </form>
</div>

<div class="scan block off">
    <form enctype="multipart/form-data" method="POST" action="{{ route('pdfUpload') }}">
        @csrf
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>

        <label for="file">File:</label>
        <input type="file" id="fileScan" name="fileScan" required><br>

        <label for="adress">Adress:</label>
        <input type="text" id="adress" name="adress" required><br>

        <label for="recipient">Recipient:</label>
        <input type="text" id="recipient" name="recipient" required><br>

        <label for="paid">Paid:</label>
        <input type="checkbox" id="paid" name="paid"><br>

        <p class="border"></p>
        <h5>In case when scanner is not working</h5><br>

        <label for="bank">Bank:</label>
        <input type="number" id="bank" name="bank" min="0"><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" min="0" step="0.01"><br>

        <label for="nip">NIP:</label>
        <input type="number" id="nip" name="nip" min="0"><br>

        <label for="invoice_number">Invoice number:</label>
        <input type="text" id="invoice_number" name="invoice_number"><br>

        <label for="date">Date of payment:</label>
        <input type="date" id="date" name="date"><br>
        <p class="border"></p>

        <center><button class="doc btn" type="submit">Scan receipts <i class="fa-solid fa-file-lines"></i></button></center>
    </form>
</div>

@stop