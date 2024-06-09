<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\ProductsIn;
use Illuminate\Http\Request;

class ProductsInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productsIn = ProductsIn::all();
        // dd($productsIn);
        return view('productsIn.index', compact('productsIn'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Kategori::all();
        return view('productsIn.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productIn = ProductsIn::findOrFail($id);
        return view('productsIn.show',compact('productIn'));        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductsIn $productsIn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductsIn $productsIn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){
        $productIn = ProductsIn::findOrFail($id);
        if(is_null($productIn)){
            return redirect()->route('productsIn.index')->with(['error' => 'Data tidak ditemukan']);
        } else{
            $productIn->delete();
            return redirect()->route('productsIn.index')->with(['success' => 'Data berhasil dihapus']);
        }
    }
}
