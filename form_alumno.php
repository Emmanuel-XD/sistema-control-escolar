<div class="modal fade" id="alumno" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title" id="exampleModalLabel">Agregar nuevo alumno</h3>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">

                <form id="alumForm">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>

                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Apellidos</label><br>
                                <input type="text" name="apellido" id="apellido" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Correo</label><br>
                                <input type="email" name="correo" id="correo" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Telefono</label><br>
                                <input type="tel" name="telefono" id="telefono" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Curp</label><br>
                                <input type="text" name="curp" id="curp" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Edad</label><br>
                                <input type="number" name="edad" id="edad" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Fecha de Nacimiento</label><br>
                                <input type="date" name="birthdate" id="birthdate" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Grado</label><br>
                                <select name="id_grado" id="id_grado" class="form-control" required>
                                    <option value="">Selecciona una opcion</option>
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
                    <input type="hidden" name="accion" value="insert_alumno">
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
        $('#alumForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '../includes/functions.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Éxito: Los datos se guardaron correctamente');
                        window.location = "alumnos.php";
                    } else {
                        alert('Error: Ocurrió un error inesperado');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error: Ocurrió un error inesperado');
                }
            });
        });
    });
</script>