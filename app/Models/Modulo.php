<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'modulos';

    protected $fillable = [
        'user_id',
        'nombre',
        'ubicacion',
        'num_charolas',
        'tipo_riego',
        'activo'
    ];

    protected $casts = [
        'num_charolas' => 'integer',
        'activo' => 'boolean'
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function siembras()
    {
        return $this->hasMany(Siembra::class);
    }

    public function sensores()
    {
        return $this->hasMany(Sensor::class);
    }

    // Obtener siembra activa en una charola específica
    public function siembraActivaEnCharola($charola)
    {
        return $this->siembras()
            ->where('charola', $charola)
            ->where('estado', 'Activa')
            ->first();
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function scopeDeUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Verificar disponibilidad de charola
    public function charolaDisponible($charola)
    {
        return !$this->siembras()
            ->where('charola', $charola)
            ->where('estado', 'Activa')
            ->exists();
    }
}
