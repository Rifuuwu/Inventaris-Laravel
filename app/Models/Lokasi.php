<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lokasi extends Model
{
    use HasFactory;
    protected $fillable = ['nama_lokasi', 'gedung'];
    protected $table = 'lokasi';

    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class);
    }
}
