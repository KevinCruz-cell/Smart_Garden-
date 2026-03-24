<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'telefono',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relaciones
    public function modulos()
    {
        return $this->hasMany(Modulo::class);
    }

    public function siembras()
    {
        return $this->hasMany(Siembra::class);
    }

    public function alertas()
    {
        return $this->hasMany(Alerta::class);
    }

    public function reportes()
    {
        return $this->hasMany(Reporte::class);
    }

    public function cosechas()
    {
        return $this->hasMany(Cosecha::class);
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }

    public function configuraciones()
    {
        return $this->hasMany(Configuracion::class);
    }

    // Accesor
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }

    // Mutator
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }
}
