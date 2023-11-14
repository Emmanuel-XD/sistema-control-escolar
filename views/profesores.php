<?php include "../includes/header.php"; ?>


<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Profesores</h6>
                <br>

                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#prof">
                    <span class="glyphicon glyphicon-plus"></span> Agregar <i class="fa fa-plus"></i> </a></button>
                <button onclick="exportarExcel()" class="btn btn-primary blue">Exportar a Excel <i class="fas fa-download fa-sm text-white-50"></i></button>
            </div>
            <?php include "form_prof.php"; ?>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Cedula</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Correo</th>
                                <th>CURP</th>
                                <th>Edad</th>
                                <th>Nacimiento</th>
                                <th>Especialidad</th>
                                <th>Fecha_Registro</th>
                                <th>Acciones.</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            require_once("../includes/db.php");
                            $result = mysqli_query($conexion, "SELECT p.id, p.cedula, p.nombres, p.apellidos, p.correo, p.curp, 
                            p.edad, p.fecha_na, p.id_especialidad, p.fecha, e.especialidad FROM profesores p INNER JOIN especialidades e 
                            ON p.id_especialidad = e.id");
                            while ($fila = mysqli_fetch_assoc($result)) :

                            ?>
                                <tr>
                                    <td><?php echo $fila['cedula']; ?></td>
                                    <td><?php echo $fila['nombres']; ?></td>
                                    <td><?php echo $fila['apellidos']; ?></td>
                                    <td><?php echo $fila['correo']; ?></td>
                                    <td><?php echo $fila['curp']; ?></td>
                                    <td><?php echo $fila['edad']; ?></td>
                                    <td><?php echo $fila['fecha_na']; ?></td>
                                    <td><?php echo $fila['especialidad']; ?></td>
                                    <td><?php echo $fila['fecha']; ?></td>

                                    <td>
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editar<?php echo $fila['id']; ?>">
                                            <i class="fa fa-edit "></i>
                                        </button>
                                        <a href="../includes/eliminar_prof.php?id=<?php echo $fila['id'] ?>" class="btn btn-danger btn-del">
                                            <i class="fa fa-trash "></i></a>
                                    </td>
                                </tr>
                                <?php include "editar_prof.php"; ?>
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
        XLSX.writeFile(libro, "REPORTE_PROFESORES.xlsx");
    }
</script>

<?php include "../includes/footer.php"; ?>

</html>