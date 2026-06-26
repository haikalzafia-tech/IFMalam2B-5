<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rak extends Model
{
    use HasFactory;

    protected $fillable = [
        'zona_id',
        'kode_rak',
        'nama_rak',
        'jumlah_baris',
        'jumlah_kolom',
        'kapasitas_total',
        'kapasitas_terpakai',
        'status',
        'keterangan',
    ];

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function varianProduks()
    {
        return $this->hasMany(VarianProduk::class);
    }

    public function transaksiItems()
    {
        return $this->hasMany(TransaksiItem::class);
    }

    public function kartuStoks()
    {
        return $this->hasMany(KartuStok::class);
    }

    // Helper: persentase kapasitas terpakai
    public function getPersentaseKapasitasAttribute(): float
    {
        if ($this->kapasitas_total == 0) return 0;
        return round(($this->kapasitas_terpakai / $this->kapasitas_total) * 100, 1);
    }

    // Helper: sisa kapasitas
    public function getSisaKapasitasAttribute(): int
    {
        return $this->kapasitas_total - $this->kapasitas_terpakai;
    }
}
