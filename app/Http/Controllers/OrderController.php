<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Models\Medicines; 
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Request $request)
    {  
        // Ambil data order dengan relasi 'user'
        $orders = Order::with('user');
    
        // Periksa apakah ada filter berdasarkan tanggal
        if ($request->has('date') && !empty($request->date)) {
            $date = $request->date;
            $orders->whereDate('created_at', $date);
        }
    
        // Paginate data order
        $orders = $orders->simplePaginate(10);
    
        // Decode 'medicines' untuk setiap order
        foreach ($orders as $item) {
            $item->medicines = json_decode($item->medicines, true);
        }
    
        // Kirim data ke tampilan
        return view('order.kasir.index', compact('orders'));
    }
    
    public function create()
    {
        $medicines = Medicines::all();
        return view('order.kasir.create', compact('medicines'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name_customor' => 'required|string|max:255',
            'medicines' => 'required|array',
        ]);
    
        $arrayDistinct = array_count_values($request->medicines);
        $arrayAssocMedicines = [];
    
        // Mengambil semua obat yang diminta dalam satu query
        $medicines = Medicines::whereIn('id', array_keys($arrayDistinct))->get()->keyBy('id');
    
        foreach ($arrayDistinct as $id => $count) {
            // Cek apakah obat ditemukan
            if (!$medicines->has($id)) {
                return redirect()->back()->with('failed', 'Obat dengan ID ' . $id . ' tidak ditemukan.')->withInput();
            }
    
            $medicine = $medicines->get($id);
    
            // Cek apakah stok obat cukup
            if ($count > $medicine->stock) {
                return redirect()->back()->with('failed', 'Stok untuk ' . $medicine->name . ' tidak cukup. Stok saat ini: ' . $medicine->stock)->withInput();
            }
    
            // Hitung harga sub total per obat
            $subPrice = $medicine->price * $count;
    
            // Menyusun data obat yang dibeli
            $arrayItem = [
                "id" => $id,
                "name_medicine" => $medicine->name,
                "qty" => $count,
                "price" => $medicine->price,
                "sub_price" => $subPrice,
            ];
    
            // Tambahkan item obat ke dalam array
            array_push($arrayAssocMedicines, $arrayItem);
    
            // Jika perlu, update stok obat setelah transaksi (opsional)
            // $medicine->stock -= $count;
            // $medicine->save();
        }
    
        // Hitung total harga dan PPN
        $totalPrice = array_sum(array_column($arrayAssocMedicines, 'sub_price'));
        $priceWithPPN = $totalPrice + ($totalPrice * 0.1); // PPN 10%
    
        // Proses pembuatan order
        $proses = Order::create([
            'user_id' => Auth::user()->id,
            'medicines' => json_encode($arrayAssocMedicines),
            'name_customor' => $request->name_customor,
            'total_price' => $priceWithPPN,
        ]);
    
        // Cek apakah order berhasil dibuat
        if ($proses) {
            return redirect()->route('print', $proses->id);
        } else {
            return redirect()->back()->with('alert', 'Gagal membuat data pembelian, silahkan coba kembali dengan data yang benar');
        }
    }
    
    
    public function show($id)
    {
        $order = Order::find($id);
        $order->medicines = json_decode($order->medicines, true);
        return view('order.kasir.print', compact('order'));
    }
    public function edit(Order $order)
    {
        
    }

    public function update(Request $request, Order $order)
    {
        
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return redirect()->back()->withErrors(['failed' => 'Order tidak ditemukan.']);
        }
        $order->delete();
        return redirect()->route('pembelian')->with('success', 'Order berhasil dihapus.');
    }

    public function downloadPDF($id)
    {
        // Mencari order berdasarkan ID yang diberikan
        $order = Order::find($id);

        // Jika order tidak ditemukan, kembalikan ke halaman sebelumnya dengan pesan error
        if (!$order) {
            return redirect()->back()->withErrors(['failed' => 'Order not found.']);
        }
        // Decode field 'medicines' dari format JSON menjadi array agar dapat digunakan dalam tampilan
        $order->medicines = json_decode($order->medicines, true);
    
        // Bagikan data order ke tampilan menggunakan view sharing
        view()->share('order', $order);

        // Generate PDF dari tampilan 'order.kasir.download-pdf' dan kirim data order
        $pdf = PDF::loadView('order.kasir.download-pdf', compact('order'));
    
        // Kembalikan file PDF untuk di-download dengan nama 'receipt.pdf'
        return $pdf->download('receipt.pdf');
    }    

    public function data () 
    {
        $orders = Order::with('user')->simplePaginate(5);
        return view ('order.admin.index', compact('orders'));
    }

    public function exportExcel()
    {
        $file_name = 'data_pembelian' . '.xlsx';
        return Excel::download(new OrdersExport, $file_name); 
    }

}
