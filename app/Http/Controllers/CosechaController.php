<?php

namespace App\Http\Controllers;

use App\Models\Cosecha;
use App\Models\Siembra;
use App\Models\Cultivo;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CosechaController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Cosecha::with(['siembra.cultivo', 'siembra.modulo'])
            ->where('user_id', $user->id);

        // Aplicar filtros
        if ($request->filled('cultivo')) {
            $query->whereHas('siembra', function($q) use ($request) {
                $q->where('cultivo_id', $request->cultivo);
            });
        }

        if ($request->filled('desde')) {
            $query->whereDate('fecha_cosecha', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('fecha_cosecha', '<=', $request->hasta);
        }

        if ($request->filled('calidad')) {
            $query->where('calidad', $request->calidad);
        }

        $cosechas = $query->orderBy('fecha_cosecha', 'desc')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => Cosecha::where('user_id', $user->id)->count(),
            'peso_total' => Cosecha::where('user_id', $user->id)
                ->whereMonth('fecha_cosecha', now()->month)
                ->sum('cantidad_kg'),
            'pendientes' => Siembra::where('user_id', $user->id)
                ->where('estado', 'Activa')
                ->whereNotNull('fecha_estimada_cosecha')
                ->where('fecha_estimada_cosecha', '<=', now()->addDays(7))
                ->count(),
            'calidad_promedio' => Cosecha::where('user_id', $user->id)->avg('calidad'),
        ];

        return view('Cosechas.cosechas', compact('cosechas', 'stats'));
    }

    public function create()
    {
        $siembras = Siembra::with(['cultivo', 'modulo'])
            ->where('user_id', auth()->id())
            ->where('estado', 'Activa')
            ->doesntHave('cosecha')
            ->get();

        if ($siembras->isEmpty()) {
            return redirect()->route('cosechas.index')
                ->with('info', 'No hay siembras activas disponibles para cosechar. Crea una siembra primero.');
        }

        return view('Cosechas.create', compact('siembras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siembra_id' => 'required|exists:siembras,id',
            'fecha_cosecha' => 'required|date',
            'cantidad_kg' => 'required|numeric|min:0',
            'calidad' => 'required|in:Excelente,Buena,Regular,Mala',
            'observaciones' => 'nullable|string|max:500',
        ]);

        // Verificar que la siembra pertenezca al usuario
        $siembra = Siembra::where('user_id', auth()->id())
            ->where('id', $request->siembra_id)
            ->firstOrFail();

        // Verificar que la siembra no tenga ya una cosecha
        if ($siembra->cosecha) {
            return redirect()->back()
                ->with('error', 'Esta siembra ya tiene una cosecha registrada.')
                ->withInput();
        }

        Cosecha::create([
            'siembra_id' => $request->siembra_id,
            'user_id' => auth()->id(),
            'fecha_cosecha' => $request->fecha_cosecha,
            'cantidad_kg' => $request->cantidad_kg,
            'calidad' => $request->calidad,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('cosechas.index')
            ->with('success', 'Cosecha registrada correctamente');
    }

    public function show(string $id)
    {
        $cosecha = Cosecha::with(['siembra.cultivo', 'siembra.modulo', 'siembra.evaluacion'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('Cosechas.show', compact('cosecha'));
    }

    public function edit(string $id)
    {
        $cosecha = Cosecha::with(['siembra.cultivo', 'siembra.modulo'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('Cosechas.edit', compact('cosecha'));
    }

    public function update(Request $request, string $id)
    {
        $cosecha = Cosecha::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'fecha_cosecha' => 'required|date',
            'cantidad_kg' => 'required|numeric|min:0',
            'calidad' => 'required|in:Excelente,Buena,Regular,Mala',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $cosecha->update($request->all());

        return redirect()->route('cosechas.index')
            ->with('success', 'Cosecha actualizada correctamente');
    }

    public function destroy(string $id)
    {
        try {
            $cosecha = Cosecha::where('user_id', auth()->id())->findOrFail($id);
            $cosecha->delete();

            return redirect()->route('cosechas.index')
                ->with('success', 'Cosecha eliminada correctamente');

        } catch (QueryException $e) {
            return redirect()->route('cosechas.index')
                ->with('error', 'Error al eliminar la cosecha. Por favor intenta de nuevo.');
        }
    }
}
