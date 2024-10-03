<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBelanja extends Model
{
    use HasFactory;

    protected $fillable = ['belanja_id', 'barang_id', 'quantity', 'harga_total'];

    public function belanja()
    {
        return $this->belongsTo(Belanja::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
