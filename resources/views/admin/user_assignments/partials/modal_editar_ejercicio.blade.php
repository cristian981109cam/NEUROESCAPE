<!-- Modal para editar ejercicio -->
<div class="modal fade" id="ModalEditarEjercicio" tabindex="-1" aria-labelledby="modalEditarEjercicioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarEjercicioLabel">Editar Ejercicio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Campos ocultos -->
                <input type="hidden" id="editar_ejercicio_id">
                
                <div class="mb-3">
                    <label for="editar_nombre" class="form-label">Ejercicio:</label>
                    <select class="form-control" id="editar_nombre"></select>
                </div>
                <div class="mb-3">
                    <label for="editar_repeticiones" class="form-label">Repeticiones:</label>
                    <input type="text" class="form-control" id="editar_repeticiones" placeholder="Ingrese el número de repeticiones" required>
                </div>
                <div class="mb-3">
                    <label for="editar_series" class="form-label">Series:</label>
                    <input type="text" class="form-control" id="editar_series" placeholder="Ingrese el número de series" required>
                </div>
                <div class="mb-3">
                    <label for="editar_intervalos" class="form-label">Intervalos:</label>
                    <input type="text" class="form-control" id="editar_intervalos" placeholder="Ingrese el número de intervalos" required>
                </div>
                <div class="mb-3">
                    <label for="editar_observaciones" class="form-label">Observaciones:</label>
                    <input type="text" class="form-control" id="editar_observaciones" placeholder="Ingrese las observaciones" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardar_editar_ejercicio">Guardar</button>
            </div>
        </div>
    </div>
</div>
