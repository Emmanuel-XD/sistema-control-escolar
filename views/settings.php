<?php

include "../includes/header.php";
include "../includes/db.php";
$id = $_GET['id'];
$consulta = "SELECT * FROM settings WHERE id = $id";
$resultado = mysqli_query($conexion, $consulta);
$filas = mysqli_fetch_assoc($resultado);
?>


<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary text-center">CONFIGURACION GENERAL</h4>
                <br>

            </div>

            <div class="card-body">
                <form id="editForm<?php echo $filas['id']; ?>" method="POST">

                    <div class="form-group">
                        <label for="">Nombre del Sistema</label>
                        <input type="text" class="form-control" value="SISTEMA DE CONTROL ESCOLAR" readonly>
                    </div>

                    <div class="form-group">
                        <label for="">Nombre de la Institucion</label>
                        <input type="text" class="form-control" id="instituto" name="instituto" value="<?php echo $filas['instituto']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="">Direccion</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $filas['direccion']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="">Clave</label>
                        <input type="text" class="form-control" id="clave" name="clave" value="<?php echo $filas['clave']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="">Color de barra lateral </label>
                        <select name="tema" id="tema" class="form-control">


                            <option <?php echo $filas['tema'] === 'primary' ? "selected='selected' " : "" ?> value="primary">Azul</option>
                            <option <?php echo $filas['tema'] === 'secondary' ? "selected='selected' " : "" ?> value="secondary">Gris</option>
                            <option <?php echo $filas['tema'] === 'dark' ? "selected='selected' " : "" ?> value="dark">Gris Oscuro</option>
                            <option <?php echo $filas['tema'] === 'success' ? "selected='selected' " : "" ?> value="success">Verde</option>
                            <option <?php echo $filas['tema'] === 'danger' ? "selected='selected' " : "" ?> value="danger">Naranja</option>
                            <option <?php echo $filas['tema'] === 'warning' ? "selected='selected' " : "" ?> value="warning">Amarillo</option>
                            <option <?php echo $filas['tema'] === 'info' ? "selected='selected' " : "" ?> value="info">Azul Bajo</option>
                            <option <?php echo $filas['tema'] === 'light' ? "selected='selected' " : "" ?> value="light">Claro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Modalidad</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="4">
                            <label class="form-check-label" for="exampleRadios1">
                                Cuatrimestre
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="6">
                            <label class="form-check-label" for="exampleRadios2">
                                Semestre
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="12">
                            <label class="form-check-label" for="exampleRadios2">
                                Año Completo
                            </label>
                        </div>
                    </div>
                    <br>
                    <input type="hidden" name="accion" value="editar_datos">
                    <input type="hidden" name="id" value="<?php echo $filas['id']; ?>">
                    <center>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" onclick="editForm(<?php echo $filas['id']; ?>)">Guardar</button>
                        </div>
                    </center>
            </div>

            </form>

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
                            title: 'Datos Guardados',
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
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                location.assign('index.php');
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

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->




</body>


<?php include "../includes/footer.php"; ?>

</html>