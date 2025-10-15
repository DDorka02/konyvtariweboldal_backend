<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jelentes extends Model
{
    /** @use HasFactory<\Database\Factories\JelentesekFactory> */
    use HasFactory;

    protected $table = 'jelenteseks';
    protected $primaryKey = 'jelentes_id';

    protected $fillable = [
        'bejelento_id', 'cel_felhasznalo_id', 'cel_konyv_id', 'tipus', 'leiras', 'statusz', 'admin_id', 'admin_megjegyzes'
    ];
}
