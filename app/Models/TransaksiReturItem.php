<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiReturItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_retur_id',
        'varian_produk_id',
        'transaksi_item_id',
        'nomor_batch',
        'qty_retur',
        'kondisi_barang',
        'keterangan_kondisi',
    ];

    public function transaksiRetur()
    {
        return $this->belongsTo(TransaksiRetur::class);
    }

    public function varianProduk()
    {
        return $this->belongsTo(VarianProduk::class);
    }

    public function transaksiItem()
    {
        return $this->belongsTo(TransaksiItem::class);
    }
}
