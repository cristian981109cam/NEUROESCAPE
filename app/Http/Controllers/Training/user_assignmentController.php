<?php

namespace app\Http\Controllers\Training;

use app\Http\Controllers\Controller;
use app\Models\Training\user_assignment;
use Illuminate\Http\Request;

class user_assignmentController extends Controller
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
                $user_assignment = new user_assignment();
                $title = 'Creado!';
                $msg = 'Se ha creado exitosamente.';
            } else {
                $user_assignment = user_assignment::findOrFail($request->id);
                $title = 'Actualizado!';
                $msg = 'Se ha actualizado exitosamente.';
            }

            // Asignar datos
            $user_assignment->objetivos = $request->objetivos;
            $user_assignment->materiales = $request->materiales;
            $user_assignment->tiempo_total = $request->tiempo_total;
            $user_assignment->descripcion = $request->descripcion;
            $user_assignment->repeticiones = $request->repeticiones;
            $user_assignment->series = $request->series;
            $user_assignment->intervalos = $request->intervalos;
            $user_assignment->observaciones = $request->observaciones;
            $user_assignment->start = $request->fecha;
            $user_assignment->fk_id_assignament_user = $request->usuario;
            $user_assignment->fk_id_exercise_routine = $request->nombre;
            // $user_assignment->fk_id_exercise_routine = $request->img;
            $user_assignment->fk_id_microciclo_principal = $request->fk_id_microciclo_principal;
            $user_assignment->updated_by = auth()->id(); // Registrar el usuario que realiza la acción

            // Asignar el tipo (principal o extra)
            $user_assignment->tipo = $request->has('es_extra') ? 'extra' : 'principal';

            // Si es un ejercicio extra, asignar el microciclo principal
            if ($request->has('es_extra')) {
                $user_assignment->fk_id_microciclo_principal = $request->fk_id_microciclo_principal;
            }

            // Guardar o actualizar
            if ($request->id === null) {
                $user_assignment->created_by = auth()->id(); // Registrar creador
                if (!$user_assignment->save()) {
                    throw new \Exception("No se pudo guardar.");
                }
            } else {
                if (!$user_assignment->update()) {
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
            $user_assignment = user_assignment::findOrFail($id);

            // Actualizar el estado y registrar el usuario que elimina
            // $user_assignment->estado = 0; // Cambiar el estado a inactivo
            //$user_assignment->deleted_by = auth()->id(); // Registrar quién eliminó

            // Si el registro es un principal, eliminar sus extras primero
            // if ($user_assignment->tipo === 'principal') {
            //     user_assignment::where('fk_id_microciclo_principal', $id)
            //         ->update(['deleted_by' => auth()->id()]); // Registrar quién eliminó los extras

            //     user_assignment::where('fk_id_microciclo_principal', $id)->delete();
            // }

            // Si el registro es un principal, eliminar sus extras primero
            if ($user_assignment->tipo === 'principal') {
                user_assignment::where('fk_id_microciclo_principal', $id)
                    ->update([
                        'deleted_by' => auth()->id(),
                        'deleted_at' => now(),
                    ]);

                user_assignment::where('fk_id_microciclo_principal', $id)->delete();
            }

            // Registrar la eliminación en el registro principal
            $user_assignment->deleted_by = auth()->id();
            $user_assignment->deleted_at = now();

            // Guardar los cambios antes de ejecutar soft delete
            $user_assignment->save();

            // Marcar como eliminado lógicamente (soft delete)
            $user_assignment->delete();

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

    // public function delete($id)
    // {
    //     try {
    //         // Buscar el microciclo principal
    //         $microcicloPrincipal = user_assignment::findOrFail($id);

    //         // Eliminar todos los ejercicios extras asociados
    //         user_assignment::where('fk_id_microciclo_principal', $id)->delete();

    //         // Eliminar el microciclo principal
    //         $microcicloPrincipal->delete();

    //         // Respuesta exitosa
    //         return response()->json([
    //             'status' => 'success',
    //             'title' => 'Eliminado!',
    //             'msg' => 'El microciclo principal y sus ejercicios extras han sido eliminados exitosamente.',
    //         ]);
    //     } catch (\Exception $e) {
    //         // Manejo de errores
    //         $response = [
    //             'status' => 'error',
    //             'title' => 'Ups...!',
    //             'msg' => $e->getMessage(),
    //             'line' => $e->getLine(),
    //             'file' => $e->getFile(),
    //             'code' => $e->getCode(),
    //         ];

    //         // Manejar errores de clave foránea
    //         if ($e->getCode() == 23000) {
    //             $response['msg'] = 'No se puede eliminar porque está en uso en algún lugar de la plataforma.';
    //         }

    //         return response()->json($response, 400); // Código de error 400 para solicitudes erróneas
    //     }
    // }
}
