<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_assignments', function (Blueprint $table) {
            $table->id();

            $table->enum('tipo', ['principal', 'extra'])->default('principal');
            $table->unsignedBigInteger('fk_id_exercise_routine')->nullable()->comment('relacion de la tabla de rutinas de ejercicios');
            $table->unsignedBigInteger('fk_id_assignament_user')->comment('relacion de la tabla usuarios asignados');

            // Nuevo campo para relacionar ejercicios extras con el microciclo principal
            $table->unsignedBigInteger('fk_id_microciclo_principal')->nullable()->comment('relacion con el microciclo principal');
            
            $table->string('objetivos', 255)->nullable()->comment('Objetivos del ejercicio');
            $table->text('materiales')->nullable()->comment('Materiales necesarios para la rutina');
            $table->time('tiempo_total')->nullable()->comment('Tiempo total estimado para la rutina');
            $table->text('descripcion')->nullable()->comment('Descripción del ejercicio');

            $table->string('repeticiones', 20)->nullable()->comment('# de repeticiones');
            $table->string('series', 20)->nullable()->comment('# de series ');
            $table->string('intervalos', 30)->nullable()->comment('Intervalos del ejercicio');
            $table->text('observaciones')->nullable()->comment('Observaciones sobre el ejercicio');

            $table->date('start')->comment('Fecha de inicio de la asignación');
            // $table->date('end')->nullable()->comment('Fecha de finalización de la asignación (puede ser nula)');
            $table->string('color', 10)->default('#ffffff')->comment('Código de color en formato hexadecimal o CSS');
            
            // Auditoría
            $table->unsignedBigInteger('created_by')->nullable()->comment('Usuario que creó el registro');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('Usuario que actualizó el registro');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('Usuario que eliminó el registro');
            $table->softDeletes(); // deleted_at para borrado lógico, Marca como eliminada, pero permanece en la base de datos
            $table->timestamps();

            // Relaciones con la tabla `users`
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
            
            $table->foreign('fk_id_assignament_user')->references('id')->on('users');
            $table->foreign('fk_id_exercise_routine')->references('id')->on('exercise_routines');

            // Relación con el microciclo principal
            $table->foreign('fk_id_microciclo_principal')->references('id')->on('user_assignments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('user_assignments');
        Schema::enableForeignKeyConstraints();
    }
};
