<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'uuid',
        'company_token',
        'avatar',
        'name',
        'bio',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function maskName() {
        
        if (empty($this->name)) {
            return '';
        }

        $nameParts = explode(' ', trim($this->name));

        if (count($nameParts) === 1) {
            return $nameParts[0];
        }

        return $nameParts[0] . ' ' . $nameParts[1];
    }
}
