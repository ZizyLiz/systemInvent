<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductsIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productsIn = ProductsIn::latest()->paginate();
        // dd($productsIn);
        return view('productsIn.index', compact('productsIn'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = Product::all('id','title');
        return view('productsIn.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'tgl_masuk' => 'required',
            'qty_masuk' => 'required',
            'product_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else{
            ProductsIn::create($request->all());
            return redirect()->route('productsIn.index')->with(['success' => 'Data berhasil disimpan']);
        }
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
        $product = Product::all();
        return view('productsIn.edit', compact('product'));
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
