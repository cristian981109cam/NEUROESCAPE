// Select2
$(document).ready(function () {
    $("#nombre_extra").select2({
        dropdownParent: $("#ModalEjercicioExtra"),
        theme: "classic", // Tema de Select2
        placeholder: "Seleccione un ejercicio", // Texto de placeholder
        allowClear: true, // Permitir limpiar la selección
        width: "100%", // Ajustar el ancho al 100%
    });
});

// Agregar nueva asignación desde la tabla
$("#dataTable tbody").on("click", ".agregar", function () {
    var data = datatable.row($(this).parents("tr")).data();
    // Guardar datos del usuario en campos ocultos
    $("#ejercicio_extra_user_id").val(data.users.id);
    $("#ejercicio_extra_fecha").val(data.start);
    $("#fk_id_microciclo_principal").val(data.id);
    // Limpiar y cargar el selector de ejercicios
    getexercise_routines_extra();
    // Limpiar campos de ejercicio
    $("#repeticiones_extra").val("");
    $("#series_extra").val("");
    $("#intervalos_extra").val("");
    $("#observaciones_extra").val("");
});

// Cargar ejercicios para el modal de ejercicio extra
function getexercise_routines_extra() {
    $.ajax({
        type: "GET",
        url: "/exercise_routines/@",
        success: function (response) {
            var html = '<option value="@" hidden>Seleccione </option>';
            $.each(response.data, function (key, val) {
                html += `<option value="${val.id}">${val.nombre}</option>`;
            });
            $("#nombre_extra").html(html);
        },
        error: function (xhr) {
            console.error(
                "Error al cargar la rutina de ejercicio: ",
                xhr.responseText
            );
        },
    });
}

// Guardar ejercicio extra
$("#guardar_ejercicio_extra").click(function (e) {
    e.preventDefault();
    let data = new FormData();
    data.append("id", "");
    data.append("usuario", $("#ejercicio_extra_user_id").val());
    data.append("nombre", $("#nombre_extra").val());
    data.append("repeticiones", $("#repeticiones_extra").val());
    data.append("series", $("#series_extra").val());
    data.append("intervalos", $("#intervalos_extra").val());
    data.append("observaciones", $("#observaciones_extra").val());
    data.append("fecha", $("#ejercicio_extra_fecha").val());
    data.append("fk_id_microciclo_principal",$("#fk_id_microciclo_principal").val());
    data.append("es_extra", true); // Indicar que es un ejercicio extra

    save_ejercicio_extra(data);
});

// Función para guardar ejercicio extra

// function save_ejercicio_extra(data) {
//     $.ajax({
//         type: "POST",
//         url: "/guardar/user_assignments",
//         data: data,
//         processData: false,
//         contentType: false,
//         success: function (response) {
//             if (response.status === "success") {
//                 Swal.fire(response.title, response.msg, response.status);
//                 $("#ModalEjercicioExtra").modal("hide");
//             } else {
//                 Swal.fire(response.title, response.msg, response.status);
//             }
//         },
//         error: function (xhr) {
//             console.error(xhr.responseText);
//             Swal.fire(
//                 "Error",
//                 "Ocurrió un error al intentar guardar.",
//                 "error"
//             );
//         },
//     });
// }

function save_ejercicio_extra(data) {
    $.ajax({
        type: "POST",
        url: "/guardar/user_assignments",
        data: data,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.status === "success") {
                Swal.fire(response.title, response.msg, response.status);
                $("#ModalEjercicioExtra").modal("hide");
                // Recargar el listado de ejercicios
                cargarEjerciciosUsuario(
                    $("#ejercicio_extra_user_id").val(),
                    $("#ejercicio_extra_fecha").val(),
                    "Nombre del Usuario" // Aquí debes obtener el nombre del usuario
                );
            } else {
                Swal.fire(response.title, response.msg, response.status);
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire(
                "Error",
                "Ocurrió un error al intentar guardar.",
                "error"
            );
        },
    });
}
