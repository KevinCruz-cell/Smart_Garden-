<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Configuracion extends Model
{
    protected $table = 'configuraciones';

    protected $fillable = [
        'user_id',
        'tipo',
        'clave',
        'valor'
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

    // Accesores
    public function getValorDecodificadoAttribute()
    {
        return json_decode($this->valor, true);
    }

    // Métodos estáticos para obtener configuraciones
    public static function getConfig($userId, $tipo, $clave, $default = null)
    {
        $config = self::where('user_id', $userId)
            ->where('tipo', $tipo)
            ->where('clave', $clave)
            ->first();

        if (!$config) {
            return $default;
        }

        return json_decode($config->valor, true);
    }

    public static function setConfig($userId, $tipo, $clave, $valor)
    {
        return self::updateOrCreate(
            [
                'user_id' => $userId,
                'tipo' => $tipo,
                'clave' => $clave
            ],
            [
                'valor' => json_encode($valor)
            ]
        );
    }
}
