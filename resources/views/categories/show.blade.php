@extends('layout.master')
@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-4 my-auto">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <h1>KATEGORI</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <h3>{{$category->category}}</h3>
                        <hr/>   
                        <code>
                            <p>{!! $category->description !!}</p>
                        </code>
                        <hr/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection