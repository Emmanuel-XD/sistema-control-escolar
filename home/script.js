document.addEventListener('DOMContentLoaded', function () {
    var today = new Date();
    today.setHours(0, 0, 0, 0);

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,list',
        },
        selectable: true,
        themeSystem: 'bootstrap',
        select: function (info) {
            var modalRegistro = $('#modal-registro');
            modalRegistro.modal('show');

            var fechaInicio = info.start;
            var fechaFin = info.end;

            var fechaInicioStr = fechaInicio.toISOString().split('T')[0];
            var fechaFinStr = fechaFin.toISOString().split('T')[0];

            $('#fecha_slt').val(fechaInicioStr);

            // Ajusta la fecha de fin para que sea un día antes
            fechaFin.setDate(fechaFin.getDate() - 1);
            fechaFinStr = fechaFin.toISOString().split('T')[0];
            $('#fecha_fin').val(fechaFinStr);
        },


        eventClick: function (info) {
            var _details = $('#modal-form');
            var id = info.event.id;
            if (!!fila[id]) {
                _details.find('#id').text(fila[id].id);
                _details.find('#fecha_slt').text(fila[id].fecha_slt);
                _details.find('#fecha_fin').text(fila[id].fecha_fin);
                var nombreCompleto = fila[id].nombres + ' ' + fila[id].apellidos;
                _details.find('#nombres').text(nombreCompleto);
                _details.find('#materia').text(fila[id].materia);
                _details.find('#descripcion').text(fila[id].descripcion);
                _details.find('#apellidos').text(fila[id].apellidos);
                _details.find('#hora_in').text(fila[id].hora_in);
                _details.find('#hora_fin').text(fila[id].hora_fin);
                var cantidadUnd = fila[id].cant + ' - ' + fila[id].unidad;
                _details.find('#cant').text(cantidadUnd);
                _details.find('#unidad').text(fila[id].unidad);
                _details.find('#status').text(fila[id].status);
                _details.modal('show');
            } else {
                alert("Event is undefined");
            }
        },
        eventDidMount: function (info) {
            // Puedes agregar lógica adicional para personalizar la apariencia de los eventos aquí
        },
        editable: true,
        events: [],
        validRange: {
            start: today,
        },
    });

    var events = [];
    if (!!fila) {
        Object.keys(fila).map(k => {
            var row = fila[k];

            // Ajusta la fecha de fin para que sea un día después
            var endDate = new Date(row.fecha_fin);
            endDate.setDate(endDate.getDate() + 1);

            events.push({
                id: row.id,
                title: row.materia + ' - ' + row.descripcion,
                start: row.fecha_slt,
                end: endDate.toISOString().split('T')[0],
            });
        });
    }

    calendar.addEventSource(events);


    calendar.render();

    $('#schedule-form').on('reset', function () {
        $(this).find('input:hidden').val('');
        $(this).find('input:visible').first().focus();
    });
});
$(document).ready(function () {
    $('#prestForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '../includes/functions.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    swal.fire({
                        title: 'Éxito',
                        text: response.message,
                        icon: 'success',
                    }).then(function () {
                        window.location = "teacher_calendar.php";
                    });
                } else if (response.status === 'stock_agotado') {
                    swal.fire({
                        title: 'Stock Agotado',
                        text: response.message,
                        icon: 'info',
                    });
                } else if (response.status === 'cantidad_superada') {
                    swal.fire({
                        title: 'Cantidad Superada',
                        text: response.message,
                        icon: 'warning',
                    });
                } else if (response.status === 'error') { // Maneja el caso de cantidad igual a 0
                    swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                    });
                }
            },
            error: function (xhr, status, error) {
                swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error inesperado',
                    icon: 'error',
                });
            }
        });
    });
});