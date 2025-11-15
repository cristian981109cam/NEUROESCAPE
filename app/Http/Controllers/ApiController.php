<?php

namespace app\Http\Controllers;

use App\Models\Parameters\muscles;
use App\Models\Training\exercise_routines;
use App\Models\Training\user_assignment;
use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getuser($id)
    {
        try {
            // Consulta todos los users o una específica según el parámetro
            if ($id === '@') {
                $user = User::all();
            } else {
                $user = User::where('id', $id)->get();

                // Verifica si se encontró
                if ($user->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No encontrada.',
                    ], 404);
                }
            }

            // Respuesta exitosa
            return response()->json([
                'success' => true,
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al procesar la solicitud.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getmuscles($id)
    {
        try {
            // Consulta todos los muscles o una específica según el parámetro
            if ($id === '@') {
                $muscles = muscles::all();
            } else {
                $muscles = muscles::where('id', $id)->get();

                // Verifica si se encontró
                if ($muscles->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No encontrada.',
                    ], 404);
                }
            }

            // Respuesta exitosa
            return response()->json([
                'success' => true,
                'data' => $muscles,
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al procesar la solicitud.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getexercise_routines($id)
    {
        try {
            // Consulta todos los exercise_routines o uno específico según el parámetro
            if ($id === '@') {
                $exercise_routines = exercise_routines::with('muscles')->get();
            } else {
                $exercise_routines = exercise_routines::where('id', $id)->with('muscles')->get();

                // Verifica si se encontró
                if ($exercise_routines->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No encontrada.',
                    ], 404);
                }
            }

            // Respuesta exitosa
            return response()->json([
                'success' => true,
                'data' => $exercise_routines,
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al procesar la solicitud.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getuser_assignments($id)
    {
        try {
            // Consulta todos los user_assignment o uno específico según el parámetro
            if ($id === '@') {
                $user_assignment = user_assignment::with('exerciseRoutines','users')->get();
            } else {
                $user_assignment = user_assignment::where('id', $id)->with('exerciseRoutines','users')->get();

                // Verifica si se encontró
                if ($user_assignment->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No encontrada.',
                    ], 404);
                }
            }

            // Respuesta exitosa
            return response()->json([
                'success' => true,
                'data' => $user_assignment,
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al procesar la solicitud.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
