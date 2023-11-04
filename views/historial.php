<?php include "../includes/header.php"; ?>


<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Historial de Pagos</h6>
                <br>


                <a href="pagos.php" class="btn btn-success">Nuevo Pago <i class="fa fa-plus"></i></a>
            </div>


            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Alumno</th>
                                <th>Grado</th>
                                <th>Tipo Cargo</th>
                                <th>Beca %</th>
                                <th>Total</th>
                                <th>Fecha_registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            require_once("../includes/db.php");
                            $result = mysqli_query($conexion, "SELECT p.id, p.total, p.pago, p.fecha,p.beca, a.matricula, a.nombre, a.apellido, g.descripcion, c.cargo, c.monto
                            FROM pagos p INNER JOIN alumnos a ON p.id_alumno = a.id INNER JOIN grados g ON p.id_grado = g.id INNER JOIN cargos c 
                            ON p.id_cargo = c.id");
                            while ($fila = mysqli_fetch_assoc($result)) :

                            ?>
                                <tr>
                                    <td><?php echo $fila['nombre'] . ' ' . $fila['apellido']; ?></td>
                                    <td><?php echo $fila['descripcion']; ?></td>
                                    <td><?php echo $fila['cargo']; ?></td>
                                    <td><?php echo $fila['beca'] . '%'; ?></td>
                                    <td><?php echo '$' . $fila['pago']; ?></td>

                                    <td><?php echo $fila['fecha']; ?></td>

                                    <td>

                                        <a href="../includes/recibo.php?id=<?php echo $fila['id'] ?>" target="_blank" class="btn btn-outline-danger">
                                            <i class="fa fa-file "></i></a>

                                        <a href="../includes/eliminar_pago.php?id=<?php echo $fila['id'] ?>" class="btn btn-danger btn-del">
                                            <i class="fa fa-trash "></i></a>
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