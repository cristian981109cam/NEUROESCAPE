var datatable = $("#dataTable").DataTable({
    responsive: true,
    ajax: {
        url: "/user_assignments/@",
        dataSrc: function (response) {
            // Filtrar solo las asignaciones principales
            return response.data.filter(function (item) {
                return item.tipo === "principal";
            });
        },
    },
    columns: [
        {
            data: "id",
        },
        {
            data: "start",
        },
        {
            data: "users.name",
        },
        // {
        //     data: "exercise_routines.nombre",
        // },
        // {
        //     data: "repeticiones",
        // },
        // {
        //     data: "series",
        // },
        // {
        //     data: "intervalos",
        // },
        {
            data: "objetivos",
        },
        {
            data: "materiales",
        },
        {
            data: "tiempo_total",
        },
        {
            data: "descripcion",
            render: function (data, type, row) {
                // Asumimos que `data` contiene el enlace
                return data ? `<a href="${data}" target="_blank" class="btn btn-primary">Entra a tu consulta!</a>` : 'No hay enlace';
            }
        },
        // {
        //     data: "observaciones",
        // },
        {
            render: function () {
                return `
                    <button class="editar btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#ModalUsuarioAsignado"><i class="fa-solid fa-edit"></i></button>
                    <button class="clonar btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#ModalUsuarioAsignado"><i class="fa-solid fa-clone"></i></button>
                    <button class="delete btn btn-sm btn-danger text-white"><i class="fa-solid fa-trash"></i></button>
                    <button class="agregar btn btn-sm btn-success text-white" data-bs-toggle="modal" data-bs-target="#ModalEjercicioExtra"><i class="fa-solid fa-plus"></i></button>
                    <button class="ver-ejercicios btn btn-sm btn-primary text-white" data-bs-toggle="modal" data-bs-target="#ModalVerEjercicios"><i class="fa-solid fa-list"></i></button>
                    `;
            },
        },
    ],
});

// Select2
$(document).ready(function() {
    $('#usuario').select2({
        dropdownParent: $('#ModalUsuarioAsignado'),
        theme: "classic", // Tema de Select2
        placeholder: "Seleccione un usuario", // Texto de placeholder
        allowClear: true, // Permitir limpiar la selección
        width: '100%' // Ajustar el ancho al 100%
    });
});

// Botón para abrir el modal de creación
$("#crearUsuarioAsignado").click(function (e) {
    e.preventDefault();
    $("#id").val(""); //limpiar el modal
    getuser();
    // getexercise_routines();
    // $("#repeticiones").val(""); //limpiar el modal
    // $("#series").val(""); //limpiar el modal
    // $("#intervalos").val(""); //limpiar el modal
    $("#objetivos").val(""); //limpiar el modal
    $("#materiales").val(""); //limpiar el modal
    $("#tiempo_total").val(""); //limpiar el modal
    $("#descripcion").val(""); //limpiar el modal
    var today = new Date().toISOString().split("T")[0];
    $("#fecha").val(today); // Trae la fecha actual
    // $("#fecha").val(""); //limpiar el modal
    // $("#f_final").val(""); //limpiar el modal
});

function getuser(id) {
    $.ajax({
        type: "GET",
        url: "/user/@",
        success: function (response) {
            var html = '<option value="@" hidden>Seleccione </option>';
            $.each(response.data, function (key, val) {
                html += `<option value="${val.id}" ${
                    id == val.id ? "selected" : ""
                }>${val.name}</option>`;
            });
            $("#usuario").html(html);
        },
        error: function (xhr) {
            console.error(
                "Error al cargar el nombre del usuario: ",
                xhr.responseText
            );
        },
    });
}

