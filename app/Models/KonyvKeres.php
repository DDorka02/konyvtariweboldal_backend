<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonyvKeres extends Model
{
    /** @use HasFactory<\Database\Factories\KonyvKeresekFactory> */
    use HasFactory;

    protected $table = 'konyv_kereseks';
    protected $primaryKey = 'keres_id';

    protected $fillable = [
        'felhasznalo_id', 'konyv_id', 'statusz'
    ];

    public function felhasznalo()
    {
        return $this->belongsTo(User::class, 'felhasznalo_id');
    }

    public function konyv()
    {
        return $this->belongsTo(Konyv::class, 'konyv_id');
    }
}
