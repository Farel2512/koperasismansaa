<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Barang::create([
            'no' => Str::random(10),
            'nama' => 'Barang 1',
            'harga' => 10000.00,
            'stok' => 50,
            'satuan' => 'pcs',
            'photo' => 'default.jpg',
        ]);

        Barang::create([
            'no' => Str::random(10),
            'nama' => 'Barang 2',
            'harga' => 20000.00,
            'stok' => 30,
            'satuan' => 'pcs',
            'photo' => 'default.jpg',
        ]);

        Barang::create([
            'no' => Str::random(10),
            'nama' => 'Barang 3',
            'harga' => 15000.00,
            'stok' => 20,
            'satuan' => 'pcs',
            'photo' => 'default.jpg',
        ]);
    }
}
