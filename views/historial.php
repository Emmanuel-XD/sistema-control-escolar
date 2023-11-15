<?php include "../includes/header.php"; ?>


<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Historial de Pagos</h6>
                <br>

                <form action="" method="POST" accept-charset="utf-8" id="filtro-form">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label"><b> Del dia</b></label>
                                <input type="date" name="star" id="star" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label"><b>Hasta el dia</b> </label>
                                <input type="date" name="fin" id="fin" class="form-control" required>
                            </div>
                        </div>



                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="" class="form-label"><b>Filtrar</b></label><br>
                                <button type="button" id="filtro" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>
                        </div>

                    </div>
                </form>

                <a href="pagos.php" class="btn btn-success">Nuevo Pago <i class="fa fa-plus"></i></a>
                <button onclick="exportarExcel()" class="btn btn-primary blue">Exportar a Excel <i class="fas fa-download fa-sm text-white-50"></i></button>
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
                                <?php if ($_SESSION["type"] == 1) { ?>
                                    <th>Acciones</th>
                                <?php }
                                ?>
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
                                    <?php if ($_SESSION["type"] == 1) { ?>
                                        <td>

                                            <a href="../includes/recibo.php?id=<?php echo $fila['id'] ?>" target="_blank" class="btn btn-outline-danger">
                                                <i class="fa fa-file "></i></a>

                                            <a href="../includes/eliminar_pago.php?id=<?php echo $fila['id'] ?>" class="btn btn-danger btn-del">
                                                <i class="fa fa-trash "></i></a>
                                        </td>
                                    <?php }
                                    ?>
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
    $('#filtro').click(function(e) {
        e.preventDefault();
        var startDate = $('#star').val();
        var endDate = $('#fin').val();

        if (!startDate || !endDate) {
            Swal.fire({
                icon: 'warning',
                title: 'Fechas No Seleccionadas',
                text: 'Por favor, selecciona un rango de fechas antes de filtrar.',
            });
            return;
        }

        var data = {
            start: startDate,
            end: endDate
        };

        $.ajax({
            url: 'consult_history.php',
            method: 'POST',
            data: data,
            success: function(response) {
                $('#dataTable tbody').html(response);
            }
        });
    });
</script>
<script>
    var tabla = document.querySelector("#dataTable");
    var dataTable = new DataTable(tabla);

    function exportarExcel() {
        // Seleccionar la tabla
        var tabla = document.getElementById("dataTable");

        // Convertir la tabla en un archivo de Excel
        var libro = XLSX.utils.table_to_book(tabla);

        // Descargar el archivo
        XLSX.writeFile(libro, "REPORTE_HISTORIAL_PAGOS.xlsx");
    }
</script>

<?php include "../includes/footer.php"; ?>

</html>