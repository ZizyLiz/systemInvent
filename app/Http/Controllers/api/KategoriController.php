<?php

namespace App\Http\Controllers\api;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Kategori::all();
        $data = array('data'=>$category);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|in:A,M,BHP,BTHP',
            'description' => 'required|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $category = Kategori::create([
            'category' => $request->category,
            'description' => $request->description,
        ]);

        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Kategori::find($id);
        if(is_null($category)){
            return response()->json(['message' => 'Record not found'], 404);
        }
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|in:A,M,BHP,BTHP',
            'description' => 'required|max:255',
        ]);

        $category = Kategori::find($id);
        if(is_null($category)){
            return response()->json(['message' => 'Record not found'], 404);
        } else {
            $category->update($request->all());
            return response()->json($category);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Kategori::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Record deleted']);
    }
}
