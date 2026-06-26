<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_transaksi',
        'jenis_transaksi',
        'gudang_id',
        'supplier_id',
        'jumlah_barang',
        'nomor_po',
        'nomor_surat_jalan',
        'tanggal_transaksi',
        'tanggal_kadaluarsa_po',
        'status',
        'keterangan',
        'petugas',
        'penerima',
        'tujuan',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
        'tanggal_kadaluarsa_po' => 'date',
    ];

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(TransaksiItem::class);
    }

    public function returs()
    {
        return $this->hasMany(TransaksiRetur::class);
    }

    // Auto-generate nomor transaksi
    public static function generateNomor(string $jenis): string
    {
        $prefix = $jenis === 'pemasukan' ? 'TM' : 'TK';
        $date = now()->format('Ymd');
        $last = self::where('jenis_transaksi', $jenis)
            ->whereDate('created_at', today())
            ->count() + 1;
        return "{$prefix}-{$date}-" . str_pad($last, 4, '0', STR_PAD_LEFT);
    }
}
