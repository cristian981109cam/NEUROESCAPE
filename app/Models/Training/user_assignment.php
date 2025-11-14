<?php

namespace App\Models\Training;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Training\exercise_routines;

class user_assignment extends Model
{
    use HasFactory, SoftDeletes;

    // Especifica el nombre de la tabla asociada (opcional si sigue la convención de nombres)
    protected $table = 'user_assignments';

    // Habilita o deshabilita las marcas de tiempo automáticas
    public $timestamps = true;

    // Define los campos que pueden ser asignados masivamente
    protected $fillable = [
        'tipo',
        'fk_id_exercise_routine',
        'fk_id_assignament_user',
        'fk_id_microciclo_principal',
        'objetivos',
        'materiales',
        'tiempo_total',
        'descripcion',
        'repeticiones',
        'series',
        'intervalos',
        'observaciones',
        'start',
        // 'end',
        'color',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // Relación: Un principal tiene muchos extras
    public function extras()
    {
        return $this->hasMany(user_assignment::class, 'fk_id_microciclo_principal');
    }

    // Relación: Un extra pertenece a un principal
    public function principal()
    {
        return $this->belongsTo(user_assignment::class, 'fk_id_microciclo_principal');
    }

    /**
     * Get the exercise routine that owns the assignment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exerciseRoutines()
    {
        return $this->belongsTo(exercise_routines::class, 'fk_id_exercise_routine');
    }

    /**
     * Get the user that owns the assignment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'fk_id_assignament_user');
    }

    // Define los campos que deben ser tratados como fechas
    protected $dates = ['deleted_at'];

    // Relaciones con el modelo `User`

    /**
     * Usuario que creó.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Usuario que actualizó.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Usuario que eliminó.
     */
    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Accesor para manejar imágenes predeterminadas
    public function getImgAttribute($value)
    {
        return $value ?: 'Neuroescape.jpg'; // Imagen predeterminada si no hay valor
    }
}
