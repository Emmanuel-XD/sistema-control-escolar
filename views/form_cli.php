<div class="modal fade" id="cli" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title" id="exampleModalLabel">Agregar nuevo cliente</h3>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">

                <form id="addForm">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" id="nombres" name="nombres" class="form-control" required>

                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" id="apellidos" name="apellidos" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="edad">Edad</label><br>
                                <input type="number" name="edad" id="edad" min="0" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="telefono">Telefono</label><br>
                                <input type="tel" name="telefono" id="telefono" class="form-control" required>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="correo">Correo</label><br>
                                <input type="email" name="correo" id="correo" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="domicilio">Domicilio</label><br>
                                <input type="text" name="domicilio" id="domicilio" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Servicio</label><br>
                                <select name="id_servicio" id="id_servicio" class="form-control" required>
                                    <option value="">Selecciona una opcion</option>
                                    <?php

                                    include("../includes/db.php");
                                    //Codigo para mostrar categorias desde otra tabla
                                    $sql = "SELECT * FROM servicios ";
                                    $resultado = mysqli_query($conexion, $sql);
                                    while ($consulta = mysqli_fetch_array($resultado)) {
                                        echo '<option value="' . $consulta['id'] . '">' . $consulta['servicio'] . '</option>';
                                    }

                                    ?>


                                </select>

                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Status</label><br>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">Selecciona una opcion</option>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                    <option value="Pendiente">Pendiente</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Usuario Relacionado</label><br>
                        <select name="id_user" id="id_user" class="form-control" required>
                            <option value="">Selecciona una opcion</option>
                            <?php

                            include("../includes/db.php");
                            //Codigo para mostrar categorias desde otra tabla
                            $sql = "SELECT * FROM users WHERE id_rol = 3 ";
                            $resultado = mysqli_query($conexion, $sql);
                            while ($consulta = mysqli_fetch_array($resultado)) {
                                echo '<option value="' . $consulta['id'] . '">' . $consulta['usuario'] . '</option>';
                            }

                            ?>


                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Periodos de pago</label>
                        <input type="text" class="form-control" name="fecha_pago" id="fecha_pago" placeholder="For example: Del 1 al 8 de cada mes..">
                    </div>




                    <input type="hidden" name="accion" value="insert_clie">

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
<script>
    $(document).ready(function() {
        $('#addForm').submit(function(e) {
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
                            window.location = "clientes.php";
                        });
                    } else if (response.status === 'user') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Usuario No Disponible',
                            text: 'El usuario seleccionado ya está registrado como cliente, intente con otro o registre uno nuevo.'
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