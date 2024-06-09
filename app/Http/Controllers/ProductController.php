<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate();
        // dd($products);
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
        $request->validate([
            'title' => 'required|min:3',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:3096',
            'description' => 'required|string|min:3',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category' => 'required|numeric'
        ]);

        $desc = strip_tags($request->description);

        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        Product::create([
            'title' => $request->title,
            'image' => $image->hashName(),
            'description' => $desc,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category
        ]);
    
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
        $request->validate([
            'title' => 'required|min:3',
            'image' => 'image|mimes:jpg,jpeg,png|max:3096',
            'description' => 'required|min:3',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category' => 'required|numeric'
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
                'category' => $request->category
            ]);
            
        } else {
            $product->update([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'category' => $request->category

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

        Storage::delete('public/products/'.$product->image);

        $product->delete();

        return redirect()->route('products.index')->with(['success'=>'anjay']);
    }
}
