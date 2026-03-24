<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    protected $table = 'alertas';

    protected $fillable = [
        'user_id',
        'modulo_id',
        'sensor_id',
        'siembra_id',
        'tipo',
        'titulo',
        'mensaje',
        'prioridad',
        'estado',
        'fecha_resolucion'
    ];

    protected $casts = [
        'fecha_resolucion' => 'datetime',
        'created_at' => 'datetime'
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function modulo()
    {
        return $this->belongsTo(Modulo::class);
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

    public function siembra()
    {
        return $this->belongsTo(Siembra::class);
    }

    // Scopes
    public function scopePendiente($query)
    {
        return $query->where('estado', 'Pendiente');
    }

    public function scopeResuelta($query)
    {
        return $query->where('estado', 'Resuelta');
    }

    public function scopeDePrioridad($query, $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    public function scopeDeUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Accesores
    public function getPrioridadColorAttribute()
    {
        return match($this->prioridad) {
            'Crítica' => 'danger',
            'Alta' => 'warning',
            'Media' => 'info',
            'Baja' => 'secondary',
            default => 'primary'
        };
    }

    public function getEstadoColorAttribute()
    {
        return match($this->estado) {
            'Pendiente' => 'warning',
            'Resuelta' => 'success',
            'Ignorada' => 'secondary',
            default => 'primary'
        };
    }

    public function getTiempoTranscurridoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    // Métodos
    public function marcarComoResuelta()
    {
        $this->update([
            'estado' => 'Resuelta',
            'fecha_resolucion' => now()
        ]);
    }

    public function marcarComoIgnorada()
    {
        $this->update([
            'estado' => 'Ignorada',
            'fecha_resolucion' => now()
        ]);
    }
}
