@extends('layout.master')

@section('content')
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h2 class="card-title mb-1">Daftar Kategori</h2>
                <p class="text-muted mb-0 small">Untuk mengkategorikan motor yang akan ditambahkan</p>
            </div>
            <a href="/kategori/create" class="btn btn-success">Tambah Kategori</a>
        </div>
    </div>

    <div class="card">
        <table class="table table-striped-columns mb-0">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Kategori</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data_kategori as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="fw-medium text-dark">
                                {{ $item->nama_kategori }}
                            </span>
                        </td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('kategori.edit', $item->id_kategori) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="/kategori/{{ $item->id_kategori }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus kategori {{ $item->nama_kategori }}?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-3">Belum ada badge kategori. Tambahkan sekarang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection