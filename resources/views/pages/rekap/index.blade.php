@extends('layout.master')

@section('content')
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h2 class="card-title mb-1 fw-bold">Rekap Transaksi Bulanan</h2>
                <p class="text-muted mb-0 small">Menampilkan data penjualan bulanan berdasarkan transaksi yang sukses.</p>
            </div>
            <div>
                <a href="/transaksi" class="btn btn-outline-secondary me-2">Kembali ke Transaksi</a>
                <a href="/dashboard" class="btn btn-outline-primary">Ke Dashboard</a>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase border-0">Bulan / Tahun</th>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase border-0">Total Transaksi</th>
                            <th class="px-4 py-3 text-muted small fw-bold text-uppercase border-0">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekap as $data)
                            <tr>
                                <td class="px-4 py-3">
                                    <span class="fw-bold text-dark">{{ $data->nama_bulan }} {{ $data->tahun }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge rounded-pill bg-info-subtle text-info fw-bold px-3 py-2">{{ $data->total_transaksi }} Transaksi</span>
                                </td>
                                <td class="px-4 py-3 fw-bold text-success">
                                    Rp {{ number_format($data->total_pendapatan, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-muted fw-medium">Belum ada data rekap penjualan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
