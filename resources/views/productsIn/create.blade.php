<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Products - SantriKoding.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">
    <div class="title">
        <h1 class="text-center mt-5">Create Barang Masuk</h1>
    </div>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('productsIn.store') }}" method="POST" enctype="multipart/form-data">                        
                            @csrf
                            
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Date</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" name="tgl_masuk" value="{{ date('Y-m-d') }}" @readonly(true)>
                            
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
                                    <option value="">--Pilih--</option>
                                    @foreach ($product as $v)
                                        <option value="{{$v->id}}">{{$v->title}}</option>
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
                                <input type="number" class="form-control @error('stock') is-invalid @enderror" name="qty_masuk" value="{{ old('stock') }}" placeholder="Masukkan Stock Product">
                            
                                <!-- error message untuk stock -->
                                @error('stock')
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
</body>
</html>