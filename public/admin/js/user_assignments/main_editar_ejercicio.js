// Ver ejercicios asignados
$("#dataTable tbody").on("click", ".ver-ejercicios", function () {
    var data = datatable.row($(this).parents("tr")).data();
    cargarEjerciciosUsuario(data.users.id, data.start, data.users.name);
});

// Select2
$(document).ready(function() {
    $('#editar_nombre').select2({
        dropdownParent: $('#ModalEditarEjercicio'),
        theme: "classic", // Tema de Select2
        placeholder: "Seleccione un ejercicio", // Texto de placeholder
        allowClear: true, // Permitir limpiar la selección
        width: '100%' // Ajustar el ancho al 100%
    });
});

// Función para cargar ejercicios del usuario
// function cargarEjerciciosUsuario(userId, fecha, userName) {
//     $.ajax({
//         type: "GET",
//         url: "/user_assignments/@",
//         success: function (response) {
//             if (response.success) {
//                 // Filtrar las asignaciones para este usuario y fecha
//                 var ejercicios = response.data.filter(function (asignacion) {
//                     return (
//                         asignacion.fk_id_assignament_user == userId &&
//                         asignacion.start == fecha
//                     );
//                 });

//                 // Limpiar y llenar la tabla de ejercicios
//                 var tbody = $("#tablaEjercicios tbody");
//                 tbody.empty();

//                 ejercicios.forEach(function (ejercicio) {
//                     tbody.append(`
//                         <tr data-id="${ejercicio.id}">
//                             <td>${ejercicio.exercise_routines.nombre}</td>
//                             <td>${ejercicio.repeticiones}</td>
//                             <td>${ejercicio.series}</td>
//                             <td>${ejercicio.intervalos}</td>
//                             <td>${ejercicio.observaciones}</td>
//                             <td>
//                                 <button class="editar-ejercicio btn btn-sm btn-warning text-white"><i class="fa-solid fa-pencil"></i></button>
//                                 <button class="eliminar-ejercicio btn btn-sm btn-danger text-white"><i class="fa-solid fa-trash-can"></i></button>
//                                 <button class="ver-imagen-ejercicio btn btn-sm btn-info text-white"><i class="fa-solid fa-eye"></i></button>
//                                 <button class="ver-video-ejercicio btn btn-sm btn-primary text-white"><i class="fa-solid fa-video"></i></button>
//                             </td>
//                         </tr>
//                     `);
//                 });

//                 // Actualizar el título del modal
//                 $("#modalVerEjerciciosLabel").text(
//                     `Ejercicios de ${userName} - ${fecha}`
//                 );
//             }
//         },
//         error: function (xhr) {
//             Swal.fire(
//                 "Error",
//                 "No se pudieron cargar los ejercicios.",
//                 "error"
//             );
//         },
//     });
// }

// var samuel;
// function cargarEjerciciosUsuario(userId, fecha, userName) {
//     $.ajax({
//         type: "GET",
//         url: "/user_assignments/@",
//         success: function (response) {
//             //console.log(response); // Inspecciona la respuesta en la consola
//             if (response.success) {
//                 // Filtrar las asignaciones para este usuario y fecha
//                 var ejercicios = response.data.filter(function (asignacion) {
//                     return (
//                         asignacion.fk_id_assignament_user == userId &&
//                         asignacion.start == fecha
//                     );
//                 });

//                 // Limpiar y llenar la tabla de ejercicios
//                 var tbody = $("#tablaEjercicios tbody");
//                 tbody.empty();

