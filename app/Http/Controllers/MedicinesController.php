<?php

namespace App\Http\Controllers;

use App\Models\medicines;
use Illuminate\Http\Request;

class MedicinesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $medicines = medicines::all();
       return view('medicine.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicine.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'type' => 'required|min:1',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        medicines::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);
        
        return redirect()->back()->with('success', 'Berhasil Menambahkan Data Obat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(medicines $medicines)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(medicines $medicines, $id)
    {
        $medicines = medicines::find($id);
        return view('medicine.edit', compact('medicines'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'type' => 'required|min:1',
            'price' => 'required|numeric',
        ]);

        medicines::where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
        ]);
        return redirect()->route('medicine.home')->with('success', 'Berhasil mengubah data');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        medicines::where('id', $id)->delete();
        return redirect()->back()->with('delete', 'Berhasil Di Hapus');
    }

    public function stock(){
        $medicines = medicines::orderBy('stock', 'ASC')->get();
        return view('medicine.stock', compact('medicines'));
    }

    public function stockEdit($id){
        $medicines = medicines::find($id);
        return response()->json($medicines);
    }

    public function stockUpdate(Request $request, $id){
       $request->validate([
        'stock' => 'required|numeric',
       ]);
       $medicines = medicines::find($id);
       
       if($request->stock<= $medicines['stock']) {
        return response()->json(["message" => "Stock yang di input tidak boleh kurang dari stock sebelumnya"],400);
       } else {
        $medicines->update(["stock"=>$request->stock]);
        return response()->json("berhasil", 200);
        
       }
    }
}
