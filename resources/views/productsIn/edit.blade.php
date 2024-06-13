@extends('layout.createLay')
@section('content')
    <div class="title">
        <h1 class="text-center mt-5">Edit Barang Masuk</h1>
    </div>
    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('productsIn.update', $productIn->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Date</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    name="tgl_masuk" value="{{ date('Y-m-d') }}" @readonly(true)>

                                <!-- error message untuk date -->
                                @error('date')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Product</label>
                                <select class="form-control" name="product_id" aria-label="Default select example">
                                    @foreach ($product as $v)
                                        <option value="{{ $v->id }}" @selected(old('product_id', $productIn) == $v->id)>{{ $v->title }}</option>
                                    @endforeach
                                </select>
                                @error('title')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">QUANTITY</label>
                                <input type="number" class="form-control @error('qty_masuk') is-invalid @enderror"
                                    name="qty_masuk" value="{{ old('qty_masuk', $productIn->qty_masuk) }}"
                                    placeholder="Masukkan Stock Product">

                                <!-- error message untuk qty_masuk -->
                                @error('qty_masuk')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-md btn-primary me-3">UPDATE</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    </body>

    </html>
@endsection
