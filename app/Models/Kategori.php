<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;
     protected $fillable = ['nama_kategori'];
     protected $table = 'kategori';

    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class);
    }
}
