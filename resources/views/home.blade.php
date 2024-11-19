@extends('template.app')
{{-- extend : import file blade --}}
@section('content')

    <div class="jumbotron py-4 px-5">
        @if (Session::get('failed'))
            <div class="alert alert-danger">
                {{ Session::get('failed') }}
            </div>
        @endif
    </div>
    {{-- section : mengisi @yield file yang di import --}}
    <h1 class="mt-3">Selamat Datang {{ Auth::user()->name }}!</h1>
    <hr>
    <p>Aplikasi ini digunakan hanya oleh pegawai administrator APOTEK. Digunakan untuk mengelola data obat, penyetokan, juga
        pembelian (kasir)</p>
@endsection
