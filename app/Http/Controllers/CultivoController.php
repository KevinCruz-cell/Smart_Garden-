<?php

namespace App\Http\Controllers;

use App\Models\Cultivo;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CultivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cultivos = Cultivo::all();
        return view('Cultivos.cultivos', compact('cultivos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        try {
            // Verificar si la vista existe
            $vista = 'Cultivos.create';
            if (!view()->exists($vista)) {
                die("La vista '$vista' no existe");
            }

            // Cargar la vista
            return view($vista);

        } catch (\Exception $e) {
            die("Error al cargar la vista: " . $e->getMessage());
        } catch (\Error $e) {
            die("Error fatal: " . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|in:Hoja,Fruto,Aromática,Raíz,Otro',
            'descripcion' => 'nullable|string',
            'temperatura_optima_min' => 'nullable|numeric',
            'temperatura_optima_max' => 'nullable|numeric',
            'humedad_optima_min' => 'nullable|integer|min:0|max:100',
            'humedad_optima_max' => 'nullable|integer|min:0|max:100',
            'luz_optima_min' => 'nullable|integer|min:0',
            'luz_optima_max' => 'nullable|integer|min:0',
            'ph_optimo_min' => 'nullable|numeric|min:0|max:14',
            'ph_optimo_max' => 'nullable|numeric|min:0|max:14',
            'dias_cosecha' => 'nullable|integer|min:1',
        ]);

        // Validaciones adicionales para rangos
        if ($request->filled('temperatura_optima_min') && $request->filled('temperatura_optima_max')) {
            if ($request->temperatura_optima_min > $request->temperatura_optima_max) {
                return back()->withErrors(['temperatura_optima_min' => 'La temperatura mínima no puede ser mayor que la máxima'])->withInput();
            }
        }

        if ($request->filled('humedad_optima_min') && $request->filled('humedad_optima_max')) {
            if ($request->humedad_optima_min > $request->humedad_optima_max) {
                return back()->withErrors(['humedad_optima_min' => 'La humedad mínima no puede ser mayor que la máxima'])->withInput();
            }
        }

        if ($request->filled('luz_optima_min') && $request->filled('luz_optima_max')) {
            if ($request->luz_optima_min > $request->luz_optima_max) {
                return back()->withErrors(['luz_optima_min' => 'La luz mínima no puede ser mayor que la máxima'])->withInput();
            }
        }

        if ($request->filled('ph_optimo_min') && $request->filled('ph_optimo_max')) {
            if ($request->ph_optimo_min > $request->ph_optimo_max) {
                return back()->withErrors(['ph_optimo_min' => 'El pH mínimo no puede ser mayor que el máximo'])->withInput();
            }
        }

        Cultivo::create($request->all());
        return redirect()->route('cultivos.index')->with('success', 'Cultivo creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cultivo = Cultivo::findOrFail($id);
        return view('Cultivos.show', compact('cultivo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cultivo = Cultivo::findOrFail($id);
        return view('Cultivos.edit', compact('cultivo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cultivo = Cultivo::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|in:Hoja,Fruto,Aromática,Raíz,Otro',
            'descripcion' => 'nullable|string',
            'temperatura_optima_min' => 'nullable|numeric',
            'temperatura_optima_max' => 'nullable|numeric',
            'humedad_optima_min' => 'nullable|integer|min:0|max:100',
            'humedad_optima_max' => 'nullable|integer|min:0|max:100',
            'luz_optima_min' => 'nullable|integer|min:0',
            'luz_optima_max' => 'nullable|integer|min:0',
            'ph_optimo_min' => 'nullable|numeric|min:0|max:14',
            'ph_optimo_max' => 'nullable|numeric|min:0|max:14',
            'dias_cosecha' => 'nullable|integer|min:1',
        ]);

        // Validaciones adicionales para rangos
        if ($request->filled('temperatura_optima_min') && $request->filled('temperatura_optima_max')) {
            if ($request->temperatura_optima_min > $request->temperatura_optima_max) {
                return back()->withErrors(['temperatura_optima_min' => 'La temperatura mínima no puede ser mayor que la máxima'])->withInput();
            }
        }

        if ($request->filled('humedad_optima_min') && $request->filled('humedad_optima_max')) {
            if ($request->humedad_optima_min > $request->humedad_optima_max) {
                return back()->withErrors(['humedad_optima_min' => 'La humedad mínima no puede ser mayor que la máxima'])->withInput();
            }
        }

        if ($request->filled('luz_optima_min') && $request->filled('luz_optima_max')) {
            if ($request->luz_optima_min > $request->luz_optima_max) {
                return back()->withErrors(['luz_optima_min' => 'La luz mínima no puede ser mayor que la máxima'])->withInput();
            }
        }

        if ($request->filled('ph_optimo_min') && $request->filled('ph_optimo_max')) {
            if ($request->ph_optimo_min > $request->ph_optimo_max) {
                return back()->withErrors(['ph_optimo_min' => 'El pH mínimo no puede ser mayor que el máximo'])->withInput();
            }
        }

        $cultivo->update($request->all());
        return redirect()->route('cultivos.index')->with('success', 'Cultivo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $cultivo = Cultivo::findOrFail($id);

            // Verificar si tiene siembras asociadas antes de intentar eliminar
            if ($cultivo->siembras()->count() > 0) {
                return redirect()->route('cultivos.index')
                    ->with('error', 'No se puede eliminar el cultivo porque tiene ' . $cultivo->siembras()->count() . ' siembras asociadas. Elimina primero las siembras que utilizan este cultivo.');
            }

            $cultivo->delete();

            return redirect()->route('cultivos.index')
                ->with('success', 'Cultivo eliminado correctamente');

        } catch (QueryException $e) {
            // Verificar si es error de restricción de clave foránea (1451)
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1451) {
                return redirect()->route('cultivos.index')
                    ->with('error', 'No se puede eliminar el cultivo porque tiene siembras asociadas. Elimina primero las siembras que utilizan este cultivo.');
            }

            // Si es otro tipo de error
            return redirect()->route('cultivos.index')
                ->with('error', 'Error al eliminar el cultivo. Por favor intenta de nuevo.');
        }
    }
}
