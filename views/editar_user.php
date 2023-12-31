<div class="modal fade" id="editar<?php echo $fila['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title" id="exampleModalLabel">Editar Usuario</h3>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">

                <form id="editForms<?php echo $fila['id']; ?>" method="POST">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Usuario</label>
                                <input type="text" id="usuario" name="usuario" class="form-control" value="<?php echo $fila['usuario']; ?>" required>

                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Correo</label>
                                <input type="email" id="correo" name="correo" class="form-control" value="<?php echo $fila['correo']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <!--          <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Password</label><br>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Confirmar Password</label><br>
                                <input type="password" name="password2" id="password2" class="form-control" required>
                            </div>
                        </div>
                    </div>


-->

                    <div class="form-group">
                        <label for="username">Rol de Usuario</label><br>
                        <select name="id_rol" id="id_rol" class="form-control" required>

                            <option <?php echo $fila['id_rol'] === '1' ? "selected='selected' " : "" ?> value="1">Administrador</option>
                            <option <?php echo $fila['id_rol'] === '2' ? "selected='selected' " : "" ?> value="2">Profesor</option>
                            <option <?php echo $fila['id_rol'] === '3' ? "selected='selected' " : "" ?> value="3">Alumno</option>
                        </select>
                    </div>



                    <br>

                    <input type="hidden" name="accion" value="editar_user">
                    <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="editForms(<?php echo $fila['id']; ?>)">Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>

            </div>

            </form>
        </div>
    </div>
</div>
<script>
    function editForms(id) {
        var datosFormulario = $("#editForms" + id).serialize();

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
                            location.assign('usuarios.php');
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