//                 ejercicios.forEach(function (ejercicio) {
//                     // Verifica si exercise_routines está definido
//                     if (ejercicio.exercise_routines) {
//                         tbody.append(`
//                             <tr data-id="${ejercicio.id}">
//                                 <td>${ejercicio.exercise_routines.nombre}</td>
//                                 <td>${ejercicio.repeticiones}</td>
//                                 <td>${ejercicio.series}</td>
//                                 <td>${ejercicio.intervalos}</td>
//                                 <td>${ejercicio.observaciones}</td>
//                                 <td>
//                                     <button class="editar-ejercicio btn btn-sm btn-warning text-white"><i class="fa-solid fa-pencil"></i></button>
//                                     <button class="eliminar-ejercicio btn btn-sm btn-danger text-white"><i class="fa-solid fa-trash-can"></i></button>
//                                     <button class="ver-imagen-ejercicio btn btn-sm btn-secondary text-white" data-bs-toggle="modal" data-bs-target="#ModalImagen"><i class="fa-solid fa-eye"></i></button>
//                                     <button class="ver-video-ejercicio btn btn-sm btn-primary text-white" data-bs-toggle="modal" data-bs-target="#ModalVideo"><i class="fa-solid fa-video"></i></button>
//                                 </td>
//                             </tr>
//                         `);
//                     } else {
//                         //console.error("Exercise routines no está definido para el ejercicio:", ejercicio);
//                     }
//                 });
//                 samuel = $('#tablaEjercicios').DataTable();

//                 // Actualizar el título del modal
//                 $("#modalVerEjerciciosLabel").text(
//                     `Ejercicios de ${userName} - ${fecha}`
//                 );
//             }
//         },
//         error: function (xhr) {
//             Swal.fire(
//                 "Error",
//                 "No se pudieron cargar los ejercicios.",
//                 "error"
//             );
//         },
//     });
// }

var tablaEjercicios;
function cargarEjerciciosUsuario(userId, fecha, userName) {
    $.ajax({
        type: "GET",
        url: "/user_assignments/@",
        success: function (response) {
            // console.log(response); // Inspecciona la respuesta en la consola
            if (response.success) {
                // Filtrar las asignaciones para este usuario y fecha
                var ejercicios = response.data.filter(function (asignacion) {
                    return (
                        asignacion.fk_id_assignament_user == userId &&
                        asignacion.start == fecha
                    );
                });

                // Limpiar y llenar la tabla de ejercicios
                var tbody = $("#tablaEjercicios tbody");
                tbody.empty();

                ejercicios.forEach(function (ejercicio) {
                    // Verifica si exercise_routines está definido
                    if (ejercicio.exercise_routines) {
                        tbody.append(`
                            <tr data-id="${ejercicio.id} "data-img="${ejercicio.exercise_routines.img}" data-video="${ejercicio.exercise_routines.video_url}">
                                <td>${ejercicio.exercise_routines.nombre}</td>
                                <td>${ejercicio.repeticiones}</td>
                                <td>${ejercicio.series}</td>
                                <td>${ejercicio.intervalos}</td>
                                <td>${ejercicio.observaciones}</td>
                                <td>
                                    <button class="editar-ejercicio btn btn-sm btn-warning text-white"><i class="fa-solid fa-edit"></i></button>
                                    <button class="eliminar-ejercicio btn btn-sm btn-danger text-white"><i class="fa-solid fa-trash"></i></button>
                                    <button class="ver-imagen-ejercicio btn btn-sm btn-secondary text-white"><i class="fa-solid fa-image"></i></button>
                                    <button class="ver-video-ejercicio btn btn-sm btn-primary text-white"><i class="fa-solid fa-video"></i></button>
                                </td>
                            </tr>
                        `);
                    } else {
                        // console.error("Exercise routines no está definido para el ejercicio:", ejercicio);
                    }
                });
                // Inicializar la tabla como DataTable
                if ($.fn.DataTable.isDataTable('#tablaEjercicios')) {
                    $('#tablaEjercicios').DataTable().destroy();
                }
                tablaEjercicios = $('#tablaEjercicios').DataTable({
                    responsive: true,
                    autoWidth: false,
                    lengthChange: true,
                    searching: true,
                });

                // Actualizar el título del modal
                $("#modalVerEjerciciosLabel").text(
                    `Ejercicios de ${userName} - ${fecha}`
                );
            }
        },
        error: function (xhr) {
            Swal.fire(
                "Error",
                "No se pudieron cargar los ejercicios.",
                "error"
            );
        },
    });
}

