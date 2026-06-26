<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KelebihanKapasitas extends Model
{
    use HasFactory;

    protected $table = 'kelebihan_kapasitas';

    protected $fillable = [
        'transaksi_item_id',
        'varian_produk_id',
        'rak_id',
        'qty_muat',
        'qty_lebih',
        'status',
        'rak_tujuan_id',
        'transaksi_retur_id',
        'diselesaikan_oleh',
        'diselesaikan_pada',
    ];

    protected $casts = [
        'diselesaikan_pada' => 'datetime',
    ];

    public function transaksiItem()
    {
        return $this->belongsTo(TransaksiItem::class);
    }

    public function varianProduk()
    {
        return $this->belongsTo(VarianProduk::class);
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }

    public function rakTujuan()
    {
        return $this->belongsTo(Rak::class, 'rak_tujuan_id');
    }

    public function transaksiRetur()
    {
        return $this->belongsTo(TransaksiRetur::class);
    }
}
