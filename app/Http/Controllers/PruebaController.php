<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class PruebaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las categorías
        $categorias = Categoria::all();

        return response()->json([
            'status' => 'success',
            'data' => $categorias,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validar datos de entrada
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'estado' => 'nullable|boolean',
            ]);

            // Crear una nueva categoría
            $categoria = new Categoria();
            $categoria->nombre = $request->nombre;
            $categoria->descripcion = $request->descripcion;
            $categoria->estado = $request->estado ?? 1;
            $categoria->created_by = auth()->id();

            if (!$categoria->save()) {
                throw new \Exception("No se pudo guardar la categoría.");
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Categoría creada exitosamente.',
                'data' => $categoria,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Buscar la categoría por ID
            $categoria = Categoria::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $categoria,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Categoría no encontrada.',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Validar datos de entrada
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'estado' => 'nullable|boolean',
            ]);

            // Buscar la categoría
            $categoria = Categoria::findOrFail($id);
            $categoria->nombre = $request->nombre;
            $categoria->descripcion = $request->descripcion;
            $categoria->estado = $request->estado ?? $categoria->estado;
            $categoria->updated_by = auth()->id();

            if (!$categoria->save()) {
                throw new \Exception("No se pudo actualizar la categoría.");
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Categoría actualizada exitosamente.',
                'data' => $categoria,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Buscar la categoría
            $categoria = Categoria::findOrFail($id);
            $categoria->deleted_by = auth()->id();

            if (!$categoria->delete()) {
                throw new \Exception("No se pudo eliminar la categoría.");
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Categoría eliminada exitosamente.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
