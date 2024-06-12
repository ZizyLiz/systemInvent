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
    public function index(Request $request)
    {
        if($request->search){
            $productsOut = DB::table('products_out')
            ->leftJoin('product', 'product.id', '=', 'products_out.product_id')
            ->select('products_out.id', 'products_out.tgl_keluar', 'products_out.qty_keluar', 'products_out.product_id', 'product.title')
            ->where('products_out.id', 'like', '%'.$request->search.'%')
            ->orWhere('products_out.tgl_keluar', 'like', '%'.$request->search.'%')
            ->orWhere('product.title','like','%'.$request->search.'%')
            ->orderByDesc('products_out.id')
            ->paginate(5);
        } else{
            $productsOut = DB::table('products_out')
            ->leftJoin('product', 'product.id', '=', 'products_out.product_id')
            ->select('products_out.id', 'products_out.tgl_keluar', 'products_out.qty_keluar', 'products_out.product_id', 'product.title')
            ->orderByDesc('products_out.id')
            ->paginate(5);
        }
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
        $sisaStock = Product::findOrFail($request->product_id)->stock;
        $validate = $request->validate( [
            'tgl_keluar' => ['required', 'date', $barangMasuk ? 'after:' . $barangMasuk->tgl_masuk : ''],
            'qty_keluar' => ['required','numeric', 'min:0', 'max:'.$sisaStock ],
            'product_id' => ['required', 'numeric', 'exists:products_in,product_id'],
        ],[
            'required' => 'This field is required',
            'min' => 'Value minimal :min',
            'after' => 'tanggal mu salah gobloug',
            'exists' => 'tambah barang masuk dulu',
            'max' => 'Kebanyakan dawg'
        ]);

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
        $barangMasuk = ProductsIn::where('product_id', $request->id)->latest()->first();
        $sisaStock = Product::findOrFail($request->product_id)->stock;
        $validator = Validator::make($request->all(), [
            'tgl_keluar' => ['required', 'date', $barangMasuk ? 'after:' . $barangMasuk->tgl_masuk : ''],
            'qty_keluar' => ['required', 'numeric', 'max:'.$sisaStock],
            'product_id' => ['required', 'numeric', 'exists:products_in,product_id'],
        ],[
            'required' => 'This field is required',
            'min' => 'Value minimal :min',
            'after' => 'tanggal mu salah gobloug',
            'exists' => 'tambah barang masuk dulu',
            'max' => 'Kebanyakan dawg'
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
