@extends('layout.master')

@section('content')
    <div class="card">
        <div class="card-header">Tambah Badge Kategori</div>
        <div class="card-body">
            <form action="/kategori" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                    <input type="text" name="nama_kategori" id="nama_kategori" class="form-control"
                        placeholder="Contoh: Automatic, Off-Road, Sport" value="{{ old('nama_kategori') }}">
                    @error('nama_kategori')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 10px;">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="/kategori" class="btn btn-secondary ms-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection