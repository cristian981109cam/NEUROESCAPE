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
        Schema::create('exercise_routines', function (Blueprint $table) {
            $table->id()->comment('Llave primaria');

            $table->unsignedBigInteger('fk_id_parameter_muscle')->comment('relacion de la tabla de muscle de parametros');
            $table->string('nombre', 255)->comment('Nombre de la rutina');
            $table->text('descripcion')->comment('Descripción de la rutina');
            $table->string('img')->nullable()->comment('Nombre de la imagen en el storage');
            $table->text('video_url')->nullable()->comment('Url del video explicativo');
            
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

            // Relacion de la tabla muscle en parametros
            $db = DB::connection('parametros')->getDatabaseName();
            $table->foreign('fk_id_parameter_muscle')->references('id')->on($db . '.muscles')
            ->onDelete('cascade')
            ->onUpdate('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('exercise_routines');
        Schema::enableForeignKeyConstraints();
    }
};
