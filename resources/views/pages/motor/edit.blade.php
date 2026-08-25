@extends('layout.master')

@section('content')
    <div class="card">
        <div class="card-header fw-semibold">Edit Data Motor</div>
        <div class="card-body">
            <form action="/motor/{{ $data->id_motor }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="nama_motor" class="form-label">Nama Motor</label>
                            <input type="text" name="nama_motor" class="form-control"
                                value="{{ old('nama_motor', $data->nama_motor) }}">
                            @error('nama_motor')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori Motor</label>
                            <select class="form-select" name="kategori_id" id="kategori_id">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($data_kategori as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" {{ old('kategori_id', $data->kategori_id) == $kategori->id_kategori ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
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
                                <option value="White" {{ old('warna', $data->warna) == 'White' ? 'selected' : '' }}>White</option>
                                <option value="Black" {{ old('warna', $data->warna) == 'Black' ? 'selected' : '' }}>Black</option>
                                <option value="Red" {{ old('warna', $data->warna) == 'Red' ? 'selected' : '' }}>Red</option>
                                <option value="Blue" {{ old('warna', $data->warna) == 'Blue' ? 'selected' : '' }}>Blue</option>
                                <option value="Grey" {{ old('warna', $data->warna) == 'Grey' ? 'selected' : '' }}>Grey</option>
                                <option value="Silver" {{ old('warna', $data->warna) == 'Silver' ? 'selected' : '' }}>Silver</option>
                                <option value="Gold" {{ old('warna', $data->warna) == 'Gold' ? 'selected' : '' }}>Gold</option>
                            </select>
                            @error('warna')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="plat_nomor" class="form-label">Plat Nomor</label>
                            <input type="text" name="plat_nomor" class="form-control" placeholder="Contoh: B 1234 ABC"
                                value="{{ old('plat_nomor', $data->plat_nomor) }}">
                            <div class="form-text">Nomor plat kendaraan, contoh: B 1234 ABC</div>
                            @error('plat_nomor')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun Keluaran</label>
                            <input type="number" name="tahun" class="form-control" value="{{ old('tahun', $data->tahun) }}">
                            @error('tahun')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cc_mesin" class="form-label">CC Mesin</label>
                            <input type="text" name="cc_mesin" class="form-control" placeholder="Contoh: 160cc"
                                value="{{ old('cc_mesin', $data->cc_mesin) }}">
                            <div class="form-text">Kapasitas mesin motor, contoh: 150cc, 160cc, 250cc</div>
                            @error('cc_mesin')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="km_terakhir" class="form-label">KM Terakhir</label>
                            <input type="number" name="km_terakhir" class="form-control" placeholder="Contoh: 10000 KM"
                                value="{{ old('km_terakhir', $data->km_terakhir) }}">
                            @error('km_terakhir')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga Sewa (Rp)</label>
                            <input type="number" name="harga" class="form-control" value="{{ old('harga', $data->harga) }}">
                            @error('harga')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status Motor</label>
                            <select class="form-select" name="status" id="status">
                                <option value="tersedia" {{ old('status', $data->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="disewa" {{ old('status', $data->status) == 'disewa' ? 'selected' : '' }}>Disewa</option>
                                <option value="servis" {{ old('status', $data->status) == 'servis' ? 'selected' : '' }}>Servis / Maintenance</option>
                            </select>
                            @error('status')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gambar_motor" class="form-label">Gambar Motor</label>
                            @if($data->gambar_motor)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($data->gambar_motor) }}" alt="Gambar Motor"
                                        style="width: 100px; height: auto; border-radius: 5px;">
                                </div>
                            @endif
                            <input type="file" name="gambar_motor" class="form-control" id="gambar_motor" accept="image/*">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengganti gambar. Format: jpeg, png, jpg, webp. Maksimal 2MB.</div>
                            @error('gambar_motor')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <label for="deskripsi" class="form-label">Deskripsi / Spesifikasi</label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi"
                        style="height: 100px; resize: none;">{{ old('deskripsi', $data->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3 d-flex flex-column flex-sm-row gap-2">
                    <button type="submit" class="btn btn-primary">Update Data</button>
                    <a href="/motor" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection