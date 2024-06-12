@extends('layout.master')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('categories.create') }}" class="btn btn-md btn-success mb-3">ADD CATEGORY</a>
                        </div>
                        <div class="col-md-6 text-end">
                            <form action="/categories" method="GET"
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
                                <th style="width: 5%">No</th>
                                <th scope="col">Description</th>
                                <th scope="col">Kategori</th>
                                <th scope="col" style="width: 20%">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{dd($categories)}} --}}
                            @forelse ($categories as $cat)
                                <tr>
                                    <td class="text-center">{{$no+=1}}</td>
                                    <td class="text-center">{{ $cat->description}}</td>
                                    <td class="text-center">{{ $cat->category }}</td>
                                    <td class="text-center">
                                        <form onsubmit="return deleteData(this);" action="{{ route('categories.destroy', $cat->id) }}" method="POST">
                                            <a href="{{ route('categories.show', $cat->id) }}" class="btn btn-sm btn-dark">SHOW</a>
                                            <a href="{{ route('categories.edit', $cat->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                            @csrf
                                            @method('DELETE')
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