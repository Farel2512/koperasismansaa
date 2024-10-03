<!DOCTYPE html>
<html>
<head>
    <title>NOTA PEMBELIAN {{ $belanja->no_belanja }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            border: 1px solid black;
            padding: 4px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">NOTA PEMBELIAN</h1>
    <hr>

    <table style="margin-top: 1rem;">
        <thead>
            <tr>
                <th style="text-align: left; border: none; background-color: transparent; width: 15%;">Kode</th>
                <th style="text-align: left; border: none; background-color: transparent;">: {{ $belanja->no_belanja }}</th>
                <th style="text-align: left; border: none; background-color: transparent; width: 15%;">Tanggal</th>
                <th style="text-align: left; border: none; background-color: transparent;">: {{ $belanja->created_at->format('d-m-Y') }}</th>
            </tr>
            <tr>
                <th style="text-align: left; border: none; background-color: transparent; width: 15%;">Jumlah Item</th>
                <th style="text-align: left; border: none; background-color: transparent;">: {{ $belanja->dataBelanjas->count() }}</th>
                <th style="text-align: left; border: none; background-color: transparent; width: 15%;">Jam</th>
                <th style="text-align: left; border: none; background-color: transparent;">: {{ $belanja->created_at->format('H:i:s') }}</th>
            </tr>
        </thead>
    </table>
    <table style="margin-top: 1rem;">
        <thead>
            <tr>
                <th style="background-color: transparent;">No</th>
                <th style="background-color: transparent;">Nama Barang</th>
                <th style="background-color: transparent;">Jumlah</th>
                <th style="background-color: transparent;">Harga Satuan</th>
                <th style="background-color: transparent;">Harga Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($belanja->dataBelanjas as $dataBelanja)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $dataBelanja->barang->nama }}</td>
                <td>{{ $dataBelanja->quantity }}</td>
                <td>Rp {{ number_format($dataBelanja->barang->harga_beli, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($dataBelanja->harga_total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" style="background-color: transparent;">Subtotal</th>
                <th style="background-color: transparent;">Rp {{ number_format($belanja->dataBelanjas->sum('harga_total'), 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th colspan="4" style="background-color: transparent;">Uang Bayar</th>
                <th style="background-color: transparent;">Rp {{ number_format($belanja->uang_bayar, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th colspan="4" style="background-color: transparent;">Uang Kembali</th>
                <th style="background-color: transparent;">Rp {{ number_format($belanja->uang_bayar - $belanja->dataBelanjas->sum('harga_total'), 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

</body>
</html>
