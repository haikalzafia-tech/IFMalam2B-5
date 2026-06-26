<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VarianProduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'rak_id',
        'nomor_sku',
        'nama_varian',
        'gambar_varian',
        'berat',
        'dimensi',
        'stok_varian',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // Rak utama/default (dipertahankan untuk kompatibilitas tampilan lama)
    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }

    // SEMUA lokasi rak tempat varian ini disimpan, beserta qty masing-masing
    public function lokasiStoks()
    {
        return $this->hasMany(LokasiStok::class);
    }

    public function transaksiItems()
    {
        return $this->hasMany(TransaksiItem::class);
    }

    public function kartuStoks()
    {
        return $this->hasMany(KartuStok::class);
    }

    public function stokOpnameItems()
    {
        return $this->hasMany(StokOpnameItem::class);
    }

    // Lokasi lengkap barang: Gudang > Zona > Rak (lokasi utama/default)
    public function getLokasLengkapAttribute(): string
    {
        if (!$this->rak) return 'Belum ditentukan';
        $rak = $this->rak;
        $zona = $rak->zona;
        $gudang = $zona->gudang;
        return "{$gudang->nama_gudang} > {$zona->nama_zona} > {$rak->nama_rak}";
    }

    // Daftar semua lokasi (rak) tempat varian ini ada stoknya, diurutkan dari qty terbanyak
    public function getDaftarLokasiAttribute()
    {
        return $this->lokasiStoks()
            ->with('rak.zona.gudang')
            ->where('qty', '>', 0)
            ->orderByDesc('qty')
            ->get();
    }
}
