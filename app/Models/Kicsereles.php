<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kicsereles extends Model
{
    /** @use HasFactory<\Database\Factories\KicserelesekFactory> */
    use HasFactory;

    use HasFactory;

    protected $table = 'kicsereleseks';
    protected $primaryKey = 'csere_id';

    protected $fillable = [
        'felado_id', 'fogado_id', 'felado_konyv_id', 'fogado_konyv_id', 'statusz'
    ];
}
