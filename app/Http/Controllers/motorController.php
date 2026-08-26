<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tb_motor;
use App\Models\tb_kategori;
use Illuminate\Support\Facades\Storage; // Ditambahkan untuk akses S3
use Illuminate\Support\Facades\Cache;

class motorController extends Controller
{
    public function index()
    {
        $data_motor = tb_motor::with('kategori')->get();
        return view('pages.motor.show', compact('data_motor'));
    }

    public function create()
    {
        $data_kategori = tb_kategori::all();
        return view('pages.motor.add', compact('data_kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_motor' => 'required',
            'kategori_id'  => 'required',
            'warna' => 'nullable|string|max:50',
            'plat_nomor' => 'nullable|string|max:20',
            'tahun' => 'required|numeric',
            'cc_mesin' => 'nullable|string|max:50',
            'km_terakhir' => 'nullable|numeric',
            'tag_tambahan' => 'nullable|string|max:100',
            'status' => 'required|in:tersedia,disewa,servis',
            'gambar_motor' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'required',
        ], [
            'nama_motor.required' => 'Nama motor wajib diisi',
            'kategori_id.required'  => 'Kategori motor wajib dipilih',
            'warna.max' => 'Warna maksimal 50 karakter',
            'plat_nomor.max' => 'Plat nomor maksimal 20 karakter',
            'tahun.required' => 'Tahun keluaran wajib diisi',
            'tahun.numeric' => 'Tahun harus berupa angka',
            'cc_mesin.max' => 'CC mesin maksimal 50 karakter',
            'km_terakhir.numeric' => 'KM harus berupa angka',
            'status.required' => 'Status motor wajib dipilih',
            'status.in' => 'Pilihan status tidak valid',
            'gambar_motor.image' => 'File yang diupload harus berupa gambar',
            'gambar_motor.mimes' => 'Format gambar hanya boleh jpeg, png, jpg, atau webp',
            'gambar_motor.max' => 'Ukuran gambar maksimal adalah 2MB',
            'deskripsi.required' => 'Deskripsi atau spesifikasi motor wajib diisi',
        ]);

        // Handle upload gambar motor ke Supabase S3
        $pathMotor = null;
        if ($request->hasFile('gambar_motor')) {
            $pathMotor = $request->file('gambar_motor')->store('gambar_motor', 's3');
        }

        tb_motor::create([
            'kategori_id' => $request->kategori_id ?: null,
            'nama_motor' => $request->nama_motor,
            'warna' => $request->warna,
            'plat_nomor' => $request->plat_nomor,
            'tahun' => $request->tahun,
            // Harga diset terpisah; tidak lagi diinput pada form motor
            'cc_mesin' => $request->cc_mesin,
            'km_terakhir' => $request->km_terakhir,
            'tag_tambahan' => $request->tag_tambahan,
            'status' => $request->status,
            'gambar_motor' => $pathMotor, // Menyimpan path S3
            'deskripsi' => $request->deskripsi,
        ]);

        Cache::forget('data_motor_tersedia');
        return redirect('/motor')->with('pesan', 'Data motor berhasil ditambahkan');
    }

    public function show(string $id_motor)
    {
        $data_motor = tb_motor::with('kategori')->findOrFail($id_motor);
        return view('pages.motor.detail', compact('data_motor'));
    }

    public function edit(string $id_motor)
    {
        $data = tb_motor::findOrFail($id_motor);
        $data_kategori = tb_kategori::all();
        return view('pages.motor.edit', compact('data', 'data_kategori'));
    }

    public function update(Request $request, string $id_motor)
    {
        $request->validate([
            'kategori_id' => 'nullable|exists:tb_kategori,id_kategori',
            'nama_motor' => 'required',
            'warna' => 'nullable|string|max:50',
            'plat_nomor' => 'nullable|string|max:20',
            'tahun' => 'required|numeric',
            'cc_mesin' => 'nullable|string|max:50',
            'km_terakhir' => 'nullable|numeric',
            'tag_tambahan' => 'nullable|string|max:100',
            'status' => 'required|in:tersedia,disewa,servis',
            'gambar_motor' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'required',
        ], [
            'nama_motor.required' => 'Nama motor wajib diisi',
            'kategori_id.required'  => 'Kategori motor wajib dipilih',
            'warna.max' => 'Warna maksimal 50 karakter',
            'plat_nomor.max' => 'Plat nomor maksimal 20 karakter',
            'tahun.required' => 'Tahun keluaran wajib diisi',
            'tahun.numeric' => 'Tahun harus berupa angka',
            'status.required' => 'Status motor wajib dipilih',
            'status.in' => 'Pilihan status tidak valid',
            'gambar_motor.image' => 'File yang diupload harus berupa gambar',
            'gambar_motor.mimes' => 'Format gambar hanya boleh jpeg, png, jpg, atau webp',
            'gambar_motor.max' => 'Ukuran gambar maksimal adalah 2MB',
            'deskripsi.required' => 'Deskripsi atau spesifikasi motor wajib diisi',
        ]);

        $dataUpdate = [
            'kategori_id' => $request->kategori_id ?: null,
            'nama_motor' => $request->nama_motor,
            'warna' => $request->warna,
            'plat_nomor' => $request->plat_nomor,
            'tahun' => $request->tahun,
            'cc_mesin' => $request->cc_mesin,
            'km_terakhir' => $request->km_terakhir,
            'tag_tambahan' => $request->tag_tambahan,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
        ];

        // Handle upload gambar baru (jika ada) ke S3
        if ($request->hasFile('gambar_motor')) {
            $motorLama = tb_motor::findOrFail($id_motor);

            // Hapus gambar lama dari S3
            if ($motorLama->gambar_motor) {
                Storage::disk('s3')->delete($motorLama->gambar_motor);
            }

            // Simpan gambar baru ke S3
            $pathMotor = $request->file('gambar_motor')->store('gambar_motor', 's3');
            $dataUpdate['gambar_motor'] = $pathMotor;
        }

        tb_motor::where('id_motor', $id_motor)->update($dataUpdate);
        Cache::forget('data_motor_tersedia');

        return redirect('/motor')->with('pesan', 'Data motor berhasil diupdate');
    }

    public function destroy(string $id_motor)
    {
        $motor = tb_motor::findOrFail($id_motor);

        // Hapus file gambar dari Supabase S3
        if ($motor->gambar_motor) {
            Storage::disk('s3')->delete($motor->gambar_motor);
        }

        $motor->delete();
        Cache::forget('data_motor_tersedia');

        return redirect('/motor')->with('pesan', 'Data motor berhasil dihapus beserta gambarnya');
    }
}