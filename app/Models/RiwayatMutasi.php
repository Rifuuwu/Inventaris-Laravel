<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatMutasi extends Model
{
    use HasFactory;
    protected $fillable = ['barang_id', 'asal', 'tujuan', 'tanggal'];
    protected $table = 'riwayat_mutasi';
    protected $dates = ['tanggal'];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}