// Editar ejercicio desde el modal de ver ejercicios
$("#tablaEjercicios").on("click", ".editar-ejercicio", function () {
    var row = $(this).closest("tr");
    var id = row.data("id");

    // Obtener los datos del ejercicio
    $.ajax({
        type: "GET",
        url: "/user_assignments/@",
        success: function (response) {
            if (response.success) {
                // Encontrar el ejercicio específico
                var ejercicio = response.data.find(function (item) {
                    return item.id == id;
                });

                if (ejercicio) {
                    // Cargar el selector de ejercicios
                    $.ajax({
                        type: "GET",
                        url: "/exercise_routines/@",
                        success: function (response) {
                            var html =
                                '<option value="@" hidden>Seleccione </option>';
                            $.each(response.data, function (key, val) {
                                html += `<option value="${val.id}" ${
                                    ejercicio.fk_id_exercise_routine == val.id
                                        ? "selected"
                                        : ""
                                }>${val.nombre}</option>`;
                            });
                            $("#editar_nombre").html(html);
                        },
                    });

                    // Llenar los campos del modal
                    $("#editar_ejercicio_id").val(ejercicio.id);
                    $("#editar_repeticiones").val(ejercicio.repeticiones);
                    $("#editar_series").val(ejercicio.series);
                    $("#editar_intervalos").val(ejercicio.intervalos);
                    $("#editar_observaciones").val(ejercicio.observaciones);

                    // Abrir el modal
                    $("#ModalEditarEjercicio").modal("show");
                }
            }
        },
    });
});

// Guardar ejercicio editado
$("#guardar_editar_ejercicio").click(function (e) {
    e.preventDefault();
    let data = new FormData();
    data.append("id", $("#editar_ejercicio_id").val());
    data.append("nombre", $("#editar_nombre").val());
    data.append("repeticiones", $("#editar_repeticiones").val());
    data.append("series", $("#editar_series").val());
    data.append("intervalos", $("#editar_intervalos").val());
    data.append("observaciones", $("#editar_observaciones").val());
    data.append("fk_id_microciclo_principal",$("#fk_id_microciclo_principal").val());
    data.append("es_extra", true); // Indicar que es un ejercicio extra

    // Obtener usuario y fecha del ejercicio original
    $.ajax({
        type: "GET",
        url: "/user_assignments/@",
        success: function (response) {
            if (response.success) {
                var ejercicio = response.data.find(function (item) {
                    return item.id == $("#editar_ejercicio_id").val();
                });

                if (ejercicio) {
                    data.append("usuario", ejercicio.fk_id_assignament_user);
                    data.append("fecha", ejercicio.start);

                    // Guardar los cambios
                    $.ajax({
                        type: "POST",
                        url: "/guardar/user_assignments",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.status === "success") {
                                // Mostrar mensaje de éxito
                                Swal.fire(
                                    response.title,
                                    response.msg,
                                    response.status
                                );
                                // Cerrar el modal de edición
                                $("#ModalEditarEjercicio").modal("hide");
                                // Recargar la lista de ejercicios
                                cargarEjerciciosUsuario(
                                    ejercicio.fk_id_assignament_user,
                                    ejercicio.start,
                                    ejercicio.users.name
                                );
                                // Recargar el datatable y el calendario
                                datatable.ajax.reload();
                                calendar.refetchEvents();
                            } else {
                                Swal.fire(
                                    response.title,
                                    response.msg,
                                    response.status
                                );
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
            }
        },
    });
});

// Eliminar ejercicio desde el modal de ver ejercicios
$("#tablaEjercicios").on("click", ".eliminar-ejercicio", function () {
    var row = $(this).closest("tr");
    var id = row.data("id");

    Swal.fire({
        title: "¿Estás seguro?",
        text: "No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminar!",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "delete",
                url: "/user_assignments/destroy/" + id,
                success: function (response) {
                    if (response.status === "success") {
                        row.remove();
                        Swal.fire(
                            response.title,
                            response.msg,
                            response.status
                        );
                    } else {
                        Swal.fire(
                            response.title,
                            response.msg,
                            response.status
                        );
                    }
                },
                error: function (xhr) {
                    Swal.fire(
                        "Error",
                        "No se pudo eliminar el ejercicio.",
                        "error"
                    );
                },
            });
        }
    });
});


