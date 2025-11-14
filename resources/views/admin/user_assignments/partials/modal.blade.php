<div class="modal fade" id="ModalUsuarioAsignado" tabindex="-1" aria-labelledby="modalUsuarioAsignadoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalUsuarioAsignadoLabel">Agregar Sesion</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id" value="">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario:</label>
                    <select class="form-control" id="usuario" name="fk_id_assignament_user"></select>
                </div>
                <div class="mb-3">
                    <label for="objetivos" class="form-label">Objetivos:</label>
                    <input type="text" class="form-control" id="objetivos" placeholder="Ingrese el objetivo" required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="materiales" class="form-label">Materiales:</label>
                    <input type="text" class="form-control" id="materiales" placeholder="Ingrese el material" required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="tiempo_total" class="form-label">Tiempo Total Del Ejercicio:</label>
                    <input type="time" class="form-control" id="tiempo_total" step="1" value="00:00:00" placeholder="Ingrese el tiempo total del ejercicio HH:MM:SS" required autocomplete="off">
                    <small class="form-text text-muted">Ingrese el tiempo total del ejercicio en formato HH:MM:SS.</small>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripcion:</label>
                    <input type="text" class="form-control" id="descripcion" placeholder="Ingrese la descripcion" required autocomplete="off">
                </div>
                {{-- <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Ejercicio:</label>
                    <select class="form-control" id="nombre" name="fk_id_exercise_routine"></select>
                </div>
                <div class="mb-3">
                    <label for="repeticiones" class="form-label">Repeticiones:</label>
                    <input type="text" class="form-control" id="repeticiones" placeholder="Ingrese el número de repeticiones" required>
                </div>
                <div class="mb-3">
                    <label for="series" class="form-label">Series:</label>
                    <input type="text" class="form-control" id="series" placeholder="Ingrese el número de series" required>
                </div>
                <div class="mb-3">
                    <label for="intervalos" class="form-label">Intervalos:</label>
                    <input type="text" class="form-control" id="intervalos" placeholder="Ingrese el intervalo" required autocomplete="off">
                </div> --}}
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha:</label>
                    <input type="date" class="form-control" id="fecha" required autocomplete="off">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>