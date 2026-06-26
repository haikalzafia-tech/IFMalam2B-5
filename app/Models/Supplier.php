<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_supplier',
        'nama_supplier',
        'jenis_supplier',
        'pic_nama',
        'pic_jabatan',
        'telepon',
        'email',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'npwp',
        'status',
        'keterangan',
    ];

    // Relasi ke transaksi masuk/keluar
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    // Relasi ke retur
    public function transaksiReturs()
    {
        return $this->hasMany(TransaksiRetur::class);
    }
}
