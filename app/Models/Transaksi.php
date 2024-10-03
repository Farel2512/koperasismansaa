<?php

// app/Models/Transaksi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['no_transaksi','uang_bayar'];

    public function dataTransaksis()
    {
        return $this->hasMany(DataTransaksi::class);
    }
}
