<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penghapusan extends Model
{
    use HasFactory;
    protected $fillable = ['barang_id', 'alasan', 'tanggal'];
    protected $table = 'penghapusan';
    protected $dates = ['tanggal'];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}
