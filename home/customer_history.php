<?php include "../includes/header.php"; ?>


<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-center text-primary">MI HISTORIAL DE PAGOS</h4>
                <br>
                <button onclick="exportarExcel()" class="btn btn-primary blue">Exportar a Excel <i class="fas fa-download fa-sm text-white-50"></i></button>
            </div>


            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Cliente</th>
                                <th>Servicio</th>
                                <th>Total</th>
                                <th>Fecha_registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            extract($_GET);
                            require_once("../includes/db.php");
                            $result = mysqli_query($conexion, "SELECT p.id, p.id_cliente, p.id_servicio, p.pago, p.fecha, 
                            c.folio, c.nombres, c.apellidos, c.telefono, c.correo, c.domicilio, c.fecha_pago,c.id_user, s.servicio 
                            FROM pagos p INNER JOIN clientes c ON p.id_cliente = c.id INNER JOIN servicios s 
                            ON p.id_servicio = s.id INNER JOIN users u ON c.id_user = u.id  WHERE c.id_user = '$id'");
                            while ($fila = mysqli_fetch_assoc($result)) :

                            ?>
                                <tr>
                                    <td><?php echo $fila['folio']; ?></td>
                                    <td><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></td>
                                    <td><?php echo $fila['servicio']; ?></td>
                                    <td><?php echo '$' . $fila['pago']; ?></td>
                                    <td><?php echo $fila['fecha']; ?></td>

                                    <td>

                                        <a href="../includes/recibo.php?id=<?php echo $fila['id'] ?>" target="_blank" class="btn btn-outline-danger">
                                            <i class="fa fa-file "></i></a>


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
        XLSX.writeFile(libro, "REPORTE_HISTORIAL_CLIENTE.xlsx");
    }
</script>


<?php include "../includes/footer.php"; ?>

</html>