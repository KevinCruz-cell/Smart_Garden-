<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table = 'sensores';

    protected $fillable = [
        'modulo_id',
        'nombre',
        'tipo',
        'unidad',
        'ubicacion',
        'activo',
        'ultima_lectura',
        'ultima_lectura_at'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'ultima_lectura' => 'decimal:2',
        'ultima_lectura_at' => 'datetime'
    ];

    // Relaciones
    public function modulo()
    {
        return $this->belongsTo(Modulo::class);
    }

    public function lecturas()
    {
        return $this->hasMany(LecturaSensor::class);
    }

    public function alertas()
    {
        return $this->hasMany(Alerta::class);
    }

    // Scopes
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    // Obtener última lectura
    public function ultimaLectura()
    {
        return $this->lecturas()->latest()->first();
    }

    // Actualizar última lectura
    public function actualizarUltimaLectura($valor)
    {
        $this->update([
            'ultima_lectura' => $valor,
            'ultima_lectura_at' => now()
        ]);
    }
}
