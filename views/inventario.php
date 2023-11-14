<?php
error_reporting(0);
session_start();

?>



<?php include "../includes/header.php"; ?>
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Materiales</h6>
                <br>
                <?php if ($_SESSION["type"] == 1) { ?>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#inv">
                        <span class="glyphicon glyphicon-plus"></span> Agregar <i class="fa fa-plus"></i> </a></button>
                    <!-- Agrega un botón para iniciar la exportación -->
                    <button onclick="exportarExcel()" class="btn btn-primary blue">Exportar a Excel <i class="fas fa-download fa-sm text-white-50"></i></button>
                    <!--  <a href="../includes/pdf.php" class="btn btn-outline-danger" target="_blank">Imprimir <i class="fa fa-file" aria-hidden="true"></i></a>
                 -->

                <?php }
                ?>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Material</th>
                                <th>Cant</th>
                                <th>Existencia</th>
                                <th>Unidad</th>
                                <th>Responsable</th>
                                <th>Categoria</th>
                                <th>Status</th>
                                <th>Fecha</th>
                                <?php if ($_SESSION["type"] == 1) { ?>
                                    <th>Acciones.</th>
                                <?php }
                                ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            require_once("../includes/db.php");
                            $result = mysqli_query($conexion, "SELECT i.id, i.codigo, i.descripcion, i.cantidad, i.existencia, 
                            i.unidad, i.id_profesor, i.id_categoria, i.status, i.fecha, p.nombres, p.apellidos, c.categoria 
                            FROM inventario i INNER JOIN profesores p ON i.id_profesor = p.id INNER JOIN categorias c 
                            ON i.id_categoria = c.id");
                            while ($fila = mysqli_fetch_assoc($result)) :
                            ?>
                                <tr>
                                    <td><?php echo $fila['codigo']; ?></td>
                                    <td><?php echo $fila['descripcion']; ?></td>
                                    <td><?php echo $fila['cantidad']; ?></td>
                                    <td><?php echo $fila['existencia']; ?></td>
                                    <td><?php echo $fila['unidad']; ?></td>
                                    <td><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></td>
                                    <td><?php echo $fila['categoria']; ?></td>
                                    <td><?php echo $fila['status']; ?></td>
                                    <td><?php echo $fila['fecha']; ?></td>
                                    <?php if ($_SESSION["type"] == 1) { ?>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editar<?php echo $fila['id']; ?>">
                                                <i class="fa fa-edit "></i>
                                            </button>
                                            <a href="../includes/eliminar_inv.php?id=<?php echo $fila['id'] ?>" class="btn btn-danger btn-del">
                                                <i class="fa fa-trash "></i></a>
                                        </td>
                                    <?php }
                                    ?>
                                </tr>
                                <?php include "editar_inv.php"; ?>
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
        XLSX.writeFile(libro, "REPORTE_INVENTARIO.xlsx");
    }
</script>
<?php include "form_inv.php"; ?>
<?php include "../includes/footer.php"; ?>

</html>