<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authentication
{
    use HasApiTokens;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = ['password'];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reserve::class);
    }

    public function hotels(): HasMany
    {
        return $this->hasMany(Hotel::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
