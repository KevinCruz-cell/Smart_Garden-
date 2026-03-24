<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Siembra;
use App\Models\Cultivo;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class EvaluacionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Evaluacion::with(['siembra.cultivo', 'siembra.modulo'])
            ->where('user_id', $user->id);

        // Aplicar filtros
        if ($request->filled('cultivo')) {
            $query->whereHas('siembra', function($q) use ($request) {
                $q->where('cultivo_id', $request->cultivo);
            });
        }

        if ($request->filled('desde')) {
            $query->whereDate('fecha_evaluacion', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('fecha_evaluacion', '<=', $request->hasta);
        }

        if ($request->filled('rendimiento_min')) {
            $query->where('rendimiento', '>=', $request->rendimiento_min);
        }

        $evaluaciones = $query->orderBy('fecha_evaluacion', 'desc')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => Evaluacion::where('user_id', $user->id)->count(),
            'promedio' => Evaluacion::where('user_id', $user->id)->avg('rendimiento'),
            'pendientes' => Siembra::where('user_id', $user->id)
                ->where('estado', 'Completada')
                ->doesntHave('evaluacion')
                ->count(),
            'eficiencia' => Evaluacion::where('user_id', $user->id)->avg('eficiencia'),
        ];

        // Para los filtros
        $cultivos = Cultivo::all();

        return view('Evaluaciones.evaluaciones', compact('evaluaciones', 'stats', 'cultivos'));
    }

    public function create()
    {
        $siembras = Siembra::with(['cultivo', 'modulo'])
            ->where('user_id', auth()->id())
            ->where('estado', 'Completada')
            ->doesntHave('evaluacion')
            ->get();

        if ($siembras->isEmpty()) {
            return redirect()->route('evaluaciones.index')
                ->with('info', 'No hay siembras completadas disponibles para evaluar.');
        }

        return view('Evaluaciones.create', compact('siembras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siembra_id' => 'required|exists:siembras,id',
            'fecha_evaluacion' => 'required|date',
            'rendimiento' => 'required|numeric|min:0|max:10',
            'eficiencia' => 'nullable|integer|min:0|max:100',
            'observaciones' => 'nullable|string|max:500',
        ]);

        // Verificar que la siembra pertenezca al usuario
        $siembra = Siembra::where('user_id', auth()->id())
            ->where('id', $request->siembra_id)
            ->firstOrFail();

        // Verificar que la siembra no tenga ya una evaluación
        if ($siembra->evaluacion) {
            return redirect()->back()
                ->with('error', 'Esta siembra ya tiene una evaluación registrada.')
                ->withInput();
        }

        Evaluacion::create([
            'siembra_id' => $request->siembra_id,
            'user_id' => auth()->id(),
            'fecha_evaluacion' => $request->fecha_evaluacion,
            'rendimiento' => $request->rendimiento,
            'eficiencia' => $request->eficiencia,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluación registrada correctamente');
    }

    public function show(string $id)
    {
        $evaluacion = Evaluacion::with(['siembra.cultivo', 'siembra.modulo', 'user'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('Evaluaciones.show', compact('evaluacion'));
    }

    public function edit(string $id)
    {
        $evaluacion = Evaluacion::where('user_id', auth()->id())->findOrFail($id);

        // Obtener la siembra relacionada para mostrar información
        $siembra = $evaluacion->siembra;

        return view('Evaluaciones.edit', compact('evaluacion', 'siembra'));
    }

    public function update(Request $request, string $id)
    {
        $evaluacion = Evaluacion::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'fecha_evaluacion' => 'required|date',
            'rendimiento' => 'required|numeric|min:0|max:10',
            'eficiencia' => 'nullable|integer|min:0|max:100',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $evaluacion->update($request->all());

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluación actualizada correctamente');
    }

    public function destroy(string $id)
    {
        try {
            $evaluacion = Evaluacion::where('user_id', auth()->id())->findOrFail($id);
            $evaluacion->delete();

            return redirect()->route('evaluaciones.index')
                ->with('success', 'Evaluación eliminada correctamente');

        } catch (QueryException $e) {
            return redirect()->route('evaluaciones.index')
                ->with('error', 'Error al eliminar la evaluación. Por favor intenta de nuevo.');
        }
    }
}
