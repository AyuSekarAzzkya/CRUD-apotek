<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 20px;
        }

        .back-wrap {
            margin: 30px auto 0 auto;
            width: 500px;
            display: flex;
            justify-content: flex-end;
        }

        .btn-back {
            padding: 8px 15px;
            color: white;
            background-color: #666;
            border-radius: 5px;
            text-decoration: none;
        }

        .receipt {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 30px auto;
            width: 500px;
            background-color: #fff;
            border-radius: 8px;
        }

        h2 {
            font-size: 1.2rem;
            margin: 0;
        }

        p {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.5rem;
        }

        #top {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        td {
            padding: 10px;
            border: 1px solid #EEE;
        }

        .tabletitle {
            background: #f2f2f2;
            font-weight: bold;
        }

        .service {
            border-bottom: 1px solid #EEE;
        }

        .itemtext {
            font-size: 0.9rem;
        }

        .legal {
            margin-top: 15px;
            font-size: 0.9rem;
            color: #333;
        }

        .btn-print {
            float: right;
            color: #333;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div id="top">
            <h2>Apotek Wikrama Abadi</h2>
            <p>Alamat: Sepanjang Jalan Kenangan</p>
            <p>Email: apotekwikrama@gmail.com</p>
            <p>Phone: 000-111-2222</p>
        </div>
        <div class="bot">
            <table>
                <tr class="tabletitle">
                    <td class="item"><h2>Obat</h2></td>
                    <td class="item"><h2>Jumlah</h2></td>
                    <td class="Rate"><h2>Harga</h2></td>
                </tr>
                @if (!empty($order['medicines']) && is_array($order['medicines']))
                    @foreach ($order['medicines'] as $medicine) 
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">{{ $medicine['name_medicine'] }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">{{ $medicine['qty'] }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">Rp. {{ number_format($medicine['price'], 0, ',', ',') }}</p>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="tableitem">
                            <p class="itemtext">Tidak ada obat ditemukan</p>
                        </td>
                    </tr>
                @endif
                    
                <tr class="tabletitle">
                    <td></td>
                    <td class="Rate"><h2>PPN (10%)</h2></td>
                    @php
                        $ppn = isset($order['total_price']) ? $order['total_price'] * 0.1 : 0;
                    @endphp
                    <td class="payment">
                        <h2>Rp. {{ number_format($ppn, 0, ',', ',') }}</h2>
                    </td>
                </tr>
                <tr class="tabletitle">
                    <td></td>
                    <td class="Rate"><h2>Total Harga</h2></td>
                    <td class="payment">
                        <h2>Rp. {{ number_format(isset($order['total_price']) ? $order['total_price'] : 0, 0, ',', ',') }}</h2>
                    </td>
                </tr>
            </table>
            <p class="legal">Terimakasih atas pembelian anda! Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium labore dolorum maiores magni eveniet quo.</p>
        </div>
    </div>
</body>

</html>
