<div class="modal fade" id="editar<?php echo $fila['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title" id="exampleModalLabel">Editar Material</h3>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">

                <form id="editForm<?php echo $fila['id']; ?>" method="POST">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Codigo</label>
                                <input type="text" name="codigo" id="codigo" class="form-control" value="<?php echo $fila['codigo']; ?>" required>

                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Material</label><br>
                                <input type="text" name="descripcion" id="descripcion" class="form-control" value="<?php echo $fila['descripcion']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Cantidad</label><br>
                                <input type="number" name="cantidad" id="cantidad" class="form-control" value="<?php echo $fila['cantidad']; ?>" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="">Existencia</label>
                                <input type="number" name="existencia" id="existencia" class="form-control" value="<?php echo $fila['existencia']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Unidad</label><br>
                                <select name="unidad" id="unidad" class="form-control">

                                    <option <?php echo $fila['unidad'] === 'UND' ? "selected='selected' " : "" ?> value="UND">UND</option>
                                    <option <?php echo $fila['unidad'] === 'PAQUETES' ? "selected='selected' " : "" ?> value="PAQUETES">PAQUETES</option>
                                    <option <?php echo $fila['unidad'] === 'PZA' ? "selected='selected' " : "" ?> value="PZA">PZA</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password">Personal Responsable</label><br>
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
                                <label for="password">Categoria</label><br>
                                <select name="id_categoria" id="id_categoria" class="form-control" required>
                                    <option <?php echo $fila['id_categoria'] === 'id_categoria' ? 'selected' : ''; ?> value="<?php echo $fila['id_categoria']; ?>"><?php echo $fila['id_categoria']; ?></option>
                                    <?php

                                    include("db.php");

                                    $sql = "SELECT * FROM categorias ";
                                    $resultado = mysqli_query($conexion, $sql);
                                    while ($consulta = mysqli_fetch_array($resultado)) {
                                        echo '<option value="' . $consulta['id'] . '">' . $consulta['categoria'] . '</option>';
                                    }

                                    ?>
                                </select>

                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                            <label for="password">Status</label><br>
                                <select name="status" id="status" class="form-control">

                                    <option <?php echo $fila['status'] === 'Disponible' ? "selected='selected' " : "" ?> value="Disponible">Disponible</option>
                                    <option <?php echo $fila['status'] === 'No Disponible' ? "selected='selected' " : "" ?> value="No Disponible">No Disponible</option>
                                    <option <?php echo $fila['status'] === 'Prestados' ? "selected='selected' " : "" ?> value="Prestados">Prestados</option>

                                </select>
                            </div>
                        </div>
                    </div>


                    <br>

                    <input type="hidden" name="accion" value="editar_inv">
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
                        location.assign('inventario.php');
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