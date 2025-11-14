<?php

namespace App\Http\Controllers\Parameters;

use App\Http\Controllers\Controller;
use App\Models\Parameters\muscles;
use Illuminate\Http\Request;

class MuscleController extends Controller
{
    /**
     * Guardar o actualizar.
     */
    public function save(Request $request)
    {
        // dd($request->all()); // Esto imprimirá todos los datos enviados en el request
        // dd($request->header('X-CSRF-TOKEN')); // Esto imprimirá el token CSRF enviado en los encabezados
        // die(); // Detener la ejecución

        try {
            $response = [];

            // Determinar si es creación o actualización
            if ($request->id === null) {
                $muscle = new muscles();
                $title = 'Creado!';
                $msg = 'Se ha creado exitosamente.';
            } else {
                $muscle = muscles::findOrFail($request->id);
                $title = 'Actualizado!';
                $msg = 'Se ha actualizado exitosamente.';
            }

            // Asignar datos
            $muscle->nombre = $request->nombre;
            $muscle->descripcion = $request->descripcion;
            $muscle->estado = $request->estado ?? 1; // Valor por defecto: Activo
            $muscle->updated_by = auth()->id(); // Registrar el usuario que realiza la acción

            // Guardar o actualizar
            if ($request->id === null) {
                $muscle->created_by = auth()->id(); // Registrar creador
                if (!$muscle->save()) {
                    throw new \Exception("No se pudo guardar.");
                }
            } else {
                if (!$muscle->update()) {
                    throw new \Exception("No se pudo actualizar.");
                }
            }

            // Respuesta exitosa
            $response['status'] = 'success';
            $response['title'] = $title;
            $response['msg'] = $msg;
        } catch (\Exception $e) {
            // Manejo de errores
            $response['status'] = 'error';
            $response['title'] = 'Ups...!';
            $response['msg'] = $e->getMessage();
            $response['line'] = $e->getLine();
            $response['file'] = $e->getFile();
        }

        return response()->json($response);
    }

    /**
     * Cambiar el estado
     */
    public function updateEstado(Request $request, $id)
    {
        try {
            // Validar que la categoría existe
            $muscle = muscles::findOrFail($id);

            // Actualizar el estado
            $muscle->estado = $request->estado;
            $muscle->updated_by = auth()->id(); // Registrar el usuario que actualiza
            $muscle->save();

            // Respuesta exitosa
            return response()->json([
                'status' => 'success',
                'title' => 'Estado actualizado',
                'msg' => 'El estado se actualizó correctamente.',
            ]);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'status' => 'error',
                'title' => 'Ups...!',
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'code' => $e->getCode(),
            ], 400);
        }
    }

    /**
     * Eliminar (borrado lógico).
     */
    public function delete($id)
    {
        try {
            // Buscar
            $muscle = muscles::findOrFail($id);

            // Actualizar el estado y registrar el usuario que elimina
            $muscle->estado = 0; // Cambiar el estado a inactivo
            $muscle->deleted_by = auth()->id(); // Registrar quién eliminó

            // Guardar los cambios antes de ejecutar soft delete
            $muscle->save();

            // Marcar como eliminado lógicamente (soft delete)
            $muscle->delete();

            // Respuesta exitosa
            return response()->json([
                'status' => 'success',
                'title' => 'Eliminar',
                'msg' => 'Se ha eliminado exitosamente.',
            ]);
        } catch (\Exception $e) {
            // Manejo de errores
            $response = [
                'status' => 'error',
                'title' => 'Ups...!',
                'msg' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'code' => $e->getCode(),
            ];

            // Manejar errores de clave foránea
            if ($e->getCode() == 23000) {
                $response['msg'] = 'No se puede eliminar porque está en uso en algún lugar de la plataforma.';
            }

            return response()->json($response, 400); // Código de error 400 para solicitudes erróneas
        }
    }
}
