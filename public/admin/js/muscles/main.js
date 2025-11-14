var datatable = $("#dataTable").DataTable({
    responsive: true,
    ajax: "/muscles/@",
    columns: [
        {
            data: "id",
        },
        {
            data: "nombre",
        },
        {
            data: "descripcion",
        },
        {
            data: "estado",
            render: function (data, type, row) {
                let checked = data == 1 ? "checked" : "";
                return `
                    <div class="form-check form-switch">
                        <input class="form-check-input toggle-estado" type="checkbox" data-id="${row.id}" ${checked}>
                    </div>
                `;
            },
        },
        {
            render: function () {
                return `
                    <button class="editar btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#ModalMusculo"><i class="fa-solid fa-pencil"></i></button>
                    <button class="clonar btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#ModalMusculo"><i class="fa-solid fa-clone"></i></button>
                    <button class="delete btn btn-sm btn-danger text-white"><i class="fa-solid fa-trash-can"></i></button>
                    `;
            },
        },
    ],
});

// Botón para abrir el modal de creación
$("#crearMusculo").click(function (e) {
    e.preventDefault();
    $("#id").val(""); //limpiar el modal
    $("#nombre").val(""); //limpiar el modal
    $("#descripcion").val(""); //limpiar el modal
    $("#ModalMusculo").modal();
});

// Guardar
$("#guardar").click(function (e) {
    e.preventDefault();
    recolector();
});

function recolector() {
    let data = new FormData();
    data.append("id", $("#id").val());
    data.append("nombre", $("#nombre").val());
    data.append("descripcion", $("#descripcion").val());
    save(data);
}

function save(data) {
    $.ajax({
        type: "POST",
        url: "/guardar/muscles",
        data: data,
        processData: false,
        contentType: false,
        success: function (response, textStatus, jqXHR) {
            Swal.fire(response.title, response.msg, response.status);
            if (response.status == "success") {
                datatable.ajax.reload();
                $("#ModalMusculo").modal("hide");
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
    $("#nombre").val(data.nombre);
    $("#descripcion").val(data.descripcion);
    // $("#ModalCategoria").modal();
});

// Clonar
$("#dataTable tbody").on("click", ".clonar", function () {
    var data = datatable.row($(this).parents("tr")).data();
    $("#id").val("");
    $("#nombre").val(data.nombre);
    $("#descripcion").val(data.descripcion);
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
                url: "/muscles/destroy/" + data.id,
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

// Cambiar estado con el interruptor
$("#dataTable tbody").on("change", ".toggle-estado", function () {
    let id = $(this).data("id");
    let nuevoEstado = $(this).is(":checked") ? 1 : 0;

    // Enviar la actualización al servidor
    $.ajax({
        type: "POST",
        url: `/muscles/estado/${id}`,
        data: {
            estado: nuevoEstado,
            _token: $('meta[name="csrf-token"]').attr("content"), // Token CSRF
        },
        success: function (response) {
            Swal.fire(response.title, response.msg, response.status);
            if (response.status === "success") {
                datatable.ajax.reload(); // Recargar tabla si es necesario
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire(
                "Error",
                "Ocurrió un error al intentar actualizar el estado.",
                "error"
            );
        },
    });
});
