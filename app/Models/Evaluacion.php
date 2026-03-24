<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = 'evaluaciones';

    protected $fillable = [
        'siembra_id',
        'user_id',
        'fecha_evaluacion',
        'rendimiento',
        'eficiencia',
        'observaciones'
    ];

    protected $casts = [
        'fecha_evaluacion' => 'date',
        'rendimiento' => 'decimal:1',
        'eficiencia' => 'integer'
    ];

    // Relaciones
    public function siembra()
    {
        return $this->belongsTo(Siembra::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeDeUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeAltoRendimiento($query)
    {
        return $query->where('rendimiento', '>=', 8);
    }

    public function scopeBajoRendimiento($query)
    {
        return $query->where('rendimiento', '<', 5);
    }

    // Accesores
    public function getRendimientoColorAttribute()
    {
        if ($this->rendimiento >= 8) return 'success';
        if ($this->rendimiento >= 5) return 'warning';
        return 'danger';
    }

    public function getRendimientoPorcentajeAttribute()
    {
        return ($this->rendimiento * 10) . '%';
    }

    public function getEficienciaFormateadaAttribute()
    {
        return $this->eficiencia ? "{$this->eficiencia}%" : 'N/A';
    }
}
