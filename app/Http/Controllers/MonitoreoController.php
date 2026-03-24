<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Sensor;
use App\Models\LecturaSensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoreoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Obtener todos los módulos del usuario con sus sensores
        $modulos = Modulo::with(['sensores' => function($query) {
            $query->where('activo', true);
        }])
            ->where('user_id', $user->id)
            ->where('activo', true)
            ->get();

        // Estadísticas generales de monitoreo
        $stats = [
            'temperatura' => $this->obtenerUltimaLecturaPorTipo($user->id, 'Temperatura'),
            'humedad_ambiente' => $this->obtenerUltimaLecturaPorTipo($user->id, 'Humedad'),
            'luz' => $this->obtenerUltimaLecturaPorTipo($user->id, 'Luz'),
            'ph' => $this->obtenerUltimaLecturaPorTipo($user->id, 'pH'),
            'nutrientes' => $this->obtenerUltimaLecturaPorTipo($user->id, 'Nutrientes'),
        ];

        // Obtener lecturas recientes (últimas 24 horas)
        $lecturasRecientes = DB::table('lecturas_sensores as ls')
            ->join('sensores as s', 'ls.sensor_id', '=', 's.id')
            ->join('modulos as m', 's.modulo_id', '=', 'm.id')
            ->where('m.user_id', $user->id)
            ->where('ls.created_at', '>=', now()->subHours(24))
            ->orderBy('ls.created_at', 'desc')
            ->limit(50)
            ->select(
                'ls.*',
                's.nombre as sensor_nombre',
                's.tipo',
                's.unidad',
                'm.nombre as modulo_nombre'
            )
            ->get();

        return view('Monitoreo.monitoreo', compact('modulos', 'stats', 'lecturasRecientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Método para recibir lecturas de sensores (API)
        $request->validate([
            'sensor_id' => 'required|exists:sensores,id',
            'valor' => 'required|numeric',
        ]);

        $lectura = LecturaSensor::create([
            'sensor_id' => $request->sensor_id,
            'valor' => $request->valor,
        ]);

        // Actualizar última lectura del sensor
        $sensor = Sensor::find($request->sensor_id);
        $sensor->ultima_lectura = $request->valor;
        $sensor->ultima_lectura_at = now();
        $sensor->save();

        return response()->json([
            'success' => true,
            'message' => 'Lectura registrada correctamente',
            'data' => $lectura
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $modulo = Modulo::with(['sensores' => function($query) {
            $query->with(['lecturas' => function($q) {
                $q->orderBy('created_at', 'desc')->limit(24);
            }]);
        }])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('Monitoreo.show', compact('modulo'));
    }

    /**
     * Actualizar lecturas manualmente (para pruebas)
     */
    public function actualizar(Request $request)
    {
        $request->validate([
            'sensor_id' => 'required|exists:sensores,id',
            'valor' => 'required|numeric',
        ]);

        // Verificar que el sensor pertenezca al usuario
        $sensor = Sensor::with('modulo')
            ->whereHas('modulo', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->findOrFail($request->sensor_id);

        $lectura = LecturaSensor::create([
            'sensor_id' => $request->sensor_id,
            'valor' => $request->valor,
        ]);

        // Actualizar última lectura del sensor
        $sensor->ultima_lectura = $request->valor;
        $sensor->ultima_lectura_at = now();
        $sensor->save();

        return redirect()->back()->with('success', 'Lectura actualizada correctamente');
    }

    /**
     * Obtener datos para gráficos
     */
    public function datosGrafico(Request $request)
    {
        $request->validate([
            'sensor_id' => 'required|exists:sensores,id',
            'periodo' => 'required|in:24h,7d,30d',
        ]);

        $horas = match($request->periodo) {
            '24h' => 24,
            '7d' => 168,
            '30d' => 720,
        };

        $lecturas = LecturaSensor::where('sensor_id', $request->sensor_id)
            ->where('created_at', '>=', now()->subHours($horas))
            ->orderBy('created_at', 'asc')
            ->get(['valor', 'created_at']);

        return response()->json($lecturas);
    }

    /**
     * Obtener última lectura por tipo de sensor
     */
    private function obtenerUltimaLecturaPorTipo($userId, $tipo)
    {
        $lectura = DB::table('lecturas_sensores as ls')
            ->join('sensores as s', 'ls.sensor_id', '=', 's.id')
            ->join('modulos as m', 's.modulo_id', '=', 'm.id')
            ->where('m.user_id', $userId)
            ->where('s.tipo', $tipo)
            ->orderBy('ls.created_at', 'desc')
            ->first();

        if (!$lectura) {
            return match($tipo) {
                'Temperatura' => ['valor' => '0.0', 'unidad' => '°C'],
                'Humedad' => ['valor' => '0', 'unidad' => '%'],
                'Luz' => ['valor' => '0', 'unidad' => 'lux'],
                'pH' => ['valor' => '7.0', 'unidad' => 'pH'],
                'Nutrientes' => ['valor' => '0', 'unidad' => 'ppm'],
                default => ['valor' => '0', 'unidad' => ''],
            };
        }

        return [
            'valor' => number_format($lectura->valor, 1),
            'unidad' => $lectura->unidad ?? '',
        ];
    }

    /**
     * Obtener estado de salud del módulo
     */
    private function obtenerEstadoModulo($moduloId)
    {
        $ultimaLectura = LecturaSensor::whereHas('sensor', function($query) use ($moduloId) {
            $query->where('modulo_id', $moduloId);
        })
            ->latest()
            ->first();

        if (!$ultimaLectura) {
            return 'warning';
        }

        return 'success';
    }

    /**
     * Exportar datos de monitoreo a CSV
     */
    public function exportarCSV(Request $request)
    {
        $request->validate([
            'modulo_id' => 'nullable|exists:modulos,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $user = auth()->user();

        $query = DB::table('lecturas_sensores as ls')
            ->join('sensores as s', 'ls.sensor_id', '=', 's.id')
            ->join('modulos as m', 's.modulo_id', '=', 'm.id')
            ->where('m.user_id', $user->id)
            ->whereBetween('ls.created_at', [$request->fecha_inicio, $request->fecha_fin])
            ->orderBy('ls.created_at', 'asc');

        if ($request->modulo_id) {
            $query->where('m.id', $request->modulo_id);
        }

        $lecturas = $query->get();

        $filename = "monitoreo_{$request->fecha_inicio}_{$request->fecha_fin}.csv";
        $handle = fopen('php://output', 'w');

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Cabeceras CSV
        fputcsv($handle, ['Fecha', 'Módulo', 'Sensor', 'Tipo', 'Valor', 'Unidad']);

        // Datos
        foreach ($lecturas as $lectura) {
            fputcsv($handle, [
                $lectura->created_at,
                $lectura->modulo_nombre,
                $lectura->sensor_nombre,
                $lectura->tipo,
                $lectura->valor,
                $lectura->unidad
            ]);
        }

        fclose($handle);
        exit;
    }
}
