@extends('layout.master')

@section('content')
  <div class="card mb-4">
    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
      <h2 class="card-title mb-0">Daftar Transaksi</h2>
      <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center justify-content-end gap-2 w-100 w-md-auto">
        <a href="/rekap-penjualan" class="btn btn-primary">Lihat Rekap</a>
        <a href="/transaksi/create" class="btn btn-success">Tambah Transaksi</a>
      </div>
    </div>
  </div>
  
  @if (session('pesan'))
  <div class="alert alert-success">
    {{ session('pesan') }}
  </div>
  @endif
  
  <div class="card">
    <div class="table-responsive">
        <table class="table table-striped-columns">
          <thead>
            <tr class="text-center">
              <th scope="col" class="bg-primary text-white">No</th>
              <th scope="col" class="bg-primary text-white">Customer</th>
              <th scope="col" class="bg-primary text-white">Nama Motor</th>
              <th scope="col" class="bg-primary text-white">Warna Motor</th>
              <th scope="col" class="bg-primary text-white">Plat Motor</th>
              <th scope="col" class="bg-primary text-white">Durasi(Hari)</th>
              
              <th scope="col" class="bg-primary text-white">Mulai</th>
              <th scope="col" class="bg-primary text-white">Selesai</th>
              <th scope="col" class="bg-primary text-white">Total Bayar</th>
              <!-- Tambahan Kolom Status -->
              <th scope="col" class="bg-primary text-white">Status</th>
              <th scope="col" class="bg-primary text-white">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($data_transaksi as $item)
            <tr class="text-center align-middle">
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->customer->nama ?? '-' }}</td>
              <td>{{ $item->motor->nama_motor ?? '-' }}</td>
              <td>{{ $item->motor->warna ?? '-' }}</td>
              <td>{{ $item->motor->plat_nomor ?? '-' }}</td>
              <td>{{ $item->durasi }} </td>
              
              <td>{{ \Carbon\Carbon::parse($item->tgl_mulai)->format('d/m/Y') }}</td>
              <td>{{ \Carbon\Carbon::parse($item->tgl_selesai)->format('d/m/Y') }}</td>
              <td>Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
              
              <!-- Menampilkan Badge Status Transaksi -->
              <td>
                @if($item->status_transaksi == 'berjalan')
                    <span class="badge bg-warning text-dark">Berjalan</span>
                @else
                    <span class="badge bg-success">Selesai</span>
                @endif
              </td>
              
              <td class="d-flex justify-content-center gap-2">
                <!-- Tombol Cetak Invoice -->
                <a href="{{ route('transaksi.invoice', $item->id_transaksi) }}" target="_blank" class="btn btn-info text-white btn-sm">Cetak</a>
                
                <!-- Tombol Selesaikan (Hanya Muncul Jika Status Berjalan) -->
                @if($item->status_transaksi == 'berjalan')
                  <button type="button" class="btn btn-success btn-sm" onclick="openSelesaiModal({{ $item->id_transaksi }}, {{ $item->motor->km_terakhir ?? 'null' }})">Selesaikan</button>
                @endif
                
                <!-- Tombol Hapus -->
                <form action="/transaksi/{{ $item->id_transaksi }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data transaksi ini?')">Hapus</button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <!-- Colspan menjadi 10 karena ada penambahan 1 kolom status -->
              <td colspan="10" class="text-center">Tidak ada data transaksi</td>
            </tr>
            @endforelse
          </tbody>
        </table>
    </div>
  </div>
  
  <!-- Modal: Input KM saat menyelesaikan transaksi -->
  <div class="modal fade" id="selesaiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Input KM Akhir</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="selesaiForm" method="POST">
          @csrf
          @method('PATCH')
          <div class="modal-body">
            <div class="mb-3">
              <label for="km_terakhir_input" class="form-label">KM Terakhir</label>
              <input type="number" step="1" min="0" class="form-control" id="km_terakhir_input" name="km_terakhir" placeholder="Masukkan KM terakhir motor setelah disewa">
              <div class="form-text">Biarkan kosong jika tidak ingin mengubah nilai KM.</div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan & Selesaikan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    function openSelesaiModal(transaksiId, currentKm) {
      const form = document.getElementById('selesaiForm');
      form.action = '/transaksi/' + transaksiId + '/selesai';
      const kmInput = document.getElementById('km_terakhir_input');
      kmInput.value = currentKm && currentKm !== null ? currentKm : '';
      var selesaiModal = new bootstrap.Modal(document.getElementById('selesaiModal'));
      selesaiModal.show();
    }
  </script>
  @endpush
@endsection