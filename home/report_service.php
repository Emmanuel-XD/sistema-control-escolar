<?php include "../includes/header.php"; ?>


<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-center text-primary">MIS REPORTES DE SERVICIO</h4>
                <br>

                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#rep">
                    <span class="glyphicon glyphicon-plus"></span> Agregar <i class="fa fa-plus"></i> </a></button>
                <button onclick="exportarExcel()" class="btn btn-primary blue">Exportar a Excel <i class="fas fa-download fa-sm text-white-50"></i></button>
            </div>
            <?php include "form_repC.php"; ?>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Nombre</th>
                                <th>Domicilio</th>
                                <th>Servicio</th>
                                <th>Tipo Reporte</th>
                                <th>Observacion</th>
                                <th>Status</th>
                                <th>Fecha Reportada</th>
                                <th>Fecha Registro</th>
                                <th>Acciones.</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            extract($_GET);
                            require_once("../includes/db.php");
                            $result = mysqli_query($conexion, "SELECT r.id, r.id_cliente, r.id_servicio, r.id_falla, r.observacion, 
                            r.estado, r.fecha_reporte, r.fecha_registro, c.nombres, c.apellidos, c.folio, c.domicilio,c.id_user, s.servicio, f.falla 
                            FROM reportes r INNER JOIN clientes c ON r.id_cliente = c.id INNER JOIN servicios s 
                            ON r.id_servicio = s.id INNER JOIN fallas f ON r.id_falla = f.id INNER JOIN users u ON c.id_user = u.id  WHERE c.id_user = '$id'");
                            while ($fila = mysqli_fetch_assoc($result)) :

                            ?>
                                <tr>
                                    <td><?php echo $fila['folio']; ?></td>
                                    <td><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></td>
                                    <td><?php echo $fila['domicilio']; ?></td>
                                    <td><?php echo $fila['servicio']; ?></td>
                                    <td><?php echo $fila['falla']; ?></td>
                                    <td><?php echo $fila['observacion']; ?></td>
                                    <td><?php echo $fila['estado']; ?></td>
                                    <td><?php echo $fila['fecha_reporte']; ?></td>
                                    <td><?php echo $fila['fecha_registro']; ?></td>

                                    <td>

                                        <a href="../includes/eliminar_per.php?id=<?php echo $fila['id'] ?>" class="btn btn-danger btn-del">
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
<script>
    var tabla = document.querySelector("#dataTable");
    var dataTable = new DataTable(tabla);

    function exportarExcel() {
        // Seleccionar la tabla
        var tabla = document.getElementById("dataTable");

        // Convertir la tabla en un archivo de Excel
        var libro = XLSX.utils.table_to_book(tabla);

        // Descargar el archivo
        XLSX.writeFile(libro, "REPORTE_SERVICIO_CLIENTE.xlsx");
    }
</script>

<?php include "../includes/footer.php"; ?>

</html>