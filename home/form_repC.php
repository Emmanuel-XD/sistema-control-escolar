<div class="modal fade" id="rep" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title" id="exampleModalLabel">Agregar nuevo reporte</h3>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">

                <form id="addForm">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="">Cliente</label>
                                <select class="form-control" id="id_cliente" name="id_cliente" required>

                                    <?php

                                    include("../includes/db.php");
                                    //Codigo para mostrar categorias desde otra tabla
                                    $sql = "SELECT * FROM clientes WHERE id_user = '$id' ";
                                    $resultado = mysqli_query($conexion, $sql);
                                    while ($consulta = mysqli_fetch_array($resultado)) {
                                        echo '<option value="' . $consulta['id'] . '">' . $consulta['nombres'] . ' ' . $consulta['apellidos'] . '</option>';
                                    }

                                    ?>
                                </select>

                            </div>
                        </div>


                        <div class="col-sm-6" id="select2lista">
                            <div class="mb-3">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="">Tipo de Reporte</label>
                                <select class="form-control" id="id_falla" name="id_falla" required>
                                    <option value="">Selecciona una opcion..</option>
                                    <?php

                                    include("../includes/db.php");
                                    //Codigo para mostrar categorias desde otra tabla
                                    $sql = "SELECT * FROM fallas ";
                                    $resultado = mysqli_query($conexion, $sql);
                                    while ($consulta = mysqli_fetch_array($resultado)) {
                                        echo '<option value="' . $consulta['id'] . '">' . $consulta['falla'] . '</option>';
                                    }

                                    ?>
                                </select>

                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Status</label><br>
                                <select name="estado" id="estado" class="form-control" required>

                                    <option value="Pendiente">Pendiente</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Fecha Solicitada</label>
                        <input type="date" class="form-control" name="fecha_reporte" id="fecha_reporte">
                    </div>


                    <div class="form-group">
                        <label for="">Observaciones</label>
                        <input type="text" class="form-control" name="observacion" id="observacion">
                    </div>




                    <input type="hidden" name="accion" value="insert_report">

                    <br>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="register" name="registrar">Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>

            </div>

            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#id_cliente').val(1);
        recargarLista();

        $('#id_cliente').change(function() {
            recargarLista();
        });
    })
</script>
<script type="text/javascript">
    function recargarLista() {
        $.ajax({
            type: "POST",
            url: "../includes/obtener_servicio.php",
            data: "id_servicio=" + $('#id_cliente').val(),
            success: function(r) {
                $('#select2lista').html(r);
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#addForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            formData += '&id_servicio=' + $('#id_servicio').val();

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
                            text: 'El reporte fue enviado para su revision'
                        }).then(function() {
                            window.location = "consultar.php";
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