<?php

namespace App\Observers;

use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class AuditoriaObserver
{
    protected $oldValues = [];

    /**
     * Cuando se crea
     */
    public function created($model)
    {
        Auditoria::create([
            'user_id' => Auth::id(),
            'tabla' => $model->getTable(),
            'accion' => 'create',
            'antes' => null,
            'despues' => $model->getAttributes()
        ]);
    }

    /**
     * Antes de actualizar
     */
    public function updating($model)
    {
        $this->oldValues[spl_object_id($model)] = $model->getOriginal();
    }

    /**
     * Después de actualizar
     */
    public function updated($model)
    {
        $old = $this->oldValues[spl_object_id($model)] ?? [];

        // Solo cambios reales
        $changes = $model->getChanges();

        // quitar updated_at
        unset($changes['updated_at']);

        // filtrar valores anteriores
        $before = array_intersect_key($old, $changes);

        Auditoria::create([
            'user_id' => Auth::id(),
            'tabla' => $model->getTable(),
            'accion' => 'update',
            'antes' => $before,
            'despues' => $changes
        ]);

        unset($this->oldValues[spl_object_id($model)]);
    }

    /**
     * Cuando se elimina
     */
    public function deleted($model)
    {
        Auditoria::create([
            'user_id' => Auth::id(),
            'tabla' => $model->getTable(),
            'accion' => 'delete',
            'antes' => $model->toArray(),
            'despues' => null
        ]);
    }
}
