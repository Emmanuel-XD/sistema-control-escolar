<div class="modal fade" id="editar<?php echo $fila['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title" id="exampleModalLabel">Editar Reporte</h3>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">


                <form id="editForm<?php echo $fila['id']; ?>" method="POST">

                    <form id="reportForm">
                        <?php
                        date_default_timezone_set('America/Mexico_City');
                        $fecha_actual = date('Y-m-d');
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Fecha Registro</label>
                                    <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo $fecha_actual ?>" readonly required>

                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="password">Profesor</label>
                                    <select name="id_profesor" id="id_profesor" class="form-control" required>
                                        <option <?php echo $fila['id_profesor'] === 'id_profesor' ? 'selected' : ''; ?> value="<?php echo $fila['id_profesor']; ?>"><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></option>
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
                                    <label for="nombre" class="form-label">Aula</label>
                                    <select name="id_aula" id="id_aula" class="form-control" required>
                                        <option <?php echo $fila['id_aula'] === 'id_aula' ? 'selected' : ''; ?> value="<?php echo $fila['id_aula']; ?>"><?php echo $fila['aula']; ?></option>
                                        <?php

                                        include("db.php");

                                        $sql = "SELECT * FROM aulas ";
                                        $resultado = mysqli_query($conexion, $sql);
                                        while ($consulta = mysqli_fetch_array($resultado)) {
                                            echo '<option value="' . $consulta['id'] . '">' . $consulta['aula'] . ' - ' . $consulta['estado'] . '</option>';
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="password">Hora de Entrada</label><br>
                                    <input type="time" name="hor_ini" id="hor_ini" class="form-control" value="<?php echo $fila['hor_ini']; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="password">Numero de Alumno</label><br>
                                    <input type="number" step="0" min="1" name="num_alum" id="num_alum" class="form-control" value="<?php echo $fila['num_alum']; ?>" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="password">Sillas Disponibles</label><br>
                                    <input type="number" step="0" min="1" name="sillas_disp" id="sillas_disp" class="form-control" value="<?php echo $fila['sillas_disp']; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="password">Estado de Sillas, Mesas,Etc</label><br>
                                    <select name="status" id="status" class="form-control" required>

                                        <option <?php echo $fila['status'] === 'Sucias' ? "selected='selected' " : "" ?> value="Sucias">Sucias</option>
                                        <option <?php echo $fila['status'] === 'Buen estado' ? "selected='selected' " : "" ?> value="Buen estado">Buen estado</option>
                                        <option <?php echo $fila['status'] === 'Mal estado' ? "selected='selected' " : "" ?> value="Mal estado">Mal estado</option>
                                        <option <?php echo $fila['status'] === 'Incompletas' ? "selected='selected' " : "" ?> value="Incompletas">Incompletas</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="password">Aula Limpia/Sucia</label><br>
                                    <select name="aula_limpia" id="aula_limpia" class="form-control" required>
                                        <option value="">Selecciona una opcion</option>
                                        <option value="Limpia">Limpia</option>
                                        <option value="Sucia">Sucia</option>

                                        <option <?php echo $fila['aula_limpia'] === 'Limpia' ? "selected='selected' " : "" ?> value="Limpia">Limpia</option>
                                        <option <?php echo $fila['aula_limpia'] === 'Sucia' ? "selected='selected' " : "" ?> value="Sucia">Sucia</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="password">Material Completo</label><br>
                                    <select name="material" id="material" class="form-control" required>

                                        <option <?php echo $fila['material'] === 'Completo' ? "selected='selected' " : "" ?> value="Completo">Completo</option>
                                        <option <?php echo $fila['material'] === 'Incompleto' ? "selected='selected' " : "" ?> value="Incompleto">Incompleto</option>
                                        <option <?php echo $fila['material'] === 'Mal Estado' ? "selected='selected' " : "" ?> value="Mal Estado">Mal Estado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="password">Hora de Salida</label><br>
                                    <input type="time" class="form-control" id="hor_fin" name="hor_fin" value="<?php echo $fila['hor_fin']; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Observaciones</label><br>
                            <input type="text" name="observacion" id="observacion" placeholder="Ejemplo: Problemas tecnicos,etc..." class="form-control" value="<?php echo $fila['observacion']; ?>" required>
                        </div>




                        <br>
                        <input type="hidden" name="accion" value="editar_report">
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
                            location.reload();
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