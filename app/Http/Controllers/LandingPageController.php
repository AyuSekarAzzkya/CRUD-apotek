<?php

namespace App\Http\Controllers;

use App\Models\medicines;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    //mengambil banyak data/menampilkan halaman awal ( CRUD = R )
    public function index()
    {
        //proses pemanggilan blade
        // file yg ada di dalam folder NAMAFOLDER   .namafile
        return view('landing-page');
    }

    // Membuat halaman tambah data C dalam CRUD
    public function create()
    {
        //
    }

    // memproses penambahan data ke database
    public function store(Request $request)
    {
        
    }

    // menampilkan detail dari satu data
    public function show(string $id)
    {
        //
    }

    // menampilkan halaman untuk edit data
    public function edit(string $id)
    {
        //
    }

    // memproses mengubah data ke database U dalam CRUD
    public function update(Request $request, string $id)
    {
        //
    }

    // menghapus data di database D dalam CRUD
    public function destroy(string $id)
    {
        //
    }
}
