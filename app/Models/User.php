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

    public function isAdmin()  {
        return $this->szerep === 'admin';
    }

    public function getAuthenticatedUser()
    {
        if (Auth::check()) {
            return response()->json(Auth::user());
        }

        return response()->json(null, 401);
    }

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

    protected $table = 'users';
    protected $primaryKey = 'azonosito';

    protected $fillable = [
        'name',
        'email',
        'password',
        'szerep',
        'aktiv'
    ];


    

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
