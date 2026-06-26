<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zona extends Model
{
    use HasFactory;

    protected $fillable = [
        'gudang_id',
        'kode_zona',
        'nama_zona',
        'jenis_zona',
        'keterangan',
        'status',
    ];

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function raks()
    {
        return $this->hasMany(Rak::class);
    }
}