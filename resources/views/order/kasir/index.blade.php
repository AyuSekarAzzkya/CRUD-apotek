@extends('template.app')

@section('content')
    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <form class="d-flex" action="{{ route('pembelian') }}" method="GET">
                <input type="date" class="form-control me-2" name="date" placeholder="Tanggal" value="{{ request('date') }}">
                <button type="submit" class="btn btn-success">Cari</button>
            </form>
            
            <div>
                <a href="{{ route('tambah.pembelian') }}" class="btn btn-primary">Pembelian Baru</a>
            </div>
        </div>

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Pembeli</th>
                    <th>Obat</th>
                    <th>Total Bayar</th>
                    <th>Kasir</th>
                    <th>Tanggal Beli</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($orders as $item)  <!-- Gunakan $orders bukan $order -->
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $item['name_customor'] }}</td>
                        <td>
                            @if (is_array($item->medicines) && count($item->medicines) > 0)
                                <ol>
                                    @foreach ($item->medicines as $medicine)
                                        <li>
                                            {{ $medicine['name_medicine'] }} (
                                            {{ number_format($medicine['price'], 0, ',', '.') }} ) :
                                            Rp. {{ number_format($medicine['sub_price'], 0, ',', '.') }}
                                            <small>qty {{ $medicine['qty'] }}</small>
                                        </li>
                                    @endforeach
                                </ol>
                            @else
                                <p>Tidak ada obat ditemukan</p>
                            @endif
                        </td>
                        <td>Rp. {{ number_format($item['total_price'], 0, ',', '.') }}</td>
                        <td>{{ $item['user']['name'] }}</td>
                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                        <td>
                            <div class="d-flex">
                                <form action="{{ route('order.destroy', $item['id']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger me-2" onclick="return confirm('Apakah Anda yakin ingin menghapus order ini?')">Hapus</button>
                                </form>
                                <a href="{{ route('download', $item['id']) }}" class="btn btn-secondary">Download Struk</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            @if ($orders->count()) 
                {{ $orders->links() }}
            @endif
        </div>
    </div>
@endsection
