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
            $categories = DB::table('category')->select('id','description', DB::raw('namakategori(category) as category'))->where('id','like','%'.$request->search.'%')
            ->orWhere('description','like','%'.$request->search.'%')
            ->orWhere( DB::raw('namakategori(category)'),'like','%'.$request->search.'%')
            ->orderByDesc('id')
            ->paginate(10);
        }else{
            $categories = DB::table('category')->select('id', 'description', DB::raw('namakategori(category) as category'))->latest()->paginate();
            return view('categories.index', compact('categories', 'no'));
        }
        return view('categories.index', compact('categories', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $value = [
            'A' => 'ALAT',
            'M' => 'MODAL',
            'BHP' => 'BAHAN HABIS PAKAI',
            'BTHP' => 'BAHAN TIDAK HABIS PAKAI'
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

        DB::beginTransaction();
        try{
            $category = new Kategori();
            $category->category = $request->category;
            $category->description = $request->description;
            $category->save();

            DB::commit();
            return redirect()->route('categories.index')->with(['success' => 'mantap']);
        }
        catch(\Exception $e){
            DB::rollBack();
            return back()->with(['error' => $e->getMessage()])->withInput();
        }
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

        DB::beginTransaction();
        try{
            $category = Kategori::findOrFail($id);
            $category->Update($request->all());
            DB::commit();
            return redirect()->route('categories.index')->with(['success' => 'BERHASIL DIUBAH']);
        }
        catch(\Exception $e){
            return back()->with(['error'=>$e->getMessage()])->withInput();
        }
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
