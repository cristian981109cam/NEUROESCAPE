<?php

namespace App\Models\Training;

use App\Models\User;
use App\Models\Parameters\muscles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class exercise_routines extends Model
{
    use HasFactory, SoftDeletes;

    // Especifica el nombre de la tabla asociada (opcional si sigue la convención de nombres)
    protected $table = 'exercise_routines';

    // Habilita o deshabilita las marcas de tiempo automáticas
    public $timestamps = true;

    // Define los campos que pueden ser asignados masivamente
    protected $fillable = [
        'fk_id_parameter_muscle',
        'nombre',
        'descripcion',
        'img',
        'video_url',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Get the categorias that owns the Vehiculo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function muscles()
    {
        return $this->belongsTo(muscles::class, 'fk_id_parameter_muscle');
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