// El del parking funciona
// Listeners para los botones en tablaEjercicios (segundo modal):
// $('#tablaEjercicios tbody').on('click', '.ver-imagen-ejercicio', function() {
//     if (!tablaEjercicios) {
//         console.error("tablaEjercicios no está inicializada.");
//         return;
//     }

//     var row = $(this).parents('tr');
//     if (row.length === 0) {
//         console.error("No se encontró la fila.");
//         return;
//     }

//     var data = tablaEjercicios.row(row).data();
//     if (!data) {
//         console.error("No se encontraron datos para la fila.");
//         return;
//     }

//     var imgSrc = data.img ? `/storage/${data.img}` : '/storage/default.jpg';
//     $('#ModalImagen .modal-body img').attr('src', imgSrc);

//     // Cerrar el modal padre y abrir el nuevo
//     $('#ModalVerEjercicios').modal('hide');
//     $('#ModalImagen').modal('show');
// });

// $('#tablaEjercicios tbody').on('click', '.ver-video-ejercicio', function() {
//     if (!tablaEjercicios) {
//         console.error("tablaEjercicios no está inicializada.");
//         return;
//     }

//     var row = $(this).parents('tr');
//     if (row.length === 0) {
//         console.error("No se encontró la fila.");
//         return;
//     }

//     var data = tablaEjercicios.row(row).data();
//     if (!data) {
//         console.error("No se encontraron datos para la fila.");
//         return;
//     }

//     // var videoUrl = data.video_url || '';
//     // if (videoUrl) {
//     //     var videoId = videoUrl.split('v=')[1].split('&')[0];
//     //     $('#ModalVideo iframe').attr('src', `https://www.youtube.com/embed/${videoId}`);
//     // } else {
//     //     alert('No hay video disponible.');
//     // }

//     // Evitar que se carguen ciertos scripts de publicidad agregando el parámetro origin a la URL del iframe
//     var videoUrl = data.video_url || '';
//     if (videoUrl) {
//         var videoId = videoUrl.split('v=')[1].split('&')[0];
//         var iframeSrc = `https://www.youtube.com/embed/${videoId}?origin=${window.location.origin}`;
//         $('#ModalVideo iframe').attr('src', iframeSrc);
//     } else {
//         alert('No hay video disponible.');
//     }

//     // Cerrar el modal padre y abrir el nuevo
//     $('#ModalVerEjercicios').modal('hide');
//     $('#ModalVideo').modal('show');
// });

// // Al cerrar el modal, detén el video
// $('#ModalVideo').on('hidden.bs.modal', function() {
//     // Detener el video al cerrar el modal
//     $('#ModalVideo iframe').attr('src', '');
// });





// // Funciona correctamente
// // Función para mostrar la imagen de un ejercicio en un modal
// $('#tablaEjercicios tbody').on('click', '.ver-imagen-ejercicio', function() {
//     var row = $(this).closest('tr');
//     var imgSrc = row.data('img') ? `/storage/${row.data('img')}` : '/storage/default.jpg';
    
//     $('#ModalImagen .modal-body img').attr('src', imgSrc);
    
//     $('#ModalImagen').modal('show');

//     // Cerrar el modal padre y abrir el nuevo
//     $('#ModalVerEjercicios').modal('hide');
//     $('#ModalImagen').modal('show');
// });

// // Función para mostrar el video de un ejercicio en un modal
// $('#tablaEjercicios tbody').on('click', '.ver-video-ejercicio', function() {
//     var row = $(this).closest('tr');
//     var videoUrl = row.data('video');

//     if (videoUrl) {
//         var videoId = videoUrl.split('v=')[1]?.split('&')[0] || "";
//         var iframeSrc = `https://www.youtube.com/embed/${videoId}`;
//         $('#ModalVideo iframe').attr('src', iframeSrc);
//     } else {
//         Swal.fire("Error", "No hay video disponible para este ejercicio.", "error");
//     }

//     $('#ModalVideo').modal('show');
//     // Cerrar el modal padre y abrir el nuevo
//     $('#ModalVerEjercicios').modal('hide');
//     $('#ModalVideo').modal('show');
// });

