<?php include "../includes/header.php"; ?>


<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Calificaciones</h6>
                <br>

                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#grado">
                    <span class="glyphicon glyphicon-plus"></span> Agregar <i class="fa fa-plus"></i> </a></button>
            </div>


            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Alumno</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            extract($_GET);
                            $id_grado = $_GET['id'];
                            require_once("../includes/db.php");
                            $result = mysqli_query($conexion, "SELECT * FROM alumnos WHERE id_grado = '$id_grado' ");
                            while ($fila = mysqli_fetch_assoc($result)) :

                            ?>
                                <tr>
                                    <td><?php echo $fila['nombre'] . ' ' . $fila['apellido']; ?></td>

                                    <td>

                                        <a href="calificar.php?id=<?php echo $fila['id'] ?>" class="btn btn-success">
                                            <i class="fa fa-check-circle"></i>
                                    </td>
                                </tr>

                            <?php endwhile; ?>
                        </tbody>
                    </table>




                </div>
            </div>
        </div>

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