<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DataTransaksi;
use App\Models\Transaksi;
use PDF;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function transaksi(Request $request)
    {
        $barangs = Barang::all();
        date_default_timezone_set('Asia/Jakarta');
        $query = Transaksi::query();

        if ($request->filled('tanggaltransaksi')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $transaksis = $query->paginate(10);

        return view('transaksi.index', compact('barangs','transaksis'));
    }


    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        $barangs = Barang::all();
        $hasRole = auth()->user()->getRoleNames();
        return view('transaksi.create', compact('barangs', 'hasRole'));
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $request->validate([
            'no_transaksi'      => 'required|unique:transaksis',
            'items'             => 'required|array',
            'items.*.barang_id' => 'required|exists:barangs,id',
            'uang_bayar'        => 'required|numeric',
            'items.*.quantity'  => 'required|integer|min:1',
        ]);

        $transaksi = Transaksi::create([
            'no_transaksi' => $request['no_transaksi'],
            'uang_bayar'   => $request['uang_bayar'],
        ]);

        foreach ($request->items as $item) {
            $barang = Barang::find($item['barang_id']);
            DataTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'barang_id' => $barang->id,
                'quantity' => $item['quantity'],
                'harga_total' => $barang->harga * $item['quantity'],
            ]);
        }

        if (auth()->user()->hasRole('kasir')) {
            $rolePrefix = 'kasir';
        } elseif (auth()->user()->hasRole('manager')) {
            $rolePrefix = 'manager';
        } else {
            $rolePrefix = 'admin';
        }

        return redirect()->route($rolePrefix . '.transaksi.create')->with('success', 'Transaksi berhasil disimpan.');
    }

    public function delete($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        if (auth()->user()->hasRole('kasir')) {
            $rolePrefix = 'kasir';
        } elseif (auth()->user()->hasRole('manager')) {
            $rolePrefix = 'manager';
        } else {
            $rolePrefix = 'admin';
        }

        return redirect()->route($rolePrefix . '.transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function cetak($id)
    {
        $transaksi = Transaksi::with('dataTransaksis.barang')->findOrFail($id);

        $pdf = PDF::loadView('transaksi.cetak', compact('transaksi'))->setPaper('a4');
        $fileName = 'NOTA_PENJUALAN_' . $transaksi->no_transaksi . '.pdf';

        return $pdf->download($fileName);
    }
}