// // Detener el video al cerrar el modal
// $('#ModalVideo').on('hidden.bs.modal', function() {
//     $('#ModalVideo iframe').attr('src', '');
    
// });





// Función para mostrar la imagen de un ejercicio en un modal
$('#tablaEjercicios tbody').on('click', '.ver-imagen-ejercicio', function() {
    // console.log("Click detectado en botón de imagen");

    var row = $(this).closest('tr'); // Obtiene la fila más cercana
    // console.log("Fila encontrada:", row);

    var tablaEjercicios = $('#tablaEjercicios').DataTable(); // Asegura que DataTables esté inicializado

    if (!$.fn.DataTable.isDataTable('#tablaEjercicios')) {
        // console.error("Error: DataTable no está inicializado.");
        return;
    }

    if (!tablaEjercicios) {
        // console.error("Error: No se encontró tablaEjercicios.");
        return;
    }

    var data = tablaEjercicios.row(row).data(); // Intenta obtener datos desde DataTables
    // console.log("Datos obtenidos de DataTables:", data);

    var imgSrc = "/storage/Neuroescape.jpg"; // Imagen por defecto

    if (data && data.img) {
        imgSrc = `/storage/${data.img}`;
    } else if (row.attr('data-img')) {
        imgSrc = `/storage/${row.attr('data-img')}`;
    } else {
        // console.warn("Advertencia: No se encontró imagen, usando la predeterminada.");
    }

    // console.log("Imagen a mostrar:", imgSrc);

    $('#ModalImagen .modal-body img').attr('src', imgSrc);
    
    $('#ModalVerEjercicios').modal('hide');
    $('#ModalImagen').modal('show');
});

// Función para mostrar el video de un ejercicio en un modal
$('#tablaEjercicios tbody').on('click', '.ver-video-ejercicio', function() {
    // console.log("Click detectado en botón de video");

    var row = $(this).closest('tr'); // Obtiene la fila más cercana
    // console.log("Fila encontrada:", row);

    var tablaEjercicios = $('#tablaEjercicios').DataTable(); // Verifica si DataTables está inicializado

    if (!$.fn.DataTable.isDataTable('#tablaEjercicios')) {
        // console.error("Error: DataTable no está inicializado.");
        return;
    }

    if (!tablaEjercicios) {
        // console.error("Error: No se encontró tablaEjercicios.");
        return;
    }

    var data = tablaEjercicios.row(row).data(); // Intenta obtener datos desde DataTables
    // console.log("Datos obtenidos de DataTables:", data);

    var videoUrl = ""; // Inicializar la variable vacía

    if (data && data.video) {
        videoUrl = data.video;
    } else if (row.attr('data-video')) {
        videoUrl = row.attr('data-video');
    } else {
        // console.warn("Advertencia: No se encontró un video para este ejercicio.");
    }

    // console.log("URL del video obtenida:", videoUrl);

    if (videoUrl) {
        var videoId = "";
        
        // Extraer el ID del video de la URL de YouTube
        if (videoUrl.includes("youtube.com/watch?v=")) {
            videoId = videoUrl.split('v=')[1]?.split('&')[0] || "";
        } else if (videoUrl.includes("youtu.be/")) {
            videoId = videoUrl.split('youtu.be/')[1]?.split('?')[0] || "";
        }

        // console.log("ID del video extraído:", videoId);

        if (videoId) {
            var iframeSrc = `https://www.youtube.com/embed/${videoId}`;
            $('#ModalVideo iframe').attr('src', iframeSrc);
        } else {
            // console.error("Error: No se pudo extraer un ID válido de la URL.");
            Swal.fire("Error", "No se pudo cargar el video correctamente.", "error");
            return;
        }
    } else {
        Swal.fire("Error", "No hay video disponible para este ejercicio.", "error");
        return;
    }

    // Cerrar el modal padre y abrir el nuevo
    $('#ModalVerEjercicios').modal('hide');
    $('#ModalVideo').modal('show');
});

// Detener el video al cerrar el modal
$('#ModalVideo').on('hidden.bs.modal', function() {
    $('#ModalVideo iframe').attr('src', '');
    
});