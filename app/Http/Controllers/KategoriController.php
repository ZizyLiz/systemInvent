<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $no = 0;
        if ($request->search){
            $categories = DB::table('category')->select('id','description','category')->where('id','like','%'.$request->search.'%')
            ->orWhere('description','like','%'.$request->search.'%')
            ->orWhere('category','like','%'.$request->search.'%')
            ->paginate(10);
        }else{
            $categories = Kategori::all();
            return view('categories.index', compact('categories', 'no'));
        }
        return view('categories.index',compact('categories', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $value = [
            'A' => 'ALAT',
            'M' => 'MODAL',
            'BHP' => 'BARANG HABIS PAKAI',
            'BTHP' => 'BARANG TIDAK HABIS PAKAI'
        ];
        return view('categories.create',compact('value'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => ['required',Rule::in(['A', 'M', 'BHP', 'BTHP'])],
            'description' => ['required']
        ]);

        Kategori::create($request->all());
        
        return redirect()->route('categories.index')->with(['success' => 'mantap']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori, string $id)
    {
        $category = Kategori::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori, string $id)
    {
        $category = Kategori::findOrFail($id);
        $value = ['A', 'M', 'BHP', 'BTHP'];
        return view('categories.edit', compact('category', 'value'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => ['required',Rule::in(['A', 'M', 'BHP', 'BTHP'])],
            'description' => ['required']
        ]);

        $category = Kategori::findOrFail($id);

        $category->update($request->all());
        return redirect()->route('categories.index')->with(['success' => 'mantap']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori, string $id)
    {
        $category = Kategori::findOrFail($id);
        try {
            $category->delete();
            return redirect()->route('categories.index')->with(['success' => 'ilang']);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = $e->getMessage();
            return redirect()->route('categories.index')->with(['error' => $errorMessage]);
        }
    }
}
