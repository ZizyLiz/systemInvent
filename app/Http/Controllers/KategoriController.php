<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Kategori::all();
        $no = 0;
        return view('categories.index', compact('categories', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $value = ['A', 'M', 'BHP', 'BTHP'];
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
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        //
    }
}
