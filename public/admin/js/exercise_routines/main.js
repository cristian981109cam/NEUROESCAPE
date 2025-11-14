var datatable = $("#dataTable").DataTable({
    responsive: true,
    ajax: "/exercise_routines/@",
    columns: [
        {
            data: "id",
        },
        {
            data: "muscles.nombre",
        },
        {
            data: "nombre",
        },
        {
            data: "descripcion",
        },
        {
            data: "img",
            render: function (data) {
                // Si no hay imagen, usa una por defecto
                const imgSrc = data
                ? `/storage/${data}`  // Si hay imagen, carga desde el almacenamiento público
                : "/storage/Neuroescape.jpg";  // Si no hay imagen, usa la imagen predeterminada
                return `<img src="${imgSrc}" alt="Imagen" class="img-fluid" style="max-height: 50px;">`;
            },
        },
        {
            data: "video_url",
        },
        {
            render: function () {
                return `
                    <button class="editar btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#ModalRutinaEjercicio"><i class="fa-solid fa-pencil"></i></button>
                    <button class="clonar btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#ModalRutinaEjercicio"><i class="fa-solid fa-clone"></i></button>
                    <button class="delete btn btn-sm btn-danger text-white"><i class="fa-solid fa-trash-can"></i></button>
                    `;
            },
        },
    ],
});

// Select2
$(document).ready(function() {
    $('#muscles').select2({
        dropdownParent: $('#ModalRutinaEjercicio'),
        theme: "classic", // Tema de Select2
        placeholder: "Seleccione un musculo", // Texto de placeholder
        allowClear: true, // Permitir limpiar la selección
        width: '100%' // Ajustar el ancho al 100%
    });
});

// Botón para abrir el modal de creación
$("#crearRutinaEjercicio").click(function (e) {
    e.preventDefault();
    $("#id").val(""); //limpiar el modal
    getmuscles();
    $("#nombre").val(""); //limpiar el modal
    $("#descripcion").val(""); //limpiar el modal
    $("#img").val(null); //limpiar el modal
    $("#video_url").val(""); //limpiar el modal
    // Limpiar la vista previa de la imagen
    $("#previewImage")
        .attr("src", "") // Remover la fuente de la imagen
        .addClass("d-none"); // Ocultar la imagen de vista previa
    $("#ModalRutinaEjercicio").modal();
});

function getmuscles(id) {
    $.ajax({
        type: "GET",
        url: "/muscles/@",
        success: function (response) {
            var html = '<option value="@" hidden>Seleccione </option>';
            $.each(response.data, function (key, val) {
                html += `<option value="${val.id}" ${
                    id == val.id ? "selected" : ""
                }>${val.nombre}</option>`;
            });
            $("#muscles").html(html);
        },
        error: function (xhr) {
            console.error("Error al cargar músculos: ", xhr.responseText);
        },
    });
}

// Guardar
$("#guardar").click(function (e) {
    e.preventDefault();
    recolector();
});

function recolector() {
    let data = new FormData();
    data.append("id", $("#id").val());
    data.append("muscles", $("#muscles").val());
    data.append("nombre", $("#nombre").val());
    data.append("descripcion", $("#descripcion").val());
    // Verifica si se seleccionó una imagen
    const imgFile = $("#img")[0].files[0];
    if (imgFile) {
        data.append("img", imgFile);
    }
    data.append("video_url", $("#video_url").val());
    save(data);
}

function save(data) {
    $.ajax({
        type: "POST",
        url: "/guardar/exercise_routines",
        data: data,
        processData: false,
        contentType: false,
        success: function (response, textStatus, jqXHR) {
            Swal.fire(response.title, response.msg, response.status);
            if (response.status == "success") {
                datatable.ajax.reload();
                $("#ModalRutinaEjercicio").modal("hide");
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            console.error(xhr.responseText); // Mostrar el error exacto en la consola
            Swal.fire(
                "Error",
                "Ocurrió un error al intentar guardar.",
                "error"
            );
        },
    });
}

// Editar
$("#dataTable tbody").on("click", ".editar", function () {
    var data = datatable.row($(this).parents("tr")).data();
    $("#id").val(data.id);
    getmuscles(data.fk_id_parameter_muscle);
    $("#nombre").val(data.nombre);
    $("#descripcion").val(data.descripcion);

    // Configurar la vista previa de la imagen
    if (data.img) {
        $("#previewImage")
            .attr("src", `/storage/${data.img}`)
            .removeClass("d-none"); // Mostrar la imagen si existe
    } else {
        $("#previewImage")
            .attr("src", "")
            .addClass("d-none"); // Ocultar si no hay imagen
    }
    $("#video_url").val(data.video_url);
    // $("#ModalCategoria").modal();
});

// Clonar
$("#dataTable tbody").on("click", ".clonar", function () {
    var data = datatable.row($(this).parents("tr")).data();
    $("#id").val("");
    getmuscles(data.fk_id_parameter_muscle);
    $("#nombre").val(data.nombre);
    $("#descripcion").val(data.descripcion);
    // Configurar o limpiar la vista previa de la imagen
    if (data.img) {
        $("#previewImage")
            .attr("src", `/storage/${data.img}`)
            .removeClass("d-none");
    } else {
        $("#previewImage")
            .attr("src", "")
            .addClass("d-none");
    }
    $("#video_url").val(data.video_url);
    // $("#ModalCategoria").modal();
});

// Eliminar
$("#dataTable tbody").on("click", ".delete", function () {
    var data = datatable.row($(this).parents("tr")).data();
    Swal.fire({
        title: "Estas seguro?",
        text: "No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, borralo!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "delete",
                url: "/exercise_routines/destroy/" + data.id,
                success: function (response, textStatus, jqXHR) {
                    Swal.fire(response.title, response.msg, response.status);
                    if (response.status == "success") {
                        datatable.ajax.reload();
                        // $("#ModalCategoria").modal("hide");
                    }
                },
            });
        }
    });
});
