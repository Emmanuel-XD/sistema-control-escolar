<div class="modal fade" id="reporte" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title" id="exampleModalLabel">Agregar Reporte De Aula</h3>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">

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
                                    <?php

                                    include("db.php");

                                    $sql = "SELECT * FROM profesores WHERE correo = '$usuario' ";
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
                                    <option value="">Selecciona una opcion</option>
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
                                <input type="time" name="hor_ini" id="hor_ini" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Numero de Alumno</label><br>
                                <input type="number" step="0" min="1" name="num_alum" id="num_alum" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Sillas Disponibles</label><br>
                                <input type="number" step="0" min="1" name="sillas_disp" id="sillas_disp" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Estado de Sillas, Mesas,Etc</label><br>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">Selecciona una opcion</option>
                                    <option value="Sucias">Sucias</option>
                                    <option value="Buen estado">Buen estado</option>
                                    <option value="Mal estado">Mal estado</option>
                                    <option value="Incompletas">Incompletas</option>
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
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Material Completo</label><br>
                                <select name="material" id="material" class="form-control" required>
                                    <option value="">Selecciona una opcion</option>
                                    <option value="Completo">Completo</option>
                                    <option value="Incompleto">Incompleto</option>
                                    <option value="Mal Estado">Mal Estado</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Hora de Salida</label><br>
                                <input type="time" class="form-control" id="hor_fin" name="hor_fin">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Observaciones</label><br>
                        <input type="text" name="observacion" id="observacion" placeholder="Ejemplo: Problemas tecnicos,etc..." class="form-control" required>
                    </div>


                    <br>
                    <input type="hidden" name="accion" value="insert_report">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="register" name="registrar">Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>

            </div>

            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#reportForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '../includes/functions.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Datos Guardados',
                            text: 'Los datos se guardaron correctamente'
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error inesperado'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error inesperado'
                    });
                }
            });
        });
    });
</script>