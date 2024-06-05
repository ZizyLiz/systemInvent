@extends('layout.master')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <a href="{{ route('categories.create') }}" class="btn btn-md btn-success mb-3">ADD CATEGORY</a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Description</th>
                                <th scope="col" style="width: 20%">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $cat)
                                <tr>
                                    <td class="text-center">{{$no+=1}}</td>
                                    <td class="text-center">{{ $cat->category }}</td>
                                    <td class="text-center">{{ $cat->description}}</td>
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