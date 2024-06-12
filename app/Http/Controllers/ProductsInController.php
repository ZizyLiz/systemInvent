<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductsIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductsInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->search) {
            $productsIn = DB::table('products_in')
                ->leftJoin('product', 'product.id', '=', 'products_in.product_id')
                ->select('products_in.id','products_in.tgl_masuk', 'products_in.qty_masuk', 'products_in.product_id', 'product.title')
                ->where('products_in.id', 'like', '%' . $request->search . '%')
                ->orWhere('products_in.tgl_masuk', 'like', '%' . $request->search . '%')
                ->orWhere('product.title', 'like', '%' . $request->search . '%')
                ->orderByDesc('products_in.id')
                ->paginate(5);
        } else {
            $productsIn = DB::table('products_in')
            ->leftJoin('product', 'product.id', '=', 'products_in.product_id')
            ->select('products_in.id','products_in.tgl_masuk', 'products_in.qty_masuk', 'products_in.product_id', 'product.title')
            ->orderByDesc('products_in.id')
            ->paginate(5);
        }
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
        $validator = $request->validate([
            'tgl_masuk' => ['required', 'date'],
            'qty_masuk' => ['required', 'numeric', 'min:1'],
            'product_id' => ['required', 'numeric']
        ]);

        DB::beginTransaction();
        try{
            $productIn = new ProductsIn();
            $productIn->tgl_masuk = $request->tgl_masuk;
            $productIn->qty_masuk = $request->qty_masuk;
            $productIn->product_id = $request->product_id;
            $productIn->save();

            DB::commit();
            return redirect()->route('productsIn.index')->with(['success'=>'Berhasil menambahkan data']);
        }
        catch(\Exception $e){
            DB::rollBack();
            return back()->with(['error'=>$e->getMessage()])->withInput();
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
    public function edit(string $id)
    {
        $product = Product::all('id','title');
        $productIn = ProductsIn::findOrFail($id);
        return view('productsIn.edit', compact('product', 'productIn'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = $request->validate([
            'tgl_masuk' => 'required',
            'qty_masuk' => 'required',
            'product_id' => 'required',
        ]);

        DB::beginTransaction();
        try{
            $productIn = ProductsIn::findOrFail($id);
            $productIn->update($request->all());
            DB::commit();
            return redirect()->route('productsIn.index')->with(['success' => 'Entry Berhasil Diubah']);
        } 
        catch(\Exception $e){
            DB::rollBack();
            return back()->with(['error' => $e->getMessage()])->withInput();
        }
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
