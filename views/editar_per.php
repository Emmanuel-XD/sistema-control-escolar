<div class="modal fade" id="editar<?php echo $fila['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title" id="exampleModalLabel">Editar Periodo</h3>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">

                <form id="editForm<?php echo $fila['id']; ?>" method="POST">


                    <div class="form-group">
                        <label for="nombre" class="form-label">Descripcion</label>
                        <input type="text" id="periodo" name="periodo" class="form-control" value="<?php echo $fila['periodo']; ?>" required>

                    </div>


                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="date_in">Periodo de Inicio</label><br>
                                <input type="date" name="date_in" id="date_in" class="form-control" value="<?php echo $fila['date_in']; ?>" required>

                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="date_fin">Periodo de Fin</label><br>
                                <input type="date" name="date_fin" id="date_fin" class="form-control" value="<?php echo $fila['date_fin']; ?>" required>
                            </div>
                        </div>
                    </div>


                    <br>

                    <input type="hidden" name="accion" value="editar_per">
                    <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="editForm(<?php echo $fila['id']; ?>)">Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>

            </div>

            </form>
        </div>
    </div>
</div>
<script>
    function editForm(id) {
        var datosFormulario = $("#editForm" + id).serialize();

        $.ajax({
            url: "../includes/functions.php",
            type: "POST",
            data: datosFormulario,
            dataType: "json",
            success: function(response) {
                if (response === "correcto") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Datos Actualizados',
                        html: 'El registro se ha actualizado correctamente, los datos se estan guardando en <b></b> milliseconds.',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                                b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {

                        if (result.dismiss === Swal.DismissReason.timer) {
                            location.assign('periodos.php');
                        }
                    })
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "Ha ocurrido un error al actualizar el registro",
                        icon: "error"
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: "Error",
                    text: "Ha ocurrido un error al comunicarse con el servidor",
                    icon: "error"
                });
            }
        });
    }
</script>