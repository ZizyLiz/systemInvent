@extends('layout.master')
@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <img src="{{ asset('/storage/products/'.$productIn->product->image) }}" class="rounded" style="width: 100%">
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <h3>{{ $productIn->product->title }}</h3>
                        <hr/>
                        <p>{{ $productIn->tgl_masuk }}</p>
                        <hr/>
                        <p>Quantity : {{ $productIn->qty_masuk }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection