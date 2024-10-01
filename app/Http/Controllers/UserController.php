<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all(); // Mengambil semua pengguna
        return view('user.index', compact('users')); // Mengirimkan variabel ke tampilan
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string',
        ]);

        // Ambil 3 karakter pertama dari nama dan email
        $name = $request->input('name');
        $email = $request->input('email');
        
        // Membuat password
        $password = substr($name, 0, 3) . substr($email, 0, 3);

        // Buat pengguna baru
        User::create([
            'name' => $name,
            'email' => $email,
            'password' =>Hash::make($password), // Hash password sebelum menyimpan
            'role' => $request->input('role'),
        ]);

        // Redirect atau kembali dengan pesan
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id); // Mencari pengguna berdasarkan ID
        return view('user.edit', compact('user')); // Mengembalikan tampilan edit
          
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
          $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|in:admin,user',
            'password' => 'nullable|string|min:8',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->route('user.index')->with('success', 'User telah di edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id); // Mencari pengguna berdasarkan ID
        $user->delete(); // Menghapus pengguna

        // Redirect atau kembali dengan pesan
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}

