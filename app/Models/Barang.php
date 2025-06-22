<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $fillable = ['nama', 'kode_barang', 'kategori_id', 'lokasi_id', 'jumlah'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function riwayatMutasi()
    {
        return $this->hasMany(RiwayatMutasi::class);
    }

    public function penghapusan()
    {
        return $this->hasMany(Penghapusan::class);
    }

    // Helper method to check if item is in mutation process
    public function isInMutation()
    {
        return $this->riwayatMutasi()
                   ->whereDate('tanggal', '>=', Carbon::today())
                   ->exists();
    }

    // Helper method to check if item is active
    public function isActive()
    {
        return $this->jumlah > 0 && 
               !$this->isInMutation();
    }
}