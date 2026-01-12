<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'no_hp',
        'role', // TAMBAHAN BARU
        'profile_photo_path', // Added profile photo
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    // Method helper untuk cek admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}