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
        Schema::connection('parametros')->create('muscles', function (Blueprint $table) {
            // Clave primaria
            $table->id()->comment('Llave primaria de musculos en parametros');

            // Campos principales
            $table->string('nombre', 255)->nullable()->comment('Nombre de la categoría');
            $table->text('descripcion')->nullable()->comment('Descripción de la categoria');
            $table->boolean('estado')->default(1)->comment('Estado activo/inactivo, 1 = activo, 0 = inactivo');
            
            // Auditoría
            $table->unsignedBigInteger('created_by')->nullable()->comment('Usuario que creó el registro');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('Usuario que actualizó el registro');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('Usuario que eliminó el registro');
            
            // Timestamps y borrado lógico
            $table->timestamps(); // created_at y updated_at
            $table->softDeletes(); // deleted_at para borrado lógico, Marca como eliminada, pero permanece en la base de datos
            
            // Relaciones con la tabla `users`
            $db = DB::getDatabaseName();
        
            $table->foreign('created_by')->references('id')->on($db.'.users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on($db.'.users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on($db.'.users')->onDelete('set null');
            
            // Índices adicionales
            $table->index('estado', 'idEstado'); // Índice para consultas rápidas por estado

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::connection('parametros')->dropIfExists('muscles');
        Schema::enableForeignKeyConstraints();
    }
};
