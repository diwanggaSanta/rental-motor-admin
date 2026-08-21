@extends('layout.master')

@section('content')
    <div class="card">
        <div class="card-header">Tambah Data Motor</div>
        <div class="card-body">
            <form action="/motor" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- Kolom Kiri: Nama Motor, Plat Nomor, Tahun, Harga, CC Mesin, KM Terakhir --}}
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="nama_motor" class="form-label">Nama Motor</label>
                            <input type="text" name="nama_motor" class="form-control" placeholder="Contoh: Honda Vario 160"
                                value="{{ old('nama_motor') }}">
                            @error('nama_motor')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori Motor</label>
                            <select class="form-select" name="kategori_id" id="kategori_id">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($data_kategori as $item)
                                    <option value="{{ $item->id_kategori }}" {{ old('kategori_id') == $item->id_kategori ? 'selected' : '' }}>
                                        {{ $item->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="warna" class="form-label">Warna Motor</label>
                            <select name="warna" class="form-select" required>
                                <option value="">-- Pilih Warna --</option>
                                <option value="White">White</option>
                                <option value="Black">Black</option>
                                <option value="Red">Red</option>
                                <option value="Blue">Blue</option>
                                <option value="Grey">Grey</option>
                                <option value="Silver">Silver</option>
                                <option value="Gold">Gold</option>
                            </select>
                            @error('warna')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="plat_nomor" class="form-label">Plat Nomor</label>
                            <input type="text" name="plat_nomor" class="form-control" placeholder="Contoh: B 1234 ABC"
                                value="{{ old('plat_nomor') }}">
                            <div class="form-text">Nomor plat kendaraan, contoh: B 1234 ABC</div>
                            @error('plat_nomor')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun Keluaran</label>
                            <input type="number" name="tahun" class="form-control" placeholder="Contoh: 2024"
                                value="{{ old('tahun') }}">
                            @error('tahun')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cc_mesin" class="form-label">CC Mesin</label>
                            <input type="text" name="cc_mesin" class="form-control" placeholder="Contoh: 160cc"
                                value="{{ old('cc_mesin') }}">
                            <div class="form-text">Kapasitas mesin motor, contoh: 150cc, 160cc, 250cc</div>
                            @error('cc_mesin')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                    </div>

                    {{-- Kolom Kanan: Kategori Badge, Tag Tambahan, Status, Gambar --}}
                    <div class="col-sm-6">

                        <div class="mb-3">
                            <label for="km_terakhir" class="form-label">KM Terakhir</label>
                            <input type="number" name="km_terakhir" class="form-control" placeholder="Contoh: 10000"
                                value="{{ old('km_terakhir') }}">
                            <div class="form-text">KM terakhir motor</div>
                            @error('km_terakhir')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga Sewa (Rp)</label>
                            <input type="number" name="harga" class="form-control" placeholder="Contoh: 150000"
                                value="{{ old('harga') }}">
                            @error('harga')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status Motor</label>
                            <select class="form-select" name="status" id="status">
                                <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="disewa" {{ old('status') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                                <option value="servis" {{ old('status') == 'servis' ? 'selected' : '' }}>Servis / Maintenance
                                </option>
                            </select>
                            @error('status')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gambar_motor" class="form-label">Gambar Motor</label>
                            <input type="file" name="gambar_motor" class="form-control" id="gambar_motor" accept="image/*">
                            <div class="form-text">Format: jpeg, png, jpg, webp. Maksimal 2MB.</div>
                            @error('gambar_motor')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Deskripsi full width --}}
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi / Spesifikasi Lainnya</label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi" style="height: 100px; resize: none;"
                        placeholder="Masukkan deskripsi atau spesifikasi motor...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 15px;">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="/motor" class="btn btn-secondary ms-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection