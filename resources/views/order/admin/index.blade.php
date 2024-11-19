@extends('template.app')

@section('content')
    <div class="my-5 d-flex justify-content-end">
        <a href="{{ route('order.export-excel') }}" class="btn btn-primary">Export Data (Excel)</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Pembeli</th>
                <th>Obat</th>
                <th>Kasir</th>
                <th>Tanggal Pembelian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->index + 1 }}</td>
                    <td>{{ $order->name_customor }}</td>
                    <td>
                        @if(is_array($order->medicines) && count($order->medicines) > 0)
                            <ol>
                                @foreach ($order->medicines as $medicine)
                                    <li>
                                        {{ $medicine['name_medicine'] }} (Rp. {{ number_format($medicine['price'], 0, ',', '.') }}) :
                                        Rp. {{ number_format($medicine['sub_price'], 0, ',', '.') }}
                                        <small>qty {{ $medicine['qty'] }}</small>
                                    </li>
                                @endforeach
                            </ol>
                        @else
                            <p>Tidak ada obat yang ditambahkan.</p>
                        @endif
                    </td>
                    <td>{{ $order->user->name }}</td>
                    @php
                        \Carbon\Carbon::setLocale('id');
                    @endphp
                    <td>{{ \Carbon\Carbon::parse($order->created_at)->isoFormat('D MMMM YYYY') }}</td>
                    <td>
                        <a href="{{ route('download', $order->id) }}" class="btn btn-secondary">Unduh (.pdf)</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
    