function getexercise_routines(id) {
    $.ajax({
        type: "GET",
        url: "/exercise_routines/@",
        success: function (response) {
            var html = '<option value="@" hidden>Seleccione </option>';
            $.each(response.data, function (key, val) {
                html += `<option value="${val.id}" ${
                    id == val.id ? "selected" : ""
                }>${val.nombre}</option>`;
            });
            $("#nombre").html(html);
        },
        error: function (xhr) {
            console.error(
                "Error al cargar la rutina de ejercicio: ",
                xhr.responseText
            );
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
    data.append("usuario", $("#usuario").val());
    // data.append("name", $("#name").val());
    // data.append("nombre", $("#nombre").val());
    // data.append("repeticiones", $("#repeticiones").val());
    // data.append("series", $("#series").val());
    // data.append("intervalos", $("#intervalos").val());
    data.append("objetivos", $("#objetivos").val());
    data.append("materiales", $("#materiales").val());
    data.append("tiempo_total", $("#tiempo_total").val());
    data.append("descripcion", $("#descripcion").val());
    data.append("fecha", $("#fecha").val());
    // data.append("f_final", $("#f_final").val());
    save(data);
}

function save(data) {
    $.ajax({
        type: "POST",
        url: "/guardar/user_assignments",
        data: data,
        processData: false,
        contentType: false,
        success: function (response, textStatus, jqXHR) {
            if (response.status === "success") {
                // Mostrar mensaje de éxito
                Swal.fire(response.title, response.msg, response.status);
                // Actualizar la tabla y el calendario
                datatable.ajax.reload();
                calendar.refetchEvents();
                // Cerrar el modal
                $("#ModalUsuarioAsignado").modal("hide");
            } else {
                // Si hay un error, mostrar el mensaje pero no cerrar el modal
                Swal.fire(response.title, response.msg, response.status);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            console.error(xhr.responseText);
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
    getuser(data.users.id);
    // getexercise_routines(data.exercise_routines.id);
    // $("#repeticiones").val(data.repeticiones);
    // $("#series").val(data.series);
    // $("#intervalos").val(data.intervalos);
    $("#objetivos").val(data.objetivos);
    $("#materiales").val(data.materiales);
    $("#tiempo_total").val(data.tiempo_total);
    $("#descripcion").val(data.descripcion);
    $("#fecha").val(data.start);
    // $("#f_final").val(data.end);
    // $("#ModalCategoria").modal();
});

// Clonar
$("#dataTable tbody").on("click", ".clonar", function () {
    var data = datatable.row($(this).parents("tr")).data();
    $("#id").val("");
    getuser(data.users.id);
    // getexercise_routines(data.exercise_routines.id);
    // $("#repeticiones").val(data.repeticiones);
    // $("#series").val(data.series);
    // $("#intervalos").val(data.intervalos);
    $("#objetivos").val(data.objetivos);
    $("#materiales").val(data.materiales);
    $("#tiempo_total").val(data.tiempo_total);
    $("#descripcion").val(data.descripcion);
    $("#fecha").val(data.start);
    // $("#f_final").val(data.end);
    calendar.refetchEvents();
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
                url: "/user_assignments/destroy/" + data.id,
                success: function (response, textStatus, jqXHR) {
                    if (response.status === "success") {
                        // Mostrar mensaje de éxito
                        Swal.fire(
                            response.title,
                            response.msg,
                            response.status
                        );
                        // Actualizar la tabla y el calendario
                        datatable.ajax.reload();
                        calendar.refetchEvents();
                    } else {
                        // Si hay un error, mostrar el mensaje
                        Swal.fire(
                            response.title,
                            response.msg,
                            response.status
                        );
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.error(xhr.responseText);
                    Swal.fire(
                        "Error",
                        "Ocurrió un error al intentar eliminar.",
                        "error"
                    );
                },
            });
        }
    });
});

// Variable global para el calendario
var calendar;

// document.addEventListener("DOMContentLoaded", function () {
//     // Inicializamos el calendario con el ID específico
//     var calendarEl = document.getElementById("calendar");
//     calendar = new FullCalendar.Calendar(calendarEl, {
//         initialView: "dayGridMonth", // Vista inicial (mes)
//         locale: "es", // Idioma español
//         headerToolbar: {
//             left: "prev,next today", // Botones para navegar
//             center: "title", // Título de la vista
//             right: "dayGridMonth,timeGridWeek,timeGridDay", // Opciones de vista
//         },
//         // Configuración de los eventos que se cargarán en el calendario
//         events: function (fetchInfo, successCallback, failureCallback) {
//             $.ajax({
//                 url: "/user_assignments/@", // Ruta para obtener las asignaciones de usuario
//                 type: "GET", // Método GET para obtener los datos
//                 success: function (response) {
//                     // Si la respuesta es exitosa
//                     if (response.success) {
//                         // Mapear la respuesta a los eventos del calendario
//                         var events = response.data
//                             .filter(function (assignment) {
//                                 return assignment.tipo === "principal"; // Filtrar solo principales
//                             })
//                             .map(function (assignment) {
//                                 // Verificamos que la propiedad 'users' exista y tenga el nombre
//                                 var userName =
//                                     assignment.users && assignment.users.name
//                                         ? assignment.users.name
//                                         : "Sin Nombre";

//                                 // Si no hay un nombre de usuario válido, asignamos un nombre por defecto
//                                 return {
//                                     title: userName, // Nombre del usuario
//                                     start: assignment.start, // Fecha y hora de inicio
//                                     // end: assignment.end, // Fecha y hora de finalización
//                                     color: "28a745", // Color del evento
//                                     textColor: "#ffffff", // Color del texto (blanco)
//                                 };
//                             });
//                         // Pasamos los eventos al calendario
//                         successCallback(events);
//                     } else {
//                         // Si no se obtiene éxito en la respuesta, mostramos el mensaje de error
//                         failureCallback("Error: " + response.message);
//                     }
//                 },
//                 error: function (xhr, status, error) {
//                     // Manejo de errores en caso de fallo en la petición AJAX
//                     failureCallback(
//                         "Error al cargar los eventos. Estado: " +
//                             status +
//                             ", Error: " +
//                             error
//                     );
//                 },
//             });
//         },
//         buttonText: {
//             today: "Hoy", // Texto del botón "Hoy"
//             month: "Mes", // Texto del botón "Mes"
//             week: "Semana", // Texto del botón "Semana"
//             day: "Día", // Texto del botón "Día"
//             list: "Lista", // Texto del botón "Lista"
//         },
//         // Acción cuando se hace clic en una fecha del calendario
//         dateClick: function (info) {
//             // Limpiar el formulario
//             $("#id").val("");
//             // $("#repeticiones").val("");
//             // $("#series").val("");
//             // $("#intervalos").val("");
//             $("#objetivos").val(""); //limpiar el modal
//             $("#materiales").val(""); //limpiar el modal
//             $("#tiempo_total").val(""); //limpiar el modal
//             $("#descripcion").val(""); //limpiar el modal
//             // Establecer la fecha seleccionada
//             $("#fecha").val(info.dateStr);
//             // Cargar los selectores
//             getuser();
//             // getexercise_routines();
//             // Abrir el modal
//             $("#ModalUsuarioAsignado").modal("show");
//         },
//     });
//     // Renderizamos el calendario
//     calendar.render();
// });

document.addEventListener("DOMContentLoaded", function () {
    // Inicializamos el calendario con el ID específico
    var calendarEl = document.getElementById("calendar");
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth", // Vista inicial (mes)
        locale: "es", // Idioma español
        headerToolbar: {
            left: "prev,next today", // Botones para navegar
            center: "title", // Título de la vista
            right: "dayGridMonth,timeGridWeek,timeGridDay", // Opciones de vista
        },
        // Configuración de los eventos que se cargarán en el calendario
        events: function (fetchInfo, successCallback, failureCallback) {
            $.ajax({
                url: "/user_assignments/@", // Ruta para obtener las asignaciones de usuario
                type: "GET", // Método GET para obtener los datos
                success: function (response) {
                    // Si la respuesta es exitosa
                    if (response.success) {
                        // Mapear la respuesta a los eventos del calendario
                        var events = response.data
                            .filter(function (assignment) {
                                return assignment.tipo === "principal"; // Filtrar solo principales
                            })
                            .map(function (assignment) {
                                // Verificamos que la propiedad 'users' exista y tenga el nombre
                                var userName =
                                    assignment.users && assignment.users.name
                                        ? assignment.users.name
                                        : "Sin Nombre";

                                // Si no hay un nombre de usuario válido, asignamos un nombre por defecto
                                return {
                                    title: userName, // Nombre del usuario
                                    start: assignment.start, // Fecha y hora de inicio
                                    url: assignment.descripcion, // Enlace de la descripción
                                    color: "28a745", // Color del evento
                                    textColor: "#ffffff", // Color del texto (blanco)
                                };
                            });
                        // Pasamos los eventos al calendario
                        successCallback(events);
                    } else {
                        // Si no se obtiene éxito en la respuesta, mostramos el mensaje de error
                        failureCallback("Error: " + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    // Manejo de errores en caso de fallo en la petición AJAX
                    failureCallback(
                        "Error al cargar los eventos. Estado: " +
                            status +
                            ", Error: " +
                            error
                    );
                },
            });
        },
        buttonText: {
            today: "Hoy", // Texto del botón "Hoy"
            month: "Mes", // Texto del botón "Mes"
            week: "Semana", // Texto del botón "Semana"
            day: "Día", // Texto del botón "Día"
            list: "Lista", // Texto del botón "Lista"
        },
        // Acción cuando se hace clic en una fecha del calendario
        dateClick: function (info) {
            // Limpiar el formulario
            $("#id").val("");
            $("#objetivos").val(""); //limpiar el modal
            $("#materiales").val(""); //limpiar el modal
            $("#tiempo_total").val(""); //limpiar el modal
            $("#descripcion").val(""); //limpiar el modal
            // Establecer la fecha seleccionada
            $("#fecha").val(info.dateStr);
            // Cargar los selectores
            getuser();
            // Abrir el modal
            $("#ModalUsuarioAsignado").modal("show");
        },
        // Acción cuando se hace clic en un evento del calendario
        eventClick: function (info) {
            // Obtener el enlace del evento
            var link = info.event.url;
            if (link) {
                // Redirigir al enlace
                window.open(link, '_blank');
            }
            // Evitar que se abra el modal de detalles del evento
            info.jsEvent.preventDefault();
        },
    });
    // Renderizamos el calendario
    calendar.render();
});
