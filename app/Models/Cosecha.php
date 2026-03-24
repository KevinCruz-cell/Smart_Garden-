<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cosecha extends Model
{
    protected $table = 'cosechas';

    protected $fillable = [
        'siembra_id',
        'user_id',
        'fecha_cosecha',
        'cantidad_kg',
        'calidad',
        'observaciones'
    ];

    protected $casts = [
        'fecha_cosecha' => 'date',
        'cantidad_kg' => 'decimal:2'
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

    public function scopeEnFecha($query, $fecha)
    {
        return $query->whereDate('fecha_cosecha', $fecha);
    }

    public function scopePorCalidad($query, $calidad)
    {
        return $query->where('calidad', $calidad);
    }

    public function scopeEntreFechas($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha_cosecha', [$inicio, $fin]);
    }

    // Accesores
    public function getCalidadColorAttribute()
    {
        return match($this->calidad) {
            'Excelente' => 'success',
            'Buena' => 'info',
            'Regular' => 'warning',
            'Mala' => 'danger',
            default => 'secondary'
        };
    }

    public function getCantidadFormateadaAttribute()
    {
        return number_format($this->cantidad_kg, 2) . ' kg';
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::created(function ($cosecha) {
            // Actualizar la siembra relacionada
            $cosecha->siembra->update([
                'estado' => 'Completada',
                'fecha_cosecha_real' => $cosecha->fecha_cosecha
            ]);
        });
    }
}
