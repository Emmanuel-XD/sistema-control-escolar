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
                <h4 class="m-0 font-weight-bold text-center text-primary">HISTORIAL DE PRESTAMOS</h4>
                <br>
                <br>
                <a href="teacher_calendar.php?id=<?php echo $fila['id'] ?>" class="btn btn-success">Prestar <i class="fa fa-plus"></i></a>
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
                                <th>Docente Prestamista</th>
                                <th>Material</th>
                                <th>Cantidad</th>
                                <th>Status</th>
                                <th>Fecha_Prest</th>
                                <th>Fecha_Dev</th>
                                <th>Otros</th>
                                <?php if ($_SESSION["type"] == 1) { ?>
                                    <th>Acciones</th>
                                <?php }
                                ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            extract($_GET);
                            require_once("../includes/db.php");
                            $result = mysqli_query($conexion, "SELECT pr.id, pr.id_profesor, pr.id_materia, pr.id_material, pr.fecha_slt, pr.fecha_fin,
                            pr.hora_in, pr.hora_fin, pr.cant, pr.status, pr.fecha_registrado,p.nombres, p.apellidos, m.materia, i.descripcion, i.unidad 
                            FROM prestamos pr INNER JOIN profesores p ON pr.id_profesor = p.id INNER JOIN materias m ON pr.id_materia = m.id 
                            INNER JOIN inventario i ON pr.id_material = i.id  WHERE p.id_usuario = '$id'");
                            while ($fila = mysqli_fetch_assoc($result)) :
                            ?>
                                <tr>
                                    <td><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></td>
                                    <td><?php echo $fila['descripcion']; ?></td>
                                    <td><?php echo $fila['cant'] . ' ' . $fila['unidad']; ?></td>
                                    <td><?php echo $fila['status']; ?></td>
                                    <td><?php echo $fila['fecha_slt']; ?></td>
                                    <td><?php echo $fila['fecha_fin']; ?></td>
                                    <td>
                                        <form id="dev<?php echo $fila['id']; ?>" method="POST">

                                            <input type="hidden" name="accion" value="devolver_cant">
                                            <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">

                                            <button type="button" class="btn btn-primary devolver-material" onclick="confirmarDevolucion(<?php echo $fila['id']; ?>)">
                                                <i class="fa fa-chevron-circle-left"></i>
                                            </button>

                                            <a href="../includes/pdf_prestamo.php?id=<?php echo $fila['id']; ?>" target="_blank" class="btn btn-danger">
                                                <i class="fa fa-file" aria-hidden="true"></i>
                                        </form>
                                    </td>
                                    <?php if ($_SESSION["type"] == 1) { ?>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editar<?php echo $fila['id']; ?>">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <a href="../includes/eliminar_prestamo.php?id=<?php echo $fila['id']; ?>" class="btn btn-danger btn-del">
                                                <i class="fa fa-trash "></i></a>
                                        </td>
                                    <?php }
                                    ?>
                                </tr>
                                <?php include "editar_prest.php"; ?>
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
    function confirmarDevolucion(id) {
        swal.fire({
            title: 'Confirmar Devolución',
            text: '¿Estás seguro de que deseas devolver este material?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, devolver',
            cancelButtonText: 'Cancelar',
        }).then(function(result) {
            if (result.isConfirmed) {
                devolverMaterial(id);
            }
        });
    }

    function devolverMaterial(id) {
        var datosFormulario = $("#dev" + id).serialize() + '&confirmacion=confirmado';

        $.ajax({
            url: "../includes/functions.php",
            type: "POST",
            data: datosFormulario,
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    swal.fire({
                        title: 'Éxito',
                        text: response.message,
                        icon: 'success',
                    }).then(function() {
                        location.reload();
                    });
                } else if (response.status === 'confirmacion') {

                } else {
                    swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                    });
                }
            },
            error: function() {
                swal.fire({
                    title: 'Error',
                    text: 'Error de comunicación con el servidor',
                    icon: 'error',
                });
            }
        });
    }
</script>


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
        downloadLink.download = 'datos_inventario.xlsx';

        downloadLink.click();
    }

    const exportButton = document.getElementById('export-btn');
    exportButton.addEventListener('click', exportTableToExcel);
</script>
<?php include "form_inv.php"; ?>
<?php include "../includes/footer.php"; ?>

</html>