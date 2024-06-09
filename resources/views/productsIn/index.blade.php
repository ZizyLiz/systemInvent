@extends('layout.master')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <a href="{{ route('productsIn.create') }}" class="btn btn-md btn-success mb-3">ADD PRODUCT</a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">DATE</th>
                                <th scope="col">PRODUCT</th>
                                <th scope="col">QUANTITY</th>
                                <th scope="col" style="width: 20%">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($productsIn as $product)
                                <tr>
                                    <td class="align-middle">{{ $product->tgl_masuk }}</td>
                                    <td class="align-middle">{{ $product->product->title }}</td>
                                    <td class="align-middle">{{ $product->qty_masuk }}</td>
                                    <td class="text-center align-middle">
                                        <form onsubmit="return deleteData(this)" action="{{ route('productsIn.destroy', $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('productsIn.show', $product->id) }}" class="btn btn-sm btn-dark">SHOW</a>
                                            <a href="{{ route('productsIn.edit', $product->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                            <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <div class="alert alert-danger">
                                    Data Products belum Tersedia.
                                </div>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection