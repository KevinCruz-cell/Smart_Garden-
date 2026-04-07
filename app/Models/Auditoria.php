<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table = 'auditorias';

    protected $fillable = [
        'user_id',
        'tabla',
        'accion',
        'antes',
        'despues'
    ];

    protected $casts = [
        'antes' => 'array',
        'despues' => 'array'
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
