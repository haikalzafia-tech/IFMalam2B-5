<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'varian_produk_id',
        'rak_id',
        'nomor_batch',
        'tanggal_produksi',
        'tanggal_kadaluarsa',
        'qty',
        'kondisi',
        'catatan',
    ];

    protected $casts = [
        'tanggal_produksi' => 'date',
        'tanggal_kadaluarsa' => 'date',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function varianProduk()
    {
        return $this->belongsTo(VarianProduk::class);
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }

    public function returItems()
    {
        return $this->hasMany(TransaksiReturItem::class);
    }
}
