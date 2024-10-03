<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\BelanjaController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/login',[LoginController::class,'login'])->name('login');
Route::post('/login-proses',[LoginController::class,'loginproses'])->name('login-proses');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');

    // Admin
    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin'], 'as' => 'admin.'], function(){
        // Dashboard
        Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');

        // User
        Route::get('/user',[UserController::class,'user'])->name('user');
        Route::get('/user/create',[UserController::class,'create'])->name('user.create');
        Route::post('/user/store',[UserController::class,'store'])->name('user.store');
        Route::get('/user/edit/{name}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/update/{name}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/delete/{id}',[UserController::class,'delete'])->name('user.delete');

        // Barang
        Route::get('/barang',[BarangController::class,'barang'])->name('barang');
        Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
        Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
        Route::get('/barang/edit/{nama}', [BarangController::class, 'edit'])->name('barang.edit');
        Route::put('/barang/update/{nama}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/barang/delete/{id}', [BarangController::class, 'delete'])->name('barang.delete');

        // Transaksi
        Route::get('/transaksi', [TransaksiController::class, 'transaksi'])->name('transaksi.index');
        Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
        Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::delete('/transaksi/{id}', [TransaksiController::class, 'delete'])->name('transaksi.delete');

        // Belanja
        Route::get('/belanja', [BelanjaController::class, 'belanja'])->name('belanja.index');
        Route::get('/belanja/create', [BelanjaController::class, 'create'])->name('belanja.create');
        Route::post('/belanja/store', [BelanjaController::class, 'store'])->name('belanja.store');
        Route::delete('/belanja/{id}', [BelanjaController::class, 'delete'])->name('belanja.delete');

        // Laporan Penjualan
        // Bulanan
        Route::get('/penjualan/bulanan', [LaporanController::class, 'laporanPenjualanBulanan'])->name('penjualan.bulanan');
        Route::get('/penjualan/bulanan_pdf', [LaporanController::class, 'laporanPenjualanBulananPDF'])->name('penjualan.bulanan_pdf');
        // Tahunan
        Route::get('/penjualan/tahunan', [LaporanController::class, 'laporanPenjualanTahunan'])->name('penjualan.tahunan');
        Route::get('/penjualan/tahunan_pdf', [LaporanController::class, 'laporanPenjualanTahunanPDF'])->name('penjualan.tahunan_pdf');

        // Laporan Pembelian
        // Bulanan
        Route::get('/pembelian/bulanan', [LaporanController::class, 'laporanPembelianBulanan'])->name('pembelian.bulanan');
        Route::get('/pembelian/bulanan_pdf', [LaporanController::class, 'laporanBulananPembelianPDF'])->name('pembelian.bulanan_pdf');
        // Tahunan
        Route::get('/pembelian/tahunan', [LaporanController::class, 'laporanPembelianTahunan'])->name('pembelian.tahunan');
        Route::get('/pembelian/tahunan_pdf', [LaporanController::class, 'laporanTahunanPembelianPDF'])->name('pembelian.tahunan_pdf');
    });

    // Manager
    Route::group(['prefix' => 'manager', 'middleware' => ['auth', 'role:manager'], 'as' => 'manager.'], function(){
        // Dashboard
        Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');

        // User
        Route::get('/user',[UserController::class,'user'])->name('user');
        Route::get('/user/create',[UserController::class,'create'])->name('user.create');
        Route::post('/user/store',[UserController::class,'store'])->name('user.store');
        Route::get('/user/edit/{name}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/update/{name}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/delete/{id}',[UserController::class,'delete'])->name('user.delete');

        // Barang
        Route::get('/barang',[BarangController::class,'barang'])->name('barang');
        Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
        Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
        Route::get('/barang/edit/{nama}', [BarangController::class, 'edit'])->name('barang.edit');
        Route::put('/barang/update/{nama}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/barang/delete/{id}', [BarangController::class, 'delete'])->name('barang.delete');

        // Transaksi
        Route::get('/transaksi', [TransaksiController::class, 'transaksi'])->name('transaksi.index');
        Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
        Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::delete('/transaksi/{id}', [TransaksiController::class, 'delete'])->name('transaksi.delete');
        Route::get('/transaksi/cetak/{id}', [TransaksiController::class, 'cetak'])->name('transaksi.cetak');

        // Belanja
        Route::get('/belanja', [BelanjaController::class, 'belanja'])->name('belanja.index');
        Route::get('/belanja/create', [BelanjaController::class, 'create'])->name('belanja.create');
        Route::post('/belanja/store', [BelanjaController::class, 'store'])->name('belanja.store');
        Route::delete('/belanja/{id}', [BelanjaController::class, 'delete'])->name('belanja.delete');
        Route::get('/belanja/cetak/{id}', [BelanjaController::class, 'cetak'])->name('belanja.cetak');

        // Laporan Jual Beli
        Route::get('/jualbeli/bulanan', [LaporanController::class, 'laporanJualBeliBulanan'])->name('jualbeli.bulanan');
        Route::get('/jualbeli/tahunan', [LaporanController::class, 'laporanJualBeliTahunan'])->name('jualbeli.tahunan');
        Route::get('/jualbeli/barangbulanan', [LaporanController::class, 'laporanJualBeliBarangBulanan'])->name('jualbeli.barangbulanan');
        Route::get('/jualbeli/barangtahunan', [LaporanController::class, 'laporanJualBeliBarangTahunan'])->name('jualbeli.barangtahunan');
        // Cetak Laporan Jual Beli Tahunan
        Route::get('/penjualan/tahunan_pdf', [LaporanController::class, 'laporanPenjualanTahunanPDF'])->name('penjualan.tahunan_pdf');
        Route::get('/penjualan/barangtahunan_pdf', [LaporanController::class, 'laporanPenjualanBarangTahunanPDF'])->name('penjualan.barangtahunan_pdf');
        Route::get('/pembelian/tahunan_pdf', [LaporanController::class, 'laporanTahunanPembelianPDF'])->name('pembelian.tahunan_pdf');
        Route::get('/pembelian/barangtahunan_pdf', [LaporanController::class, 'laporanPembelianBarangTahunanPDF'])->name('pembelian.barangtahunan_pdf');
    });

    // Kasir
    Route::group(['prefix' => 'kasir', 'middleware' => ['auth', 'role:kasir'], 'as' => 'kasir.'], function(){
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        // Barang
        Route::get('/barang', [BarangController::class, 'barang'])->name('barang');

        // Transaksi
        Route::get('/transaksi', [TransaksiController::class, 'transaksi'])->name('transaksi.index');
        Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
        Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::delete('/transaksi/{id}', [TransaksiController::class, 'delete'])->name('transaksi.delete');
        Route::get('/transaksi/cetak/{id}', [TransaksiController::class, 'cetak'])->name('transaksi.cetak');
    });
