<?php include "../includes/header.php"; ?>


<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Calificaciones</h6>
                <br>


            </div>


            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Grado & Grupo</th>
                                <th>Alumno</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            extract($_GET);
                            $id_grado = $_GET['id'];
                            require_once("../includes/db.php");
                            $result = mysqli_query($conexion, "SELECT a.id, a.matricula, a.nombre, a.apellido, a.correo,
                            a.telefono, a.curp, a.edad, a.birthdate, a.beca, a.id_grado, a.id_grupo, a.fecha, g.descripcion, gru.grupo
                            FROM alumnos a INNER JOIN grados g ON a.id_grado = g.id INNER JOIN grupos gru ON a.id_grupo = gru.id
                            WHERE a.id_grado = '$id_grado' ");
                            while ($fila = mysqli_fetch_assoc($result)) :

                            ?>
                                <tr>
                                    <td><?php echo $fila['descripcion'] . ' ' . $fila['grupo']; ?></td>
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