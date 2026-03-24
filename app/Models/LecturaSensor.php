<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LecturaSensor extends Model
{
    protected $table = 'lecturas_sensores';

    public $timestamps = false; // Usamos created_at manualmente

    protected $fillable = [
        'sensor_id',
        'valor',
        'created_at'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'created_at' => 'datetime'
    ];

    // Relaciones
    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

    // Scope para lecturas recientes
    public function scopeRecientes($query, $limite = 24)
    {
        return $query->orderBy('created_at', 'desc')->limit($limite);
    }

    // Scope para lecturas por período
    public function scopeEnPeriodo($query, $inicio, $fin)
    {
        return $query->whereBetween('created_at', [$inicio, $fin]);
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lectura) {
            $lectura->created_at = $lectura->created_at ?? now();
        });

        static::created(function ($lectura) {
            // Actualizar última lectura del sensor
            $lectura->sensor->actualizarUltimaLectura($lectura->valor);
        });
    }
}
