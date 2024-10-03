<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DataBelanja;
use App\Models\Belanja;
use PDF;
use Illuminate\Http\Request;

class BelanjaController extends Controller
{
    public function belanja(Request $request)
    {
        $barangs = Barang::all();
        date_default_timezone_set('Asia/Jakarta');
        $query = Belanja::query();

        if ($request->filled('tanggalbelanja')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $belanjas = $query->paginate(10);

        return view('belanja.index', compact('barangs','belanjas'));
    }


    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        $barangs = Barang::all();
        $hasRole = auth()->user()->getRoleNames();
        return view('belanja.create', compact('barangs', 'hasRole'));
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $request->validate([
            'no_belanja'        => 'required|unique:belanjas',
            'items'             => 'required|array',
            'items.*.barang_id' => 'required|exists:barangs,id',
            'uang_bayar'        => 'required|numeric',
            'items.*.quantity'  => 'required|integer|min:1',
        ]);

        $belanja = Belanja::create([
            'no_belanja' => $request['no_belanja'],
            'uang_bayar'   => $request['uang_bayar'],
        ]);

        foreach ($request->items as $item) {
            $barang = Barang::find($item['barang_id']);
            DataBelanja::create([
                'belanja_id' => $belanja->id,
                'barang_id' => $barang->id,
                'quantity' => $item['quantity'],
                'harga_total' => $barang->harga_beli * $item['quantity'],
            ]);
        }

        if (auth()->user()->hasRole('kasir')) {
            $rolePrefix = 'kasir';
        } elseif (auth()->user()->hasRole('manager')) {
            $rolePrefix = 'manager';
        } else {
            $rolePrefix = 'admin';
        }

        return redirect()->route($rolePrefix . '.belanja.create')->with('success', 'Belanja berhasil disimpan.');
    }

    public function delete($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $belanja = Belanja::findOrFail($id);
        $belanja->delete();

        if (auth()->user()->hasRole('kasir')) {
            $rolePrefix = 'kasir';
        } elseif (auth()->user()->hasRole('manager')) {
            $rolePrefix = 'manager';
        } else {
            $rolePrefix = 'admin';
        }

        return redirect()->route($rolePrefix . '.belanja.index')->with('success', 'Belanja berhasil dihapus.');
    }

    public function cetak($id)
    {
        $belanja = Belanja::with('dataBelanjas.barang')->findOrFail($id);

        $pdf = PDF::loadView('belanja.cetak', compact('belanja'))->setPaper('a4');
        $fileName = 'NOTA_PEMBELIAN_' . $belanja->no_belanja . '.pdf';

        return $pdf->download($fileName);
    }
}
