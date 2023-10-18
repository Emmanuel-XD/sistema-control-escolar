<div class="modal fade" id="editar<?php echo $fila['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title" id="exampleModalLabel">Editar Materia</h3>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">

                <form id="editForm<?php echo $fila['id']; ?>" method="POST">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Descripcion</label>
                                <input type="text" id="materia" name="materia" class="form-control" value="<?php echo $fila['materia']; ?>" required>

                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Profesor Asignado</label>
                                <select name="id_profesor" id="id_profesor" class="form-control">
                                    <option <?php echo $fila['id_profesor'] === 'id_profesor' ? 'selected' : ''; ?> value="<?php echo $fila['id_profesor']; ?>"><?php echo $fila['id_profesor']; ?></option>
                                    <?php

                                    include("db.php");

                                    $sql = "SELECT * FROM profesores ";
                                    $resultado = mysqli_query($conexion, $sql);
                                    while ($consulta = mysqli_fetch_array($resultado)) {
                                        echo '<option value="' . $consulta['id'] . '">' . $consulta['nombres'] . ' ' . $consulta['apellidos'] . '</option>';
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Periodo</label>
                                <select name="id_periodo" id="id_periodo" class="form-control">
                                    <option <?php echo $fila['id_periodo'] === 'id_periodo' ? 'selected' : ''; ?> value="<?php echo $fila['id_periodo']; ?>"><?php echo $fila['id_periodo']; ?></option>
                                    <?php

                                    include("db.php");

                                    $sql = "SELECT * FROM periodos ";
                                    $resultado = mysqli_query($conexion, $sql);
                                    while ($consulta = mysqli_fetch_array($resultado)) {
                                        echo '<option value="' . $consulta['id'] . '">' . $consulta['periodo'] . ' ( ' . $consulta['date_in'] . ' - ' . $consulta['date_fin'] . ')</option>';
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="username">Grado Asignado</label><br>
                                <select name="id_grado" id="id_grado" class="form-control" required>
                                    <option <?php echo $fila['id_grado'] === 'id_grado' ? 'selected' : ''; ?> value="<?php echo $fila['id_grado']; ?>"><?php echo $fila['id_grado']; ?></option>
                                    <?php

                                    include("db.php");

                                    $sql = "SELECT * FROM grados ";
                                    $resultado = mysqli_query($conexion, $sql);
                                    while ($consulta = mysqli_fetch_array($resultado)) {
                                        echo '<option value="' . $consulta['id'] . '">' . $consulta['descripcion'] . '</option>';
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>



                    <br>

                    <input type="hidden" name="accion" value="editar_mat">
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
                    alert("El registro se ha actualizado correctamente");
                    setTimeout(function() {
                        location.assign('materias.php');
                    }, 2000);
                } else {
                    alert("Ha ocurrido un error al actualizar el registro");
                }
            },
            error: function() {
                alert("Error de comunicacion con el servidor");
            }
        });
    }
</script>