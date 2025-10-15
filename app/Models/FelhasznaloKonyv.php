<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FelhasznaloKonyv extends Model
{
    /** @use HasFactory<\Database\Factories\FelhasznaloKonyvekFactory> */
    use HasFactory;

    protected $table = 'felhasznalo_konyveks';
    protected $primaryKey = 'felhasznalo_konyv_id';

    protected $fillable = [
        'felhasznalo_id', 'konyv_id', 'statusz', 'megjegyzes'
    ];

    // 🔥 Reláció a könyvhöz
    public function konyv()
    {
        return $this->belongsTo(Konyv::class, 'konyv_id', 'konyv_id');
    }

    // 🔥 Reláció a felhasználóhoz
    public function felhasznalo()
    {
        return $this->belongsTo(User::class, 'felhasznalo_id');
    }
}
