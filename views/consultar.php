<?php include "../includes/header.php"; ?>


<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Consultar Calificaciones</h6>
                <br>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Grado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php
                            require_once("../includes/db.php");
                            $result = mysqli_query($conexion, "SELECT * FROM grados ");
                            while ($fila = mysqli_fetch_assoc($result)) :

                            ?>
                                <tr>
                                    <td><?php echo $fila['descripcion']; ?></td>


                                    <td>

                                        <a href="ver_calificacion.php?id=<?php echo $fila['id']; ?>" class="btn btn-primary">
                                            <i class="fa fa-book" aria-hidden="true"></i></a>
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