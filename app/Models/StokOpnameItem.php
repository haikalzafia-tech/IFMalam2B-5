<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StokOpnameItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'stok_opname_id',
        'varian_produk_id',
        'rak_id',
        'stok_sistem',
        'stok_fisik',
        'keterangan',
    ];

    public function stokOpname()
    {
        return $this->belongsTo(StokOpname::class);
    }

    public function varianProduk()
    {
        return $this->belongsTo(VarianProduk::class);
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }

    // Selisih stok fisik vs sistem
    public function getSelisihAttribute(): int
    {
        return $this->stok_fisik - $this->stok_sistem;
    }
}
