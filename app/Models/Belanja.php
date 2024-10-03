<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Belanja extends Model
{
    use HasFactory;

    protected $fillable = ['no_belanja', 'uang_bayar'];

    public function dataBelanjas()
    {
        return $this->hasMany(DataBelanja::class);
    }
}
