<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    // OOP Encapsulation: Mengamankan atribut yang boleh diisi secara massal (Mass Assignment)
    protected $fillable = [
        'nama_produk',
        'deskripsi_produk',
        'kategori_produk_id'
    ];

    // Relasi OOP (Polymorphism/Association): Setiap produk memiliki satu kategori
    public function Kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id');
    }

    // Relasi OOP (Association): Satu produk bisa memiliki banyak varian (1 to Many)
    public function Varian()
    {
        return $this->hasMany(VarianProduk::class);
    }
}
