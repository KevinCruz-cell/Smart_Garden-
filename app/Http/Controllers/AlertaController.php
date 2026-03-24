<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Modulo;
use Illuminate\Http\Request;

class AlertaController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $alertas = Alerta::with(['modulo', 'sensor'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Cambiado de get() a paginate(10)

        $stats = [
            'pendientes' => Alerta::where('user_id', $user->id)->where('estado', 'Pendiente')->count(),
            'resueltas_hoy' => Alerta::where('user_id', $user->id)
                ->whereDate('fecha_resolucion', now()->toDateString())
                ->count(),
            'criticas' => Alerta::where('user_id', $user->id)
                ->where('prioridad', 'Crítica')
                ->where('estado', 'Pendiente')
                ->count(),
            'total_mes' => Alerta::where('user_id', $user->id)
                ->whereMonth('created_at', now()->month)
                ->count(),
        ];

        // Obtener módulos para el filtro
        $modulos = Modulo::where('user_id', $user->id)->get();

        return view('Alertas.alertas', compact('alertas', 'stats', 'modulos'));
    }

    public function resolver(string $id)
    {
        $alerta = Alerta::where('user_id', auth()->id())->findOrFail($id);
        $alerta->marcarComoResuelta();

        return redirect()->back()->with('success', 'Alerta resuelta correctamente');
    }

    public function marcarTodasComoLeidas()
    {
        Alerta::where('user_id', auth()->id())
            ->where('estado', 'Pendiente')
            ->update([
                'estado' => 'Resuelta',
                'fecha_resolucion' => now()
            ]);

        return redirect()->back()->with('success', 'Todas las alertas fueron marcadas como resueltas');
    }

    public function destroy(string $id)
    {
        $alerta = Alerta::where('user_id', auth()->id())->findOrFail($id);
        $alerta->delete();

        return redirect()->back()->with('success', 'Alerta eliminada correctamente');
    }

    /**
     * Mostrar detalles de una alerta (opcional)
     */
    public function show(string $id)
    {
        $alerta = Alerta::with(['modulo', 'sensor', 'siembra.cultivo'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return response()->json($alerta);
    }
}
