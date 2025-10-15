<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nev',
        'email',
        'password',
        'telefon',
        'varos',
        'cim',
        'szerep',
        'aktiv'
    ];


    public function konyveim()
{
    return $this->hasMany(FelhasznaloKonyv::class, 'felhasznalo_id');
}

public function kereseseim()
{
    return $this->hasMany(KonyvKeres::class, 'felhasznalo_id');
}

public function jelenteseim()
{
    return $this->hasMany(Jelentes::class, 'bejelento_id');
}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
