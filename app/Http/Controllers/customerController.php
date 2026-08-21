<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tb_customer;
use Illuminate\Support\Facades\Storage; // Ditambahkan untuk akses S3
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class customerController extends Controller
{
    public function index()
    {
        $data_customer = tb_customer::get();
        return view('pages.Customer.show', compact('data_customer'));
    }

    public function create()
    {
        return view('pages.Customer.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_telp' => 'required|numeric',
            'alamat' => 'required',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'no_telp.numeric' => 'No Telepon harus berupa angka',
            'no_telp.required' => 'No Telepon harus diisi',
            'nama.required' => 'Nama Customer harus diisi',
            'alamat.required' => 'alamat harus diisi',
            'foto_ktp.image' => 'File harus berupa gambar',
            'foto_ktp.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp',
            'foto_ktp.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Handle upload gambar langsung ke Supabase S3
        $pathKtp = null;
        if ($request->hasFile('foto_ktp')) {
            $pathKtp = $request->file('foto_ktp')->store('foto_ktp_customer', 's3');
        }

        tb_customer::create([
            'user_id' => null,
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'foto_ktp' => $pathKtp, // Menyimpan path dari S3
        ]);

        Cache::forget('data_customer');
        return redirect('/customer')->with('pesan', 'Data berhasil ditambahkan');
    }

    public function show(string $id_customer)
    {
    }

    public function edit(string $id_customer)
    {
        $data = tb_customer::findOrFail($id_customer);
        return view('pages.customer.edit', compact('data'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
            'no_telp' => 'required|numeric',
            'alamat' => 'required',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'no_telp.numeric' => 'No Telepon harus berupa angka',
            'no_telp.required' => 'No Telepon harus diisi',
            'nama.required' => 'Nama Customer harus diisi',
            'alamat.required' => 'alamat harus diisi',
            'foto_ktp.image' => 'File harus berupa gambar',
            'foto_ktp.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp',
            'foto_ktp.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $dataUpdate = [
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
        ];

        // Handle upload gambar baru (jika ada) ke S3
        if ($request->hasFile('foto_ktp')) {
            $produkLama = tb_customer::findOrFail($id);
            
            // Hapus gambar lama di Supabase S3
            if ($produkLama->foto_ktp) {
                Storage::disk('s3')->delete($produkLama->foto_ktp);
            }

            // Simpan gambar baru ke S3
            $pathKtp = $request->file('foto_ktp')->store('foto_ktp_customer', 's3');
            $dataUpdate['foto_ktp'] = $pathKtp;
        }

        tb_customer::where('id_customer', $id)->update($dataUpdate);
        Cache::forget('data_customer');

        return redirect('/customer')->with('pesan', 'Data berhasil diupdate');
    }

    public function destroy(string $id_customer)
    {
        $customer = tb_customer::findOrFail($id_customer);
        
        // Hapus file dari Supabase S3 sebelum data dihapus
        if ($customer->foto_ktp) {
            Storage::disk('s3')->delete($customer->foto_ktp);
        }
        
        $customer->delete();
        Cache::forget('data_customer');

        return redirect('/customer')->with('pesan', 'Data berhasil dihapus');
    }
}