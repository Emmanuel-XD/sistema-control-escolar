<div class="modal fade" id="editar<?php echo $fila['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title" id="exampleModalLabel">Editar Prestamo</h3>

            </div>
            <div class="modal-body">
                <form id="editForm<?php echo $fila['id']; ?>" method="POST">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="start_datetime" class="control-label">Fecha Solicitada</label>
                                <input type="date" class="form-control" name="fecha_slt" id="fecha_slt" value="<?php echo $fila['fecha_slt']; ?>" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="start_datetime" class="control-label">Fecha De Devolucion</label>
                                <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo $fila['fecha_fin']; ?>" required>
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="start_datetime" class="control-label">Hora De Inicio</label>
                                <input type="time" class="form-control" name="hora_in" id="hora_in" value="<?php echo $fila['hora_in']; ?>" required>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="start_datetime" class="control-label">Hora De Regreso</label>
                                <input type="time" class="form-control" name="hora_fin" id="hora_fin" value="<?php echo $fila['hora_fin']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="start_datetime" class="control-label">Personal Solicita:</label>
                                <select class="form-control" id="id_profesor" name="id_profesor">
                                    <option <?php echo $fila['id_profesor'] === 'id_profesor' ? 'selected' : ''; ?> value="<?php echo $fila['id_profesor']; ?>"><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></option>
                                    <?php

                                    include("../includes/db.php");
                                    //Codigo para mostrar categorias desde otra tabla
                                    $sql = "SELECT * FROM profesores ";
                                    $resultado = mysqli_query($conexion, $sql);
                                    while ($consulta = mysqli_fetch_array($resultado)) {
                                        echo '<option value="' . $consulta['id'] . '">' . $consulta['nombres'] . ' ' . $consulta['apellidos'] . '</option>';
                                    }

                                    ?>


                                </select>
                            </div>
                        </div>



                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="start_datetime" class="control-label">Materia Asignada</label>
                                <select class="form-control" id="id_materia" name="id_materia">
                                    <option <?php echo $fila['id_materia'] === 'id_materia' ? 'selected' : ''; ?> value="<?php echo $fila['id_materia']; ?>"><?php echo $fila['materia']; ?></option>
                                    <?php

                                    include("../includes/db.php");
                                    //Codigo para mostrar categorias desde otra tabla
                                    $sql = "SELECT * FROM materias ";
                                    $resultado = mysqli_query($conexion, $sql);
                                    while ($consulta = mysqli_fetch_array($resultado)) {
                                        echo '<option value="' . $consulta['id'] . '">' . $consulta['materia'] . '</option>';
                                    }

                                    ?>


                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="start_datetime" class="control-label">Cantidad a Prestar</label>
                                <input type="number" name="cant" id="cant" class="form-control" value="<?php echo $fila['cant']; ?>">
                            </div>
                        </div>



                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="start_datetime" class="control-label">Estado De Solicitud</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option <?php echo $fila['status'] === 'Solicitar' ? "selected='selected' " : "" ?> value="Solicitar">Solicitar</option>

                                    <?php if ($_SESSION["type"] == 1) { ?>

                                        <option <?php echo $fila['status'] === 'Aprobado' ? "selected='selected' " : "" ?> value="Aprobado">Aprobado</option>
                                        <option <?php echo $fila['status'] === 'Pendiente' ? "selected='selected' " : "" ?> value="Pendiente">Pendiente</option>
                                        <option <?php echo $fila['status'] === 'Rechazado' ? "selected='selected' " : "" ?> value="Rechazado">Rechazado</option>
                                        <option <?php echo $fila['status'] === 'Agotado' ? "selected='selected' " : "" ?> value="Agotado">Agotado</option>
                                        <option <?php echo $fila['status'] === 'Devuelto' ? "selected='selected' " : "" ?> value="Devuelto">Devuelto</option>
                                        <option <?php echo $fila['status'] === 'No Devuelto' ? "selected='selected' " : "" ?> value="No Devuelto">No Devuelto</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="start_datetime" class="control-label">Material Solicitado</label>
                        <select class="form-control" id="id_material" name="id_material">
                            <option <?php echo $fila['id_material'] === 'id_material' ? 'selected' : ''; ?> value="<?php echo $fila['id_material']; ?>"><?php echo $fila['descripcion']; ?></option>
                            <?php

                            include("../includes/db.php");
                            //Codigo para mostrar categorias desde otra tabla
                            $sql = "SELECT * FROM inventario ";
                            $resultado = mysqli_query($conexion, $sql);
                            while ($consulta = mysqli_fetch_array($resultado)) {
                                echo '<option value="' . $consulta['id'] . '">' . $consulta['descripcion'] . '</option>';
                            }

                            ?>


                        </select>
                    </div>

                    <input type="hidden" name="accion" value="editar_prest">
                    <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="editForm(<?php echo $fila['id']; ?>)">Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
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
                            location.assign('prestamos.php');
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