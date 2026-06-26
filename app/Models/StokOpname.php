<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StokOpname extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_opname',
        'gudang_id',
        'tanggal_opname',
        'status',
        'petugas',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_opname' => 'date',
    ];

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function items()
    {
        return $this->hasMany(StokOpnameItem::class);
    }

    public static function generateNomor(): string
    {
        $date = now()->format('Ymd');
        $last = self::whereDate('created_at', today())->count() + 1;
        return "OPN-{$date}-" . str_pad($last, 4, '0', STR_PAD_LEFT);
    }
}
