<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
    ];

    public function getFullNameAttribute()
    {
        return $this->attributes['firstname'] . ' ' . $this->attributes['lastname'];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }
}
