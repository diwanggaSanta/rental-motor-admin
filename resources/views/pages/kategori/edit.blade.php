@extends('layout.master')

@section('content')
    <div class="card">
        <div class="card-header fw-semibold">Edit Badge Kategori</div>
        <div class="card-body">
            <form action="/kategori/{{ $data->id_kategori }}" method="POST">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                    <input type="text" name="nama_kategori" id="nama_kategori" class="form-control"
                        value="{{ old('nama_kategori', $data->nama_kategori) }}">
                    @error('nama_kategori')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-3 d-flex flex-column flex-sm-row gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="/kategori" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection