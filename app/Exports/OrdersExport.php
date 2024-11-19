<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping; 
use Maatwebsite\Excel\Concerns\WithHeadings; 
use Carbon\Carbon;

class OrdersExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ambil data order dengan relasi user
        return Order::with('user')->get();
    }

    /**
     * Menentukan nama-nama kolom pada Excel
     */
    public function headings(): array
    {
        return [
            "Nama Pembeli", "Obat", "Total Bayar", "Kasir", "Tanggal"
        ];
    }

    /**
     * Mengambil data yang akan dimasukkan ke dalam Excel
     */
    public function map($item): array
    {
        // Mengonversi medicines yang disimpan dalam format JSON menjadi array
        $dataObat = '';
        if (is_array($item->medicines)) {
            foreach ($item->medicines as $value) {
                // Format setiap obat
                $format = $value["name_medicine"] . " (qty " . $value['qty'] . " : Rp " . number_format($value['sub_price'], 0, ',', '.') . "), ";
                $dataObat .= $format;
            }
        } else {
            // Jika 'medicines' tidak dalam format array, decode dulu
            $medicinesArray = json_decode($item->medicines, true);
            if (is_array($medicinesArray)) {
                foreach ($medicinesArray as $value) {
                    // Format setiap obat
                    $format = $value["name_medicine"] . " (qty " . $value['qty'] . " : Rp " . number_format($value['sub_price'], 0, ',', '.') . "), ";
                    $dataObat .= $format;
                }
            }
        }

        // Mengembalikan data dalam format yang akan diekspor ke Excel
        return [
            $item->name_customor,
            rtrim($dataObat, ', '), // Menghapus koma terakhir
            number_format($item->total_price, 0, ',', '.'), // Format harga total
            $item->user->name,
            Carbon::parse($item->created_at)->isoFormat('D MMMM YYYY'), // Format tanggal
        ];
    }
}
