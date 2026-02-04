<?php

namespace AppMyIntelli;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Campos que se ocultan en las respuestas JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // --- MÉTODOS OBLIGATORIOS PARA JWT ---
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}