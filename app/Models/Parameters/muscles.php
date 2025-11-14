<?php

namespace App\Models\Parameters;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class muscles extends Model
{
    use HasFactory, SoftDeletes;

	protected $connection = 'parametros';

    // Especifica el nombre de la tabla asociada (opcional si sigue la convención de nombres)
    protected $table = 'muscles';

    // Habilita o deshabilita las marcas de tiempo automáticas
    public $timestamps = true;

    // Define los campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

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

    // Métodos adicionales para manejar el estado

    /**
     * Verifica si está activa.
     */
    public function isActive()
    {
        return $this->estado === 1;
    }

    /**
     * Activa muscles.
     */
    public function activate()
    {
        $this->estado = 1;
        $this->save();
    }

    /**
     * Desactiva muscles.
     */
    public function deactivate()
    {
        $this->estado = 0;
        $this->save();
    }
}
