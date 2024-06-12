<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductsIn;
use App\Models\ProductsOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductsOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productsOut = ProductsOut::all();
        return view('productsOut.index', compact('productsOut'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = Product::all('id', 'title');
        return view('productsOut.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $barangMasuk = ProductsIn::where('product_id', $request->product_id)->latest()->first();
        $validate = Validator::make(($request->all()), [
            'tgl_keluar' => ['required', 'date', $barangMasuk ? 'after:' . $barangMasuk->tgl_masuk : $barangMasuk->tgl_masuk],
            'qty_keluar' => ['required'],
            'product_id' => ['required', 'numeric'],
        ],[
            'after' => 'tanggal mu salah gobloug'
        ]);
        
        if($validate->fails()){
            return back()->withErrors($validate)->withInput();
        }
        DB::beginTransaction();
        try{
            $product = new ProductsOut();
            $product->tgl_keluar = $request->tgl_keluar;
            $product->qty_keluar = $request->qty_keluar;
            $product->product_id = $request->product_id;
            $product->save();

            DB::commit();

            return redirect()->route('productsOut.index')->with(['success'=> 'Entry Berhasil Ditambahkan']);
        }
        catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $productOut = ProductsOut::findOrFail($id);
        return view('productsOut.show', compact('productOut'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $productOut = ProductsOut::findOrFail($id);
        $product = Product::all('id', 'title');
        return view('productsOut.edit', compact('productOut', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'tgl_keluar' => ['required', 'date'],
            'qty_keluar' => ['required', 'numeric'],
            'product_id' => ['required', 'numeric'],
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try{
            $productOut = ProductsOut::findOrFail($id);
            $productOut->update($request->all());
            DB::commit();
            return redirect()->route('productsOut.index')->with(['success' => "Data berhasil diubah"]);
        }
        catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productOut = ProductsOut::findOrFail($id);
        $productOut->delete();
        return redirect()->route('productsOut.index')->with(['success' => 'Data berhasil dihapus']);
    }
}
