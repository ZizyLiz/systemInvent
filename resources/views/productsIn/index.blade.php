@extends('layout.master')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('productsIn.create') }}" class="btn btn-md btn-success mb-3">ADD PRODUCT
                                    IN</a>
                            </div>
                            <div class="col-md-6 text-end">
                                <form action="/productsIn" method="GET"
                                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2"
                                            value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                                        <td class="align-middle">{{ $product->title }}</td>
                                        <td class="align-middle">{{ $product->qty_masuk }}</td>
                                        <td class="text-center align-middle">
                                            <form onsubmit="return deleteData(this)"
                                                action="{{ route('productsIn.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('productsIn.show', $product->id) }}"
                                                    class="btn btn-sm btn-dark">SHOW</a>
                                                <a href="{{ route('productsIn.edit', $product->id) }}"
                                                    class="btn btn-sm btn-primary">EDIT</a>
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
