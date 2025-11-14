<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use App\Models\Training\exercise_routines;
use Illuminate\Http\Request;

class exercise_routinesController extends Controller
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
                $exercise_routine = new exercise_routines();
                $title = 'Creado!';
                $msg = 'Se ha creado exitosamente.';
            } else {
                $exercise_routine = exercise_routines::findOrFail($request->id);
                $title = 'Actualizado!';
                $msg = 'Se ha actualizado exitosamente.';
            }

            // Asignar datos
            $exercise_routine->nombre = $request->nombre;
            $exercise_routine->descripcion = $request->descripcion;
            // $exercise_routine->img = $request->img;
            // Subir imagen si existe
            if ($request->hasFile('img')) {
                // Validar y guardar la imagen
                $image = $request->file('img');
                $path = $image->store('img', 'public'); // Guarda la imagen en el disco 'public' en la carpeta 'exercise_images'
                $exercise_routine->img = $path; // Guarda la ruta en la base de datos
            } else {
                // Si no se subió una imagen, puedes dejar el valor actual o asignar un valor por defecto
                $exercise_routine->img = $exercise_routine->img ?? 'Neuroescape.jpg';
            }
            $exercise_routine->video_url = $request->video_url;
            $exercise_routine->fk_id_parameter_muscle = $request->muscles;
            $exercise_routine->updated_by = auth()->id(); // Registrar el usuario que realiza la acción

            // Guardar o actualizar
            if ($request->id === null) {
                $exercise_routine->created_by = auth()->id(); // Registrar creador
                if (!$exercise_routine->save()) {
                    throw new \Exception("No se pudo guardar.");
                }
            } else {
                if (!$exercise_routine->update()) {
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
     * Eliminar (borrado lógico).
     */
    public function delete($id)
    {
        try {
            // Buscar
            $exercise_routine = exercise_routines::findOrFail($id);

            // Actualizar el estado y registrar el usuario que elimina
            // $exercise_routine->estado = 0; // Cambiar el estado a inactivo
            $exercise_routine->deleted_by = auth()->id(); // Registrar quién eliminó

            // Guardar los cambios antes de ejecutar soft delete
            $exercise_routine->save();

            // Marcar como eliminado lógicamente (soft delete)
            $exercise_routine->delete();

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
