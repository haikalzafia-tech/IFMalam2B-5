<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LokasiStok extends Model
{
    use HasFactory;

    protected $table = 'lokasi_stoks';

    protected $fillable = [
        'varian_produk_id',
        'rak_id',
        'qty',
    ];

    public function varianProduk()
    {
        return $this->belongsTo(VarianProduk::class);
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }
}
