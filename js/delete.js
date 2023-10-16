/*$(document).ready(function () {
    // Delegación de eventos para los botones con clase "del-btn"
    $(document).on('click', '.del-btn', function (e) {
        e.preventDefault();

        var id = $(this).data('id');

        Swal.fire({
            title: '¿Estás seguro de eliminar este registro?',
            text: '¡No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '../includes/functions.php',
                    data: {
                        accion: 'delete',
                        id: id
                    },
                    success: function (response) {
                        if (response === 'success') {
                            Swal.fire({
                                title: 'Eliminado',
                                text: 'El registro fue eliminado.',
                                icon: 'success',
                                timer: 1500, // Tiempo en milisegundos antes de recargar
                                showConfirmButton: true, // No mostrar el botón "Ok"
                            }).then(() => {
                                location.reload(); // Recargar la página después de la alerta de éxito
                            });
                        } else {
                            console.log("Error en la solicitud AJAX.");
                            Swal.fire('Error', 'No se pudo eliminar el registro.', 'error');
                        }
                    },
                    error: function () {
                        console.log("Error en la solicitud AJAX.");
                        Swal.fire('Error', 'Hubo un problema en la solicitud.', 'error');
                    }
                });
            }
        });
    });
});

*/
$('.btn-del').on('click', function (e) {
    e.preventDefault();
    const href = $(this).attr('href')

    Swal.fire({
        title: 'Estas seguro de eliminar este registro?',
        text: "¡No podrás revertir esto!!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'Cancelar!',
    }).then((result) => {
        if (result.value) {
            if (result.isConfirmed) {
                Swal.fire(
                    'Eliminado!',
                    'El registro fue eliminado.',
                    'success'
                )
            }

            document.location.href = href;
        }
    })

})