<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = 'reportes';

    protected $fillable = [
        'user_id',
        'nombre',
        'tipo',
        'periodo_inicio',
        'periodo_fin',
        'formato',
        'archivo_url',
        'tamaño_kb',
        'parametros',
        'descargado'
    ];

    protected $casts = [
        'periodo_inicio' => 'date',
        'periodo_fin' => 'date',
        'parametros' => 'array',
        'descargado' => 'boolean',
        'tamaño_kb' => 'integer'
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeDeUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeRecientes($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Accesores
    public function getTamañoFormateadoAttribute()
    {
        if ($this->tamaño_kb < 1024) {
            return $this->tamaño_kb . ' KB';
        }
        return round($this->tamaño_kb / 1024, 2) . ' MB';
    }

    public function getNombreArchivoAttribute()
    {
        return basename($this->archivo_url);
    }

    // Métodos
    public function marcarComoDescargado()
    {
        $this->update(['descargado' => true]);
    }
}
