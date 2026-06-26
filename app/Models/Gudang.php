<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gudang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_gudang',
        'nama_gudang',
        'alamat',
        'kota',
        'provinsi',
        'pic_nama',
        'pic_telepon',
        'status',
        'keterangan',
    ];

    public function zonas()
    {
        return $this->hasMany(Zona::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function kartuStoks()
    {
        return $this->hasMany(KartuStok::class);
    }

    public function stokOpnames()
    {
        return $this->hasMany(StokOpname::class);
    }

    // Ambil semua rak dalam gudang ini (via zona)
    public function raks()
    {
        return $this->hasManyThrough(Rak::class, Zona::class);
    }
}
