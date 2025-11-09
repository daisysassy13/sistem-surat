<?php

// FILE 1: app/Models/User.php
// File ini sudah ada, tinggal EDIT saja

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relasi
    public function suratMasuk()
    {
        return $this->hasMany(SuratMasuk::class, 'created_by');
    }

    public function suratKeluar()
    {
        return $this->hasMany(SuratKeluar::class, 'created_by');
    }

    // Helper method
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
