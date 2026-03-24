<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $reportes = Reporte::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => Reporte::where('user_id', $user->id)->count(),
            'pendientes' => 0,
            'descargados' => Reporte::where('user_id', $user->id)->where('descargado', true)->count(),
            'formato_preferido' => $this->obtenerFormatoPreferido($user->id),
        ];

        return view('Reportes.reportes', compact('reportes', 'stats'));
    }

    public function generar(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string',
            'periodo' => 'required|string',
            'formato' => 'required|in:PDF,Excel,CSV',
        ]);

        // Calcular fechas según el período
        $fechas = $this->calcularFechasPeriodo($request->periodo);

        // Generar nombre del reporte
        $nombre = 'Reporte de ' . ucfirst($request->tipo) . ' - ' . now()->format('d/m/Y H:i');

        // Crear el reporte en la base de datos
        $reporte = Reporte::create([
            'user_id' => auth()->id(),
            'nombre' => $nombre,
            'tipo' => $request->tipo,
            'periodo_inicio' => $fechas['inicio'],
            'periodo_fin' => $fechas['fin'],
            'formato' => $request->formato,
            'archivo_url' => '#',
            'tamaño_kb' => rand(100, 5000),
            'parametros' => json_encode($request->all()),
            'descargado' => false,
        ]);

        return redirect()->route('reportes.index')
            ->with('success', 'Reporte generado correctamente: ' . $nombre);
    }

    public function descargar(string $id)
    {
        $reporte = Reporte::where('user_id', auth()->id())->findOrFail($id);
        $reporte->marcarComoDescargado();

        return redirect()->back()
            ->with('success', 'Descarga iniciada: ' . $reporte->nombre);
    }

    public function verPdf(string $id)
    {
        $reporte = Reporte::where('user_id', auth()->id())->findOrFail($id);

        return redirect()->back()
            ->with('info', 'Funcionalidad de visualización PDF en desarrollo. Pronto podrás ver "' . $reporte->nombre . '" aquí.');
    }

    public function destroy(string $id)
    {
        $reporte = Reporte::where('user_id', auth()->id())->findOrFail($id);
        $reporte->delete();

        return redirect()->route('reportes.index')
            ->with('success', 'Reporte eliminado correctamente');
    }

    /**
     * Calcular fechas de inicio y fin según el período seleccionado
     */
    private function calcularFechasPeriodo($periodo)
    {
        $fin = now();
        $inicio = now();

        switch ($periodo) {
            case 'semana':
                $inicio = now()->subDays(7);
                break;
            case 'mes':
                $inicio = now()->subMonth();
                break;
            case 'trimestre':
                $inicio = now()->subMonths(3);
                break;
            case 'año':
                $inicio = now()->subYear();
                break;
            default:
                $inicio = now()->subMonth();
                break;
        }

        return [
            'inicio' => $inicio,
            'fin' => $fin,
        ];
    }

    /**
     * Obtener el formato de reporte más utilizado por el usuario
     */
    private function obtenerFormatoPreferido($userId)
    {
        $formato = Reporte::where('user_id', $userId)
            ->select('formato', DB::raw('count(*) as total'))
            ->groupBy('formato')
            ->orderBy('total', 'desc')
            ->first();

        return $formato ? $formato->formato : 'PDF';
    }
}
