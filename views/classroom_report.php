<?php include "../includes/header.php"; ?>
<style>
    .control {

        /* width: 100%; */
        height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #6e707e;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
</style>

<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Reportes</h6>
                <br>

                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#reporte">
                    <span class="glyphicon glyphicon-plus"></span> Agregar <i class="fa fa-plus"></i>
                </button>

                <a href="../includes/reporte_day.php" target="_blank" class="btn btn-danger ">
                    Reporte HOY <i class="fa fa-file-pdf"></i></a>

                <a href="../includes/reporte_general.php" target="_blank" class="btn btn-danger ">
                    Reporte General <i class="fa fa-file-pdf"></i></a>
                <br>
                <br>

                <form action="../includes/report_aula.php" method="POST" accept-charset="utf-8" id="filtro-form" target="_blank">
                    <div class="row">
                        <select name="id_aula" id="id_aula" class="control" required style="margin-left: 10px;">
                            <option value="0">Selecciona una opcion</option>
                            <?php
                            include("../includes/db.php");
                            $sql = "SELECT * FROM aulas ";
                            $resultado = mysqli_query($conexion, $sql);
                            while ($consulta = mysqli_fetch_array($resultado)) {
                                echo '<option value="' . $consulta['id'] . '">' . $consulta['aula'] . '</option>';
                            }
                            ?>
                        </select>

                        <button type="submit" class="btn btn-primary" name="generar" id="generar" style="margin-left: 10px;">
                            Generar <i class="fa fa-file-pdf"></i>
                        </button>

                    </div>
                </form>

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
                                <th>Acciones.</th>
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

    <script>
        $(document).ready(function() {
            $('#id_aula').change(function() {
                var idAula = $(this).val();
                buscarMaquina(idAula);
            });
            $('#generar').click(function(event) {
                var idAula = $('#id_aula').val();

                if (idAula === '0') {
                    Swal.fire({
                        title: 'Aula Invalida',
                        text: 'Por favor, seleccione una aula antes de generar el reporte pdf.',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar'
                    });
                    event.preventDefault();
                }
            });

            function buscarMaquina(idAula) {
                $.ajax({
                    url: 'obtener_aula.php',
                    method: 'POST',
                    data: {
                        id_aula: idAula
                    },
                    success: function(data) {

                        $('#dataTable tbody').html(data);
                    },
                    error: function() {
                        alert('Error al cargar los registros de la máquina.');
                    }
                });
            }
        });
    </script>


</body>


<?php include "../includes/footer.php"; ?>

</html>