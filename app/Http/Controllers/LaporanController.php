<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Belanja;
use App\Models\Transaksi;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Laporan Transaksi Jual Beli
    // Jual Beli Bulanan
    public function laporanJualBeliBulanan(Request $request)
    {
        $month = $request->query('month', Carbon::now()->month);
        $year = $request->query('year', Carbon::now()->year);
        $transaksis = Transaksi::with('dataTransaksis.barang')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $groupedTransaksis = $transaksis->groupBy(function($date) {
            return Carbon::parse($date->created_at)->weekOfMonth;
        });

        $mergedTransaksis = [];
        $barangs = Barang::all();

        foreach ($barangs as $barang) {
            $mergedTransaksis[$barang->nama] = [
                'jenis' => $barang->jenis_barang,
                'minggu1' => 0,
                'minggu2' => 0,
                'minggu3' => 0,
                'minggu4' => 0,
                'minggu5' => 0,
                'total' => 0,
            ];
        }

        foreach ($groupedTransaksis as $week => $weekTransaksis) {
            foreach ($weekTransaksis as $transaksi) {
                foreach ($transaksi->dataTransaksis as $dataTransaksi) {
                    $namaBarang = $dataTransaksi->barang->nama;
                    $mergedTransaksis[$namaBarang]['minggu' . $week] += $dataTransaksi->harga_total;
                    $mergedTransaksis[$namaBarang]['total'] += $dataTransaksi->harga_total;
                }
            }
        }

        $belanjas = Belanja::with('dataBelanjas.barang')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $groupedBelanjas = $belanjas->groupBy(function($date) {
            return Carbon::parse($date->created_at)->weekOfMonth;
        });

        $mergedBelanjas = [];
        $barangs = Barang::all();

        foreach ($barangs as $barang) {
            $mergedBelanjas[$barang->nama] = [
                'jenis' => $barang->jenis_barang,
                'minggu1' => 0,
                'minggu2' => 0,
                'minggu3' => 0,
                'minggu4' => 0,
                'minggu5' => 0,
                'total' => 0,
            ];
        }

        foreach ($groupedBelanjas as $week => $weekBelanjas) {
            foreach ($weekBelanjas as $belanja) {
                foreach ($belanja->dataBelanjas as $dataBelanja) {
                    $namaBarang = $dataBelanja->barang->nama;
                    $mergedBelanjas[$namaBarang]['minggu' . $week] += $dataBelanja->harga_total;
                    $mergedBelanjas[$namaBarang]['total'] += $dataBelanja->harga_total;
                }
            }
        }

        $bulanNama = Carbon::createFromDate($year, $month)->locale('id')->translatedFormat('F');

        return view('jualbeli.bulanan', compact('mergedTransaksis', 'mergedBelanjas', 'month', 'year', 'bulanNama'));
    }

    // Jual Beli Tahunan
    public function laporanJualBeliTahunan(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $year = $request->query('year', Carbon::now()->year);
        $transaksis = Transaksi::with('dataTransaksis.barang')
            ->whereYear('created_at', $year)
            ->get();

        $groupedTransaksis = $transaksis->groupBy(function($date) {
            return Carbon::parse($date->created_at)->month;
        });

        $mergedTransaksis = [
            'Jasa' => array_fill(1, 12, 0),
            'ATK' => array_fill(1, 12, 0),
            'Makanan' => array_fill(1, 12, 0),
            'Minuman' => array_fill(1, 12, 0),
        ];

        foreach ($groupedTransaksis as $month => $monthTransaksis) {
            foreach ($monthTransaksis as $transaksi) {
                foreach ($transaksi->dataTransaksis as $dataTransaksi) {
                    $jenis = $dataTransaksi->barang->jenis_barang;
                    $mergedTransaksis[$jenis][$month] += $dataTransaksi->harga_total;
                }
            }
        }

        $belanjas = Belanja::with('dataBelanjas.barang')
            ->whereYear('created_at', $year)
            ->get();

        $groupedBelanjas = $belanjas->groupBy(function($date) {
            return Carbon::parse($date->created_at)->month;
        });

        $mergedBelanjas = [
            'Jasa' => array_fill(1, 12, 0),
            'ATK' => array_fill(1, 12, 0),
            'Makanan' => array_fill(1, 12, 0),
            'Minuman' => array_fill(1, 12, 0),
        ];

        foreach ($groupedBelanjas as $month => $monthBelanjas) {
            foreach ($monthBelanjas as $belanja) {
                foreach ($belanja->dataBelanjas as $dataBelanja) {
                    $jenis = $dataBelanja->barang->jenis_barang;
                    $mergedBelanjas[$jenis][$month] += $dataBelanja->harga_total;
                }
            }
        }

        $currentYear = Carbon::now()->year;

        return view('jualbeli.tahunan', compact('mergedTransaksis', 'mergedBelanjas', 'year'));
    }

    // Laporan Jual Beli Barang
    // Bulanan
    public function laporanJualBeliBarangBulanan(Request $request)
    {
        $month = $request->query('month', Carbon::now()->month);
        $year = $request->query('year', Carbon::now()->year);

        $transaksis = Transaksi::with('dataTransaksis.barang')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $groupedTransaksis = $transaksis->groupBy(function($date) {
            return Carbon::parse($date->created_at)->weekOfMonth;
        });

        $mergedTransaksis = [];
        $barangs = Barang::all();

        foreach ($barangs as $barang) {
            $mergedTransaksis[$barang->nama] = [
                'jenis' => $barang->jenis_barang,
                'minggu1' => 0,
                'minggu2' => 0,
                'minggu3' => 0,
                'minggu4' => 0,
                'minggu5' => 0,
                'total' => 0,
            ];
        }

        foreach ($groupedTransaksis as $week => $weekTransaksis) {
            foreach ($weekTransaksis as $transaksi) {
                foreach ($transaksi->dataTransaksis as $dataTransaksi) {
                    $namaBarang = $dataTransaksi->barang->nama;
                    $mergedTransaksis[$namaBarang]['minggu' . $week] += $dataTransaksi->quantity;
                    $mergedTransaksis[$namaBarang]['total'] += $dataTransaksi->quantity;
                }
            }
        }

        $belanjas = Belanja::with('dataBelanjas.barang')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $groupedBelanjas = $belanjas->groupBy(function($date) {
            return Carbon::parse($date->created_at)->weekOfMonth;
        });

        $mergedBelanjas = [];
        $barangs = Barang::all();

        foreach ($barangs as $barang) {
            $mergedBelanjas[$barang->nama] = [
                'jenis' => $barang->jenis_barang,
                'minggu1' => 0,
                'minggu2' => 0,
                'minggu3' => 0,
                'minggu4' => 0,
                'minggu5' => 0,
                'total' => 0,
            ];
        }

        foreach ($groupedBelanjas as $week => $weekBelanjas) {
            foreach ($weekBelanjas as $belanja) {
                foreach ($belanja->dataBelanjas as $dataBelanja) {
                    $namaBarang = $dataBelanja->barang->nama;
                    $mergedBelanjas[$namaBarang]['minggu' . $week] += $dataBelanja->quantity;
                    $mergedBelanjas[$namaBarang]['total'] += $dataBelanja->quantity;
                }
            }
        }

        $bulanNama = Carbon::createFromDate($year, $month)->locale('id')->translatedFormat('F');

        return view('jualbeli.barangbulanan', compact('mergedTransaksis', 'mergedBelanjas', 'month', 'year', 'bulanNama'));
    }

    // Tahunan
    public function laporanJualBeliBarangTahunan(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $year = $request->query('year', Carbon::now()->year);
        $transaksis = Transaksi::with('dataTransaksis.barang')
            ->whereYear('created_at', $year)
            ->get();

        $groupedTransaksis = $transaksis->groupBy(function($date) {
            return Carbon::parse($date->created_at)->month;
        });

        $mergedTransaksis = [
            'Jasa' => array_fill(1, 12, 0),
            'ATK' => array_fill(1, 12, 0),
            'Makanan' => array_fill(1, 12, 0),
            'Minuman' => array_fill(1, 12, 0),
        ];

        foreach ($groupedTransaksis as $month => $monthTransaksis) {
            foreach ($monthTransaksis as $transaksi) {
                foreach ($transaksi->dataTransaksis as $dataTransaksi) {
                    $jenis = $dataTransaksi->barang->jenis_barang;
                    $mergedTransaksis[$jenis][$month] += $dataTransaksi->quantity;
                }
            }
        }

        $belanjas = Belanja::with('dataBelanjas.barang')
            ->whereYear('created_at', $year)
            ->get();

        $groupedBelanjas = $belanjas->groupBy(function($date) {
            return Carbon::parse($date->created_at)->month;
        });

        $mergedBelanjas = [
            'Jasa' => array_fill(1, 12, 0),
            'ATK' => array_fill(1, 12, 0),
            'Makanan' => array_fill(1, 12, 0),
            'Minuman' => array_fill(1, 12, 0),
        ];

        foreach ($groupedBelanjas as $month => $monthBelanjas) {
            foreach ($monthBelanjas as $belanja) {
                foreach ($belanja->dataBelanjas as $dataBelanja) {
                    $jenis = $dataBelanja->barang->jenis_barang;
                    $mergedBelanjas[$jenis][$month] += $dataBelanja->quantity;
                }
            }
        }

        $currentYear = Carbon::now()->year;

        return view('jualbeli.barangtahunan', compact('mergedTransaksis', 'mergedBelanjas', 'year'));
    }

    // Cetak Transaksi Jual Beli Tahunan
    public function laporanPenjualanTahunanPDF(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        if (!auth()->user()->hasRole(['admin', 'manager'])) {
            abort(403, 'Unauthorized action.');
        }

        function getIndonesianMonth($monthNumber) {
            $months = [
                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            return $months[$monthNumber];
        }

        $year = $request->query('year', Carbon::now()->year);
        $transaksis = Transaksi::with('dataTransaksis.barang')
            ->whereYear('created_at', $year)
            ->get();

        $groupedTransaksis = $transaksis->groupBy(function($date) {
            return Carbon::parse($date->created_at)->month;
        });

        $reportData = [
            'Jasa' => array_fill(1, 12, 0),
            'ATK' => array_fill(1, 12, 0),
            'Makanan' => array_fill(1, 12, 0),
            'Minuman' => array_fill(1, 12, 0),
        ];

        foreach ($groupedTransaksis as $month => $monthTransaksis) {
            foreach ($monthTransaksis as $transaksi) {
                foreach ($transaksi->dataTransaksis as $dataTransaksi) {
                    $jenis = $dataTransaksi->barang->jenis_barang;
                    $reportData[$jenis][$month] += $dataTransaksi->harga_total;
                }
            }
        }

        $currentMonthNumber = Carbon::now()->month;
        $currentYear = $year;
        $currentDay = Carbon::now()->day;
        $currentDate = $currentDay . ' ' . getIndonesianMonth($currentMonthNumber) . ' ' . $currentYear;

        $data = [
            'months' => [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ],
            'currentDay'  => $currentDay,
            'currentDate' => $currentDate,
            'currentYear' => $currentYear,
            'reportData' => $reportData,
        ];

        $pdf = PDF::loadView('penjualan.tahunan_pdf', $data)->setPaper('a4', 'landscape');
        $fileName = 'LAPORAN_PENJUALAN_TAHUN_' . strtolower($year) . '_' . '.pdf';
        return $pdf->download($fileName);
    }

    public function laporanTahunanPembelianPDF(Request $request)
    {
        if (!auth()->user()->hasRole(['admin', 'manager'])) {
            abort(403, 'Unauthorized action.');
        }

        $year = $request->query('year', Carbon::now()->year);
        $belanjas = Belanja::with('dataBelanjas.barang')
            ->whereYear('created_at', $year)
            ->get();

        $groupedBelanjas = $belanjas->groupBy(function($date) {
            return Carbon::parse($date->created_at)->month;
        });

        $mergedBelanjas = [
            'Jasa' => array_fill(1, 12, 0),
            'ATK' => array_fill(1, 12, 0),
            'Makanan' => array_fill(1, 12, 0),
            'Minuman' => array_fill(1, 12, 0),
        ];

        foreach ($groupedBelanjas as $month => $monthBelanjas) {
            foreach ($monthBelanjas as $belanja) {
                foreach ($belanja->dataBelanjas as $dataBelanja) {
                    $jenis = $dataBelanja->barang->jenis_barang;
                    $mergedBelanjas[$jenis][$month] += $dataBelanja->harga_total;
                }
            }
        }

        $currentYear = Carbon::now()->year;

        $pdf = PDF::loadView('pembelian.tahunan_pdf', compact('mergedBelanjas', 'year', 'currentYear'))->setPaper('a4', 'landscape');

        $fileName = 'LAPORAN_PEMBELIAN_TAHUNAN_' . $year . '.pdf';

        return $pdf->download($fileName);
    }

    // Cetak Jual Beli Barang Tahunan
    public function laporanPenjualanBarangTahunanPDF(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        if (!auth()->user()->hasRole(['admin', 'manager'])) {
            abort(403, 'Unauthorized action.');
        }

        function getIndoMonth($monthNumber) {
            $months = [
                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            return $months[$monthNumber];
        }

        $year = $request->query('year', Carbon::now()->year);
        $transaksis = Transaksi::with('dataTransaksis.barang')
            ->whereYear('created_at', $year)
            ->get();

        $groupedTransaksis = $transaksis->groupBy(function($date) {
            return Carbon::parse($date->created_at)->month;
        });

        $reportData = [
            'Jasa' => array_fill(1, 12, 0),
            'ATK' => array_fill(1, 12, 0),
            'Makanan' => array_fill(1, 12, 0),
            'Minuman' => array_fill(1, 12, 0),
        ];

        foreach ($groupedTransaksis as $month => $monthTransaksis) {
            foreach ($monthTransaksis as $transaksi) {
                foreach ($transaksi->dataTransaksis as $dataTransaksi) {
                    $jenis = $dataTransaksi->barang->jenis_barang;
                    $reportData[$jenis][$month] += $dataTransaksi->quantity;
                }
            }
        }

        $currentMonthNumber = Carbon::now()->month;
        $currentYear = $year;
        $currentDay = Carbon::now()->day;
        $currentDate = $currentDay . ' ' . getIndoMonth($currentMonthNumber) . ' ' . $currentYear;

        $data = [
            'months' => [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ],
            'currentDay'  => $currentDay,
            'currentDate' => $currentDate,
            'currentYear' => $currentYear,
            'reportData' => $reportData,
        ];

        $pdf = PDF::loadView('penjualan.barangtahunan_pdf', $data)->setPaper('a4', 'landscape');
        $fileName = 'LAPORAN_PENJUALAN_BARANG_TAHUN_' . strtolower($year) . '_' . '.pdf';
        return $pdf->download($fileName);
    }

    public function laporanPembelianBarangTahunanPDF(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        if (!auth()->user()->hasRole(['admin', 'manager'])) {
            abort(403, 'Unauthorized action.');
        }

        function getMonthIndo($monthNumber) {
            $months = [
                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            return $months[$monthNumber];
        }

        $year = $request->query('year', Carbon::now()->year);
        $belanjas = Belanja::with('dataBelanjas.barang')
            ->whereYear('created_at', $year)
            ->get();

        $groupedBelanjas = $belanjas->groupBy(function($date) {
            return Carbon::parse($date->created_at)->month;
        });

        $mergedBelanjas = [
            'Jasa' => array_fill(1, 12, 0),
            'ATK' => array_fill(1, 12, 0),
            'Makanan' => array_fill(1, 12, 0),
            'Minuman' => array_fill(1, 12, 0),
        ];

        foreach ($groupedBelanjas as $month => $monthBelanjas) {
            foreach ($monthBelanjas as $belanja) {
                foreach ($belanja->dataBelanjas as $dataBelanja) {
                    $jenis = $dataBelanja->barang->jenis_barang;
                    $mergedBelanjas[$jenis][$month] += $dataBelanja->quantity;
                }
            }
        }

        $currentMonthNumber = Carbon::now()->month;
        $currentYear = $year;
        $currentDay = Carbon::now()->day;
        $currentDate = $currentDay . ' ' . getMonthIndo($currentMonthNumber) . ' ' . $currentYear;

        $data = [
            'months' => [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ],
            'currentDay'  => $currentDay,
            'currentDate' => $currentDate,
            'currentYear' => $currentYear,
            'mergedBelanjas' => $mergedBelanjas,
        ];

        $pdf = PDF::loadView('pembelian.barangtahunan_pdf', $data)->setPaper('a4', 'landscape');
        $fileName = 'LAPORAN_PEMBELIAN_BARANG_TAHUN_' . strtolower($year) . '.pdf';
        return $pdf->download($fileName);
    }
}
