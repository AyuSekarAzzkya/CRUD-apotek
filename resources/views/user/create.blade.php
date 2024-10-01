@extends('template.app')
@section('content')

<div class="container mt-5">
    <form action="{{ route('user.store') }}" method="POST" class="card p-5">
        @csrf
        
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama :</label>
            <div class="col-sm-10">
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email :</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Tipe Pengguna :</label>
            <div class="col-sm-10">
                <select name="role" id="role" class="form-select" required>
                    <option selected disabled hidden>Pilih</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Tambah Data</button>
        <a href="{{ route('user.index') }}" class="btn btn-danger mt-3">Kembali</a>
    </form>
</div>

@endsection
