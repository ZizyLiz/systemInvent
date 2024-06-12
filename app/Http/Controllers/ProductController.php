<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Kategori;
use App\Models\ProductsIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->search) {
            $products = DB::table('product')
                ->leftJoin('category', 'category.id', '=', 'product.category_id')
                ->select('product.id', 'product.image', 'product.title', 'product.description', 'product.price', 'product.stock', 'product.category_id', DB::raw('namaKategori(category.category) as category'))
                ->where('product.id', 'like', '%' . $request->search . '%')
                ->orWhere('product.title', 'like', '%' . $request->search . '%')
                ->orWhere('product.description', 'like', '%' . $request->search . '%')
                ->orWhere(DB::raw('namaKategori(category.category)'), 'like', '%' . $request->search . '%')
                ->orderByDesc('id')
                ->paginate(5);
        } else {
            $products = DB::table('product')->leftJoin('category', 'category.id', '=', 'product.category_id')
            ->select('product.id', 'product.image', 'product.title', 'product.description', 'product.price', 'product.stock', 'product.category_id', DB::raw('namaKategori(category.category) as category'))
            ->orderByDesc('id')
            ->paginate(5);
            return view('products.index', compact('products'));
        }
        return view('products.index', compact('products'));
    

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Kategori::all();
        return view('products.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'title' => 'required|min:3',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:3096',
            'description' => 'required|string|min:3',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'category' => 'required|numeric',
        ], [
            'stock.min' => 'Stock must be POSITIVE VALUE',
            'price.min' => 'Ga bisa negative dawg'
        ]);

        $desc = strip_tags($request->description);

        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        $product = Product::create([
            'title' => $request->title,
            'image' => $image->hashName(),
            'description' => $desc,
            'price' => $request->price,
            'stock' => 0,
            'category_id' => $request->category
        ]);
        
        if($request->stock > 0){
            $productIn = new ProductsIn();
            $productIn->tgl_masuk = now();
            $productIn->qty_masuk = $request->stock;
            $productIn->product_id = $product->id;
            $productIn->save();
        }
    
        return redirect()->route('products.index')->with(['success' => 'pepek']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $category = Kategori::all();
        return view('products.edit', compact('product', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = $request->validate([
            'title' => 'required|min:3',
            'image' => 'image|mimes:jpg,jpeg,png|max:3096',
            'description' => 'required|min:3',
            'price' => 'required|numeric',
            'stock' => 'required|numeric|min:0',
            'category' => 'required|numeric',
        ], [
            'stock.min' => 'Stock must be POSITIVE VALUE'
        ]);

        $product = Product::findOrFail($id);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $image->storeAs('public/products/', $image->hashName());

            Storage::delete('public/storage/'.$product->image);

            $product->update([
                'title' => $request->title,
                'image' => $image->hashName(),
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'category_id' => $request->category
            ]);
            
        } else {
            $product->update([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'category_id' => $request->category

            ]);
        }
        return redirect()->route('products.index')->with(['success'=>'okay']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        try{
            $product->delete();
            Storage::delete('public/products/'.$product->image);
            return redirect()->route('products.index')->with(['success'=>'anjay']);
        }
        catch(\Exception $e){
            return redirect()->back()->with(['error'=>$e->getMessage()]);
        }
    }
}
