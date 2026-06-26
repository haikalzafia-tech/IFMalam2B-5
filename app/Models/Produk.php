<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_produk_id',
        'kode_produk',
        'nama_produk',
        'merek',
        'satuan',
        'deskripsi_produk',
        'stok_minimum',
    ];

    public function kategoriProduk()
    {
        return $this->belongsTo(KategoriProduk::class);
    }

    public function varianProduks()
    {
        return $this->hasMany(VarianProduk::class);
    }

    // Total stok semua varian
    public function getTotalStokAttribute(): int
    {
        return $this->varianProduks()->sum('stok_varian');
    }

    // Cek apakah stok di bawah minimum
    public function getIsBawahMinimumAttribute(): bool
    {
        return $this->total_stok < $this->stok_minimum;
    }
}
