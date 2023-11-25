<?php include "../includes/header.php";
date_default_timezone_set('America/Mexico_City');
$fecha_actual = date('Y-m-d'); ?>


<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-center text-primary">REPORTES DE AULA <?php echo  $fecha_actual; ?></h4>
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
                                <th>Materia</th>
                                <th>Grado & Grupo</th>
                                <th>Aula</th>
                                <th>Hora Inicio</th>
                                <th>Num Alumnos</th>
                                <th>Sillas Disp.</th>
                                <th>Estado Mater.</th>
                                <th>Estado Aula</th>
                                <th>Mat Compl.</th>
                                <th>Hora Salida</th>
                                <th>Fecha</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            require_once("../includes/db.php");
                            $result = mysqli_query($conexion, "SELECT c.id,c.id_profesor, c.id_materia, c.id_grado, c.id_grupo, c.id_aula,c.hor_ini,c.num_alum,
                            c.sillas_disp,c.status,c.aula_limpia,c.material,c.hor_fin, c.fecha,c.fecha2, 
                            p.nombres, p.apellidos, a.aula, m.materia, g.descripcion, gr.grupo FROM classroom_report c INNER JOIN profesores p 
                            ON c.id_profesor = p.id INNER JOIN aulas a ON c.id_aula = a.id INNER JOIN materias m ON c.id_materia = m.id
                            INNER JOIN grados g ON c.id_grado = g.id INNER JOIN grupos gr ON c.id_grupo = gr.id");
                            while ($fila = mysqli_fetch_assoc($result)) :

                            ?>
                                <tr>
                                    <td><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></td>
                                    <td><?php echo $fila['materia']; ?></td>
                                    <td><?php echo $fila['descripcion'] . ' ' . $fila['grupo']; ?></td>
                                    <td><?php echo $fila['aula']; ?></td>
                                    <td><?php echo $fila['hor_ini']; ?></td>
                                    <td><?php echo $fila['num_alum']; ?></td>
                                    <td><?php echo $fila['sillas_disp']; ?></td>
                                    <td><?php echo $fila['status']; ?></td>
                                    <td><?php echo $fila['aula_limpia']; ?></td>
                                    <td><?php echo $fila['material']; ?></td>
                                    <td><?php echo $fila['hor_fin']; ?></td>
                                    <td><?php echo $fila['fecha2']; ?></td>


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