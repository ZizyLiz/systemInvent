@extends('layout.createLay')
@section('content')
    <div class="title">
        <h1 class="text-center mt-5">Create Barang Keluar</h1>
    </div>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('productsOut.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Date</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    name="tgl_keluar" value="{{ old('tgl_keluar', date('Y-m-d')) }}" @readonly(false)>

                                <!-- error message untuk date -->
                                @error('tgl_keluar')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Product</label>
                                <select class="form-control" name="product_id" aria-label="Default select example">
                                    @foreach ($product as $item)
                                        <option value="{{ $item->id }}" {{old('product_id') == $item->id ? 'selected' : ''}}>{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">QUANTITY</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                    name="qty_keluar" value="{{ old('qty_keluar') }}" placeholder="Masukkan Stock Product">

                                <!-- error message untuk quantity -->
                                @error('qty_keluar')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-md btn-primary me-3">SAVE</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
