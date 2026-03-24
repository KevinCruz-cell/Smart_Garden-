<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siembra;
use App\Models\Alerta;
use App\Models\Cosecha;
use App\Models\Modulo;
use App\Models\Cultivo;
use App\Models\Sensor;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Estadísticas generales
        $stats = [
            'total_cultivos' => Cultivo::count(), // Cultivos es catálogo general
            'siembras_activas' => Siembra::where('user_id', $user->id)->where('estado', 'Activa')->count(),
            'alertas_pendientes' => Alerta::where('user_id', $user->id)->where('estado', 'Pendiente')->count(),
            'total_siembras' => Siembra::where('user_id', $user->id)->count(),
            'cosechas_mes' => Cosecha::where('user_id', $user->id)
                ->whereMonth('fecha_cosecha', now()->month)
                ->sum('cantidad_kg'),
            'inversion_total' => 0, // Temporal
            'ingresos_estimados' => Cosecha::where('user_id', $user->id)
                    ->whereMonth('fecha_cosecha', now()->month)
                    ->sum('cantidad_kg') * 5, // Estimado a $5 por kg
        ];

        // Siembras recientes
        $siembrasRecientes = Siembra::with(['cultivo', 'modulo'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Alertas recientes
        $alertasRecientes = Alerta::with(['modulo'])
            ->where('user_id', $user->id)
            ->where('estado', 'Pendiente')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Monitoreo - Obtener últimas lecturas de sensores del usuario
        $modulos = Modulo::where('user_id', $user->id)->pluck('id');

        $ultimasLecturas = DB::table('lecturas_sensores as ls')
            ->join('sensores as s', 'ls.sensor_id', '=', 's.id')
            ->whereIn('s.modulo_id', $modulos)
            ->orderBy('ls.created_at', 'desc')
            ->limit(10)
            ->get();

        $monitoreo = [
            'temperatura' => '23.5',
            'luz' => '4200',
            'humedad_charola1' => '68',
            'humedad_charola2' => '32',
            'humedad_charola3' => '75',
            'humedad_charola4' => '70',
        ];

        // Si hay lecturas reales, usarlas
        if ($ultimasLecturas->isNotEmpty()) {
            // Aquí procesarías las lecturas reales
        }

        // Evaluaciones recientes
        $evaluacionesRecientes = DB::table('evaluaciones as e')
            ->join('siembras as s', 'e.siembra_id', '=', 's.id')
            ->join('cultivos as c', 's.cultivo_id', '=', 'c.id')
            ->where('s.user_id', $user->id)
            ->orderBy('e.fecha_evaluacion', 'desc')
            ->limit(5)
            ->select('e.*', 'c.nombre as cultivo_nombre')
            ->get();

        return view('Dashboard.dashboard', compact(
            'stats',
            'siembrasRecientes',
            'alertasRecientes',
            'monitoreo',
            'evaluacionesRecientes'
        ));
    }
}
