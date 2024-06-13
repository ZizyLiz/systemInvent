@extends('layout.createLay')
@section('content')
    <div class="title">
        <h1 class="text-center mt-5">Edit Barang Keluar</h1>
    </div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('productsOut.update', $productOut->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="" class="font-weight-bold">DATE</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    name="tgl_keluar" value="{{ date('Y-m-d') }}">

                                @error('date')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="" class="font-weight-bold">Product</label>
                                <select name="product_id" class="form-control">
                                    @foreach ($product as $item)
                                        <option value="{{ $item->id }}" @selected(old('product_id', $productOut) == $item->id)>{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="" class="font-weight-bold">QUANTITY</label>
                                <input type="number" name="qty_keluar" class="form-control @error('quantity') is-invalid @enderror"  value="{{old('qty_keluar', $productOut->qty_keluar)}}" placeholder="Masukkan Jumlah Product">
                                @error('qty_keluar')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>

                            <button type="submit" class="btn btn-md btn-primary me-3">UPDATE</button>
                            <button type="submit" class="btn btn-md btn-warning">RESET</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
