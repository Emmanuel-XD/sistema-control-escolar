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

                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#inv">
                    <span class="glyphicon glyphicon-plus"></span> Agregar <i class="fa fa-plus"></i> </a></button>
                <!-- Agrega un botón para iniciar la exportación -->
                <button id="export-btn" class="btn btn-outline-success" type="button">Exportar a Excel</button>
                <a href="../includes/pdf.php" class="btn btn-outline-danger" target="_blank">Imprimir <i class="fa fa-file" aria-hidden="true"></i></a>
                <!-- Agrega un elemento de descarga para el archivo Excel -->
                <a id="download-link" style="display: none"></a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Material</th>
                                <th>Cant</th>
                                <th>Unidad</th>
                                <th>Responsable</th>
                                <th>Categoria</th>
                                <th>Fecha</th>
                                <th>Acciones.</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            require_once("../includes/db.php");
                            $result = mysqli_query($conexion, "SELECT * FROM inventario ");
                            while ($fila = mysqli_fetch_assoc($result)) :
                            ?>
                                <tr>
                                    <td><?php echo $fila['codigo']; ?></td>
                                    <td><?php echo $fila['descripcion']; ?></td>
                                    <td><?php echo $fila['cantidad']; ?></td>
                                    <td><?php echo $fila['unidad']; ?></td>
                                    <td><?php echo $fila['id_profesor']; ?></td>
                                    <td><?php echo $fila['id_categoria']; ?></td>
                                    <td><?php echo $fila['fecha']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editar<?php echo $fila['id']; ?>">
                                            <i class="fa fa-edit "></i>
                                        </button>
                                        <a href="../includes/eliminar_inv.php?id=<?php echo $fila['id'] ?>" class="btn btn-danger btn-del">
                                            <i class="fa fa-trash "></i></a>
                                    </td>
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
    // Función para exportar la tabla a un archivo Excel
    function exportTableToExcel() {

        const table = document.getElementById('dataTable');

        // Crear una matriz para almacenar los datos de la tabla
        const data = [];

        // Obtener todas las filas de la tabla
        const rows = table.querySelectorAll('tr');

        rows.forEach((row) => {
            const rowData = [];
            const cells = row.querySelectorAll('th, td');
            cells.forEach((cell) => {
                rowData.push(cell.innerText);
            });
            data.push(rowData);
        });

        // Crear una hoja de cálculo de Excel
        const workbook = XLSX.utils.book_new();
        const worksheet = XLSX.utils.aoa_to_sheet(data);
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Tabla');

        const excelBuffer = XLSX.write(workbook, {
            bookType: 'xlsx',
            type: 'array'
        });

        const blob = new Blob([excelBuffer], {
            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        });

        const downloadLink = document.getElementById('download-link');
        downloadLink.href = URL.createObjectURL(blob);
        downloadLink.download = 'recursos.xlsx';

        downloadLink.click();
    }

    const exportButton = document.getElementById('export-btn');
    exportButton.addEventListener('click', exportTableToExcel);
</script>
<?php include "form_inv.php"; ?>
<?php include "../includes/footer.php"; ?>

</html>