<?php include "../includes/header.php"; ?>


<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Reportes</h6>
                <br>

                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#reporte">
                    <span class="glyphicon glyphicon-plus"></span> Agregar <i class="fa fa-plus"></i> </a></button>
            </div>
            <?php include "form_report.php"; ?>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Profesor</th>
                                <th>Aula</th>
                                <th>Hora Inicio</th>
                                <th>Num Alumnos</th>
                                <th>Sillas Disp.</th>´
                                <th>Estado Silla,Etc</th>
                                <th>Estado Aula</th>
                                <th>Mat Compl.</th>
                                <th>Hora Salida</th>
                                <th>Observacion</th>
                                <th>Fecha_registro</th>
                                <th>Acciones.</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            require_once("../includes/db.php");
                            $result = mysqli_query($conexion, "SELECT c.id,c.id_profesor,c.id_aula,c.hor_ini,c.num_alum,
                            c.sillas_disp,c.status,c.aula_limpia,c.material,c.hor_fin,c.observacion,c.fecha,c.fecha2, 
                            p.nombres, p.apellidos, a.aula FROM classroom_report c INNER JOIN profesores p 
                            ON c.id_profesor = p.id INNER JOIN aulas a ON c.id_aula = a.id");
                            while ($fila = mysqli_fetch_assoc($result)) :

                            ?>
                                <tr>
                                    <td><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></td>
                                    <td><?php echo $fila['aula']; ?></td>
                                    <td><?php echo $fila['hor_ini']; ?></td>
                                    <td><?php echo $fila['num_alum']; ?></td>
                                    <td><?php echo $fila['sillas_disp']; ?></td>
                                    <td><?php echo $fila['status']; ?></td>
                                    <td><?php echo $fila['aula_limpia']; ?></td>
                                    <td><?php echo $fila['material']; ?></td>
                                    <td><?php echo $fila['hor_fin']; ?></td>
                                    <td><?php echo $fila['observacion']; ?></td>
                                    <td><?php echo $fila['fecha2']; ?></td>

                                    <td>
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editar<?php echo $fila['id']; ?>">
                                            <i class="fa fa-edit "></i>
                                        </button>
                                        <a href="../includes/eliminar_report.php?id=<?php echo $fila['id'] ?>" class="btn btn-danger btn-del">
                                            <i class="fa fa-trash "></i></a>
                                    </td>
                                </tr>
                                <?php include "editar_report.php"; ?>
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