<?php

namespace App\Http\Controllers;

use App\Models\tb_transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapPenjualanController extends Controller
{
    public function index()
    {
        // Menggunakan PostgreSQL EXTRACT
        $rekap = tb_transaksi::select(
            DB::raw('EXTRACT(YEAR FROM created_at) as tahun'),
            DB::raw('EXTRACT(MONTH FROM created_at) as bulan'),
            DB::raw('COUNT(id_transaksi) as total_transaksi'),
            DB::raw('SUM(total_bayar) as total_pendapatan')
        )
        ->whereIn('status_transaksi', ['berjalan', 'selesai'])
        ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at)'), DB::raw('EXTRACT(MONTH FROM created_at)'))
        ->orderBy(DB::raw('EXTRACT(YEAR FROM created_at)'), 'desc')
        ->orderBy(DB::raw('EXTRACT(MONTH FROM created_at)'), 'desc')
        ->get();
        
        // Memformat bulan dari angka ke nama bulan
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        foreach ($rekap as $r) {
            $r->nama_bulan = $bulanList[(int) $r->bulan];
        }

        return view('pages.rekap.index', compact('rekap'));
    }
}
