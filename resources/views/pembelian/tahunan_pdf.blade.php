<!DOCTYPE html>
<html>
<head>
    <title>LAPORAN PEMBELIAN TAHUN {{ $currentYear }}</title>
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
        }
        thead th {
            text-align: center;
        }
        .page-break {
            page-break-before: always;
        }
        .no-break {
            page-break-inside: avoid;
        }
        .signature {
            font-size: 14px;
            padding-top: 8px;
            margin-top: 30px;
            text-align: right;
            page-break-inside: avoid;
        }
        .signature div {
            display: inline-block;
            margin-right: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center; font-size: 20px; padding-bottom: 8px;">LAPORAN PEMBELIAN <br> TAHUN {{ $currentYear }}</h1>
    <div class="no-break">
        <table>
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Bulan</th>
                    <th>Jasa</th>
                    <th>ATK</th>
                    <th>Makanan</th>
                    <th>Minuman</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $months = [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ];
                    $no = 1;
                @endphp
                @foreach ($months as $index => $month)
                    <tr>
                        <td style="text-align: center;"><strong>{{ $no++ }}</strong></td>
                        <td><strong>{{ $month }}</strong></td>
                        <td>Rp. {{ number_format($mergedBelanjas['Jasa'][$index + 1] , 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($mergedBelanjas['ATK'][$index + 1] , 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($mergedBelanjas['Makanan'][$index + 1] , 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($mergedBelanjas['Minuman'][$index + 1] , 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format(
                            ($mergedBelanjas['Jasa'][$index + 1]) +
                            ($mergedBelanjas['ATK'][$index + 1]) +
                            ($mergedBelanjas['Makanan'][$index + 1]) +
                            ($mergedBelanjas['Minuman'][$index + 1]), 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2"><strong>Total</strong></th>
                    <th>Rp. {{ number_format(array_sum($mergedBelanjas['Jasa']), 0, ',', '.') }}</th>
                    <th>Rp. {{ number_format(array_sum($mergedBelanjas['ATK']), 0, ',', '.') }}</th>
                    <th>Rp. {{ number_format(array_sum($mergedBelanjas['Makanan']), 0, ',', '.') }}</th>
                    <th>Rp. {{ number_format(array_sum($mergedBelanjas['Minuman']), 0, ',', '.') }}</th>
                    <th>Rp. {{ number_format(
                        array_sum($mergedBelanjas['Jasa']) +
                        array_sum($mergedBelanjas['ATK']) +
                        array_sum($mergedBelanjas['Makanan']) +
                        array_sum($mergedBelanjas['Minuman']), 0, ',', '.') }}
                    </th>
                </tr>
            </tfoot>
        </table>
        <div class="signature">
            <div>
                <p><b>Mengetahui <br> KETUA KPRI HARAPAN MAJU <br> SMA NEGERI 1 RENGAT</b></p>
                <br><br>
                <p>Nama Ketua</p>
            </div>
            <div style="margin-left: 30%;">
                <p><b>Rengat, {{ now()->format('d F Y') }} <br> MANAGER</b></p>
                <br><br>
                <p>Nama Manager</p>
            </div>
            <div style="margin-left: 10%;">
                <p><b>PENGELOLA</b></p>
                <br><br>
                <p>Nama Pengelola</p>
            </div>
        </div>
    </div>
</body>
</html>
