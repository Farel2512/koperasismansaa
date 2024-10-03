<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function barang(Request $request)
    {
        $perPage = 5;
        $barangs = Barang::when($request->barangsearch, function($query) use ($request) {
            $query->where('nama', 'LIKE', '%' . $request->barangsearch . '%')
                  ->orWhere('no', 'LIKE', '%' . $request->barangsearch . '%');
        })->paginate($perPage);

        return view('barang.index', compact('barangs', 'request', 'perPage'));
    }

    public function create()
    {
        $hasRole = auth()->user()->getRoleNames();
        return view('barang.create', compact('hasRole'));
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $validator = Validator::make($request->all(), [
            'no'            => 'required|integer|unique:barangs,no',
            'image'         => 'required|mimes:png,jpg,jpeg|max:2048',
            'nama'          => 'required',
            'jenis_barang'  => 'required|in:Jasa,ATK,Snack,Minuman,Makanan',
            'harga'         => 'required|integer',
            'harga_beli'    => 'required|integer',
            'satuan'        => 'required|in:buah,lembar,bungkus,botol,pcs',
            'stok'          => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $image = $request->file('image');
        $filename = date('Y-m-d') . $image->getClientOriginalName();
        $path = 'photo-barang/' . $filename;
        Storage::disk('public')->put($path, file_get_contents($image));

        $barang = new Barang;
        $barang->no           = $request->no;
        $barang->nama         = $request->nama;
        $barang->jenis_barang = $request->jenis_barang;
        $barang->harga        = $request->harga;
        $barang->harga_beli   = $request->harga_beli;
        $barang->satuan       = $request->satuan;
        $barang->stok         = $request->stok;
        $barang->image        = $filename;

        $barang->save();

        if (auth()->user()->hasRole('kasir')) {
            $rolePrefix = 'kasir';
        } elseif (auth()->user()->hasRole('manager')) {
            $rolePrefix = 'manager';
        } else {
            $rolePrefix = 'admin';
        }

        return redirect()->route($rolePrefix . '.barang')->with('success', 'Barang berhasil disimpan');
    }

    public function edit($nama)
    {
        $barang = Barang::where('nama', $nama)->firstOrFail();
        $hasRole = auth()->user()->getRoleNames();

        return view('barang.edit', compact('barang', 'hasRole'));
    }

    public function update(Request $request, $nama)
    {
        date_default_timezone_set('Asia/Jakarta');

        $barang = Barang::where('nama', $nama)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'image'         => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'no'            => 'required|integer',
            'nama'          => 'required',
            'jenis_barang'  => 'required|in:Jasa,ATK,Snack,Minuman,Makanan',
            'harga'         => 'required|integer',
            'harga_beli'    => 'required|integer',
            'satuan'        => 'required|in:buah,lembar,bungkus,botol,pcs',
            'stok'          => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $barang->no           = $request->no;
        $barang->nama         = $request->nama;
        $barang->jenis_barang = $request->jenis_barang;
        $barang->harga        = $request->harga;
        $barang->harga_beli   = $request->harga_beli;
        $barang->satuan       = $request->satuan;
        $barang->stok         = $request->stok;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = date('Y-m-d') . $image->getClientOriginalName();
            $path = 'photo-barang/' . $filename;
            Storage::disk('public')->put($path, file_get_contents($image));

            if ($barang->image) {
                Storage::disk('public')->delete('photo-barang/' . $barang->image);
            }

            $barang->image = $filename;
        }

        $barang->save();

        // Menentukan prefix role berdasarkan role pengguna
        if (auth()->user()->hasRole('kasir')) {
            $rolePrefix = 'kasir';
        } elseif (auth()->user()->hasRole('manager')) {
            $rolePrefix = 'manager';
        } else {
            $rolePrefix = 'admin';
        }

        return redirect()->route($rolePrefix . '.barang')->with('success', 'Barang berhasil diperbarui');
    }

    public function delete($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        if (auth()->user()->hasRole('kasir')) {
            $rolePrefix = 'kasir';
        } elseif (auth()->user()->hasRole('manager')) {
            $rolePrefix = 'manager';
        } else {
            $rolePrefix = 'admin';
        }

        return redirect()->route($rolePrefix . '.barang')->with('success', 'Barang berhasil dihapus');
    }
}
