<!-- Modal para agregar ejercicio extra -->
<div class="modal fade" id="ModalEjercicioExtra" tabindex="-1" aria-labelledby="modalEjercicioExtraLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEjercicioExtraLabel">Agregar Ejercicio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Campos ocultos para el usuario y fecha -->
                <input type="hidden" id="ejercicio_extra_user_id">
                <input type="hidden" id="ejercicio_extra_fecha">
                <input type="hidden" id="fk_id_microciclo_principal">
                
                <div class="mb-3">
                    <label for="nombre_extra" class="form-label">Ejercicio:</label>
                    <select class="form-control" id="nombre_extra" style="width: 100%;"></select>
                </div>
                <div class="mb-3">
                    <label for="repeticiones_extra" class="form-label">Repeticiones:</label>
                    <input type="text" class="form-control" id="repeticiones_extra" placeholder="Ingrese el número de repeticiones" required>
                </div>
                <div class="mb-3">
                    <label for="series_extra" class="form-label">Series:</label>
                    <input type="text" class="form-control" id="series_extra" placeholder="Ingrese el número de series" required>
                </div>
                <div class="mb-3">
                    <label for="intervalos_extra" class="form-label">Intervalos:</label>
                    <input type="text" class="form-control" id="intervalos_extra" placeholder="Ingrese el número de intervalos" required>
                </div>
                <div class="mb-3">
                    <label for="observaciones_extra" class="form-label">Observaciones:</label>
                    <input type="text" class="form-control" id="observaciones_extra" placeholder="Ingrese las observaciones" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardar_ejercicio_extra">Guardar</button>
            </div>
        </div>
    </div>
</div>
