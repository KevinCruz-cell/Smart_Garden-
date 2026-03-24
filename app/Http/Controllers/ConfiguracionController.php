<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $configuraciones = Configuracion::where('user_id', $user->id)->get();

        // Organizar configuraciones por tipo
        $config = [
            'general' => [],
            'monitoreo' => [],
            'alertas' => [],
            'riego' => [],
        ];

        foreach ($configuraciones as $c) {
            $config[$c->tipo][$c->clave] = json_decode($c->valor, true);
        }

        return view('Configuracion.configuracion', compact('config'));
    }

    public function updateGeneral(Request $request)
    {
        $request->validate([
            'nombre_huerto' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'zona_horaria' => 'required|string',
        ]);

        $user = auth()->user();

        Configuracion::setConfig($user->id, 'general', 'nombre_huerto', $request->nombre_huerto);
        Configuracion::setConfig($user->id, 'general', 'ubicacion', $request->ubicacion);
        Configuracion::setConfig($user->id, 'general', 'zona_horaria', $request->zona_horaria);

        return redirect()->back()->with('success', 'Configuración general actualizada');
    }

    public function updateMonitoreo(Request $request)
    {
        $request->validate([
            'intervalo_medicion' => 'required|integer|min:5|max:60',
        ]);

        $user = auth()->user();

        Configuracion::setConfig($user->id, 'monitoreo', 'intervalo_medicion', $request->intervalo_medicion);
        Configuracion::setConfig($user->id, 'monitoreo', 'temperatura', $request->has('temperatura'));
        Configuracion::setConfig($user->id, 'monitoreo', 'humedad', $request->has('humedad'));
        Configuracion::setConfig($user->id, 'monitoreo', 'luz', $request->has('luz'));

        return redirect()->back()->with('success', 'Configuración de monitoreo actualizada');
    }

    public function updateAlertas(Request $request)
    {
        $request->validate([
            'umbral_humedad_baja' => 'required|integer|min:0|max:100',
            'umbral_temperatura_alta' => 'required|integer|min:0|max:50',
        ]);

        $user = auth()->user();

        Configuracion::setConfig($user->id, 'alertas', 'umbral_humedad_baja', $request->umbral_humedad_baja);
        Configuracion::setConfig($user->id, 'alertas', 'umbral_temperatura_alta', $request->umbral_temperatura_alta);
        Configuracion::setConfig($user->id, 'alertas', 'email_notificaciones', $request->has('email_notificaciones'));
        Configuracion::setConfig($user->id, 'alertas', 'push_notificaciones', $request->has('push_notificaciones'));

        return redirect()->back()->with('success', 'Configuración de alertas actualizada');
    }

    public function updateRiego(Request $request)
    {
        $request->validate([
            'hora_inicio' => 'required|date_format:H:i',
            'duracion' => 'required|integer|min:1|max:60',
            'frecuencia' => 'required|string|in:diario,cada2,personalizado',
        ]);

        $user = auth()->user();

        Configuracion::setConfig($user->id, 'riego', 'automatico', $request->has('automatico'));
        Configuracion::setConfig($user->id, 'riego', 'hora_inicio', $request->hora_inicio);
        Configuracion::setConfig($user->id, 'riego', 'duracion', $request->duracion);
        Configuracion::setConfig($user->id, 'riego', 'frecuencia', $request->frecuencia);

        return redirect()->back()->with('success', 'Configuración de riego actualizada');
    }

    public function updatePerfil(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'telefono' => 'nullable|string|max:20',
        ]);

        $user = auth()->user();
        $user->update($request->only(['nombre', 'apellido', 'email', 'telefono']));

        // Actualizar avatar si cambió el nombre
        if ($user->wasChanged('nombre') || $user->wasChanged('apellido')) {
            $user->avatar = 'https://ui-avatars.com/api/?name=' . urlencode($user->nombre . '+' . $user->apellido) . '&background=2E7D32&color=fff&size=40';
            $user->save();
        }

        return redirect()->back()->with('success', 'Perfil actualizado correctamente');
    }

    public function updateSeguridad(Request $request)
    {
        $request->validate([
            'password_actual' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->back()->with('success', 'Contraseña actualizada correctamente');
    }

    /**
     * Método adicional para eliminar cuenta (opcional)
     */
    public function destroyAccount(Request $request)
    {
        $user = auth()->user();

        // Eliminar configuraciones relacionadas
        Configuracion::where('user_id', $user->id)->delete();

        // Eliminar usuario
        $user->delete();

        // Cerrar sesión
        auth()->logout();

        return redirect()->route('home')->with('success', 'Cuenta eliminada correctamente');
    }
}
