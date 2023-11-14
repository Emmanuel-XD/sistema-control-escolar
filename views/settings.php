<?php

include "../includes/header.php";
//include "../includes/db.php";
$id = $_GET['id'];
$consulta = "SELECT * FROM settings WHERE id = $id";
$resultado = mysqli_query($conexion, $consulta);
if ($resultado->num_rows > 0) {
    foreach ($resultado as $key => $filas) {
        $ruta_imagen = $filas["imagen"];

?>

<?php
    }
}
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
                <form id="form" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="">Nombre del Sistema</label>
                        <input type="text" class="form-control" value="SISTEMA DE CONTROL ESCOLAR" readonly>
                    </div>

                    <div class="form-group">
                        <label for="">Nombre de la Institucion</label>
                        <input name="instituto" type="text" data-id="<?php echo $filas['id']; ?>" class="form-control" id="instituto" value="<?php echo $filas['instituto']; ?>">
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
                        <label for="logoImg" class="col-md-4 col-lg-3 col-form-label">Logo de Institucion</label>
                        <div class="col-md-8 col-lg-9">
                            <img src="../includes/<?php echo $ruta_imagen; ?>" width="100px" alt="logo">
                            <div class="pt-2">
                                <input type="file" class="form-control" name="imagen" id="imagen">
                            </div>
                        </div>


                    </div>




            </div>
            <br>

            <center>
                <div class="form-group">
                    <button type="button" id="submitedit" class="btn btn-primary">Guardar</button>
                </div>
            </center>
        </div>

        </form>

    </div>
    </div>

    <script>
        $("#submitedit").click(function(e) {
            e.preventDefault();

            var datos = new FormData();
            datos.append('accion', 'editar_datos');
            datos.append('id', $("#instituto").data("id"));
            datos.append('instituto', $("#instituto").val());
            datos.append('direccion', $("#direccion").val());
            datos.append('clave', $("#clave").val());
            datos.append('tema', $("#tema").val());
            datos.append('imagen', $("#imagen")[0].files[0]);

            fetch('../includes/functions.php', {
                    method: 'POST',
                    body: datos
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la solicitud: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(response => {
                    confirmation(response);
                })
                .catch(error => {
                    console.error(error);

                });
        });

        function confirmation(r) {
            if (r) {
                if (r === "updated") {
                    let timerInterval;
                    Swal.fire({
                        title: 'Datos Guardados',
                        html: 'La informacion esta siendo guardada en la base de datos en <b></b> segundos...',
                        timer: 3000,
                        icon: 'success',
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                            const b = Swal.getHtmlContainer().querySelector('b');
                            timerInterval = setInterval(() => {
                                b.textContent = Swal.getTimerLeft();
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {

                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log('I was closed by the timer');
                        }
                    });
                    setTimeout(function() {
                        url = "index.php";
                        $(location).attr('href', url);
                    }, 3000);
                }
            }
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