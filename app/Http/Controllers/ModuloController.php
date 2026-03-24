<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModuloController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'ubicacion' => 'nullable|string|max:100',
            'num_charolas' => 'required|integer|min:1|max:10',
            'tipo_riego' => 'required|in:Manual,Automático,Mixto',
        ]);

        $modulo = Modulo::create([
            'user_id' => auth()->id(),
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'num_charolas' => $request->num_charolas,
            'tipo_riego' => $request->tipo_riego,
            'activo' => true,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'modulo' => $modulo]);
        }

        return redirect()->back()->with('success', 'Módulo creado correctamente');
    }
}
