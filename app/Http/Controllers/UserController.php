<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::simplePaginate(5);
        return view('user.index', compact('users'));
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

        $name = $request->input('name');
        $email = $request->input('email');

        $password = substr($name, 0, 3) . substr($email, 0, 3);

        User::create([
            'name' => $name,
            'email' => $email,
            'password' =>Hash::make($password),
            'role' => $request->input('role'),
        ]);

        return redirect()->route('user.index')->with('success', 'Berhasil pengguna telah ditambahkan.');
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
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
          
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
        return redirect()->route('user.index')->with('success', 'Berhasil mengedit data pengguna');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', $id)->delete();

        if ($user) {
            return redirect()->back()->with('success', 'Berhasil menghapus data pengguna!');
        } else {
            return redirect()->back()->with('failed', 'Tidak menghapus data pengguna!');
        }
    }

    public function login()
    {
        return view('login');
    }


    public function loginAuth(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $user = $request->only(['email', 'password']); // meminta untuk emngambil data email dan password dan di simpan di array 
        if(Auth::attempt($user)){  // akan memeverifikasi apakah email dan password sesuai, jika iya maka history login akan disimpan kedalam auth
            return redirect()->route('home.page'); // jika berhasil akan di arahkan ke halaman home
        }else{
            return redirect()->back()->with('failed', 'Proses login gagal, silahkan coba kembali dengan data yang benar!');
        }
    }

    public function logout()
    {
        Auth::logout(); // semua data yg ada di auth setelah di logout akan menghapus history nya
        return redirect()->route('login')->with('logout', 'Anda telah logout !');
    }
}

