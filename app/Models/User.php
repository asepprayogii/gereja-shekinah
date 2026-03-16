<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'name', 'email', 'password', 'role', 'no_hp', 'foto',
];

    // Tambahkan method ini di bawah $fillable
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isGembala(): bool
    {
        return $this->role === 'gembala';
    }

    public function isPelayan(): bool
    {
        return $this->role === 'pelayan';
    }

    public function jadwalPelayanan()
    {
        return $this->hasMany(\App\Models\JadwalPelayanan::class);
    }

    public function renungan()
    {
        return $this->hasMany(\App\Models\Renungan::class);
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
