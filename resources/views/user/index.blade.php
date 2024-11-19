@extends('template.app')

@section('content')
    <div class="container mt-5">
        <h1>Daftar Akun</h1>

        @if (session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mb-3">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('user.create') }}" class="btn btn-secondary mb-3 float-end">Tambah Pengguna</a>

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                {{-- untuk melakukan iterasi (looping) pada koleksi $users, di mana setiap elemen disimpan dalam variabel $user dan indeksnya dalam variabel $index --}}
                    <tr>
                        <td>{{ ($users->currentPage()-1) * $users->perPage() + ($index + 1) }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" onclick="showModalDelete({{ $user->id }}, '{{ $user->name }}')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3 float-end">
            {{ $users->links() }} 
        </div>

        <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Akun</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus data pengguna <b id="name-akun"></b>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function showModalDelete(id, name) {
            $("#name-akun").text(name);
            $("#modalDelete").modal('show');
            let url = "{{ route('user.destroy', ':id') }}";
            url = url.replace(':id', id);
            $('form').attr('action', url);
        }
    </script>
@endpush
