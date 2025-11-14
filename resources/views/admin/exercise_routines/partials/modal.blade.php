<div class="modal fade" id="ModalRutinaEjercicio" tabindex="-1" aria-labelledby="modalRutinaEjercicioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalRutinaEjercicioLabel">Agregar Rutina de Ejercicio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id" value="">
                <div class="mb-3">
                    <label for="muscles" class="form-label">Musculo:</label>
                    <select class="form-control" id="muscles" name="fk_id_parameter_muscle"></select>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Rutina de Ejercicio:</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Ingrese el nombre" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripcion:</label>
                    <input type="text" class="form-control" id="descripcion" placeholder="Ingrese la descripción" required>
                </div>
                <div class="mb-3">
                    <label for="img" class="form-label">Imagen:</label>
                    <input type="file" class="form-control" id="img" accept="image/*">
                    <img id="previewImage" src="" alt="Vista previa de la imagen" class="img-fluid mt-2 d-none" style="max-height: 150px;">
                </div>
                <div class="mb-3">
                    <label for="video_url" class="form-label">Url:</label>
                    <input type="text" class="form-control" id="video_url" placeholder="Ingrese la descripción" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>