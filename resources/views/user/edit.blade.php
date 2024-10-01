@extends('template.app')

@section('content')

<div class="container mt-5">
    <form action="{{ route('user.update', $user->id) }}" method="POST" class="card p-5">
        @csrf
        @method('PUT')

        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama :</label>
            <div class="col-sm-10">
                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email :</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Tipe Pengguna :</label>
            <div class="col-sm-10">
                <select name="role" id="role" class="form-select" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">Password Baru :</label>
            <div class="col-sm-10">
                <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Perbarui Data</button>
        <a href="{{ route('user.index') }}" class="btn btn-danger mt-3">Kembali</a>
    </form>
</div>

@endsection
