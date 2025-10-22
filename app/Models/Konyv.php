<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konyv extends Model
{
    /** @use HasFactory<\Database\Factories\KonyvekFactory> */
    use HasFactory;

    protected $table = 'konyveks';
    protected $primaryKey = 'konyv_id';
     public $incrementing = true;

    protected $fillable = [
        'cim', 'szerzo', 'kiado', 'kiadas_ev', 
        'kategoria', 'leiras', 'kep', 'allapot'
    ];

    public function getKepUrlAttribute()
    {
        if (!$this->kep) {
            return null;
        }
        
        return asset('storage/' . $this->kep);
    }
    
}
