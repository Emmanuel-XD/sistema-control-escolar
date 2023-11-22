<?php include "../includes/header.php"; ?>
<link rel="stylesheet" href="../css/style.css">

<?php

extract($_GET);
$id_alumno = $_GET['id'];
require_once("../includes/db.php");
$sql = "SELECT m.materia, m.id_profesor, m.id_periodo, m.id_grado, g.descripcion, a.nombre, 
a.apellido FROM materias m INNER JOIN grados g ON m.id_grado = g.id INNER JOIN alumnos a ON a.id_grado = g.id WHERE a.id = '$id_alumno'";
$results = mysqli_query($conexion, $sql);
if ($results->num_rows > 0) {
    foreach ($results as $key => $row) {


?>

<?php
    }
}
?>

<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Calificar al Alumno(a) <?php echo $row['nombre'] . ' ' . $row['apellido']; ?></h6>
                <br>
                <form action="../includes/saveCalificacion.php" method="POST">
             
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="id_periodo">Num. de  periodo:</label>
                                <select name="id_periodo" id="id_periodo" class="control" required>
                                    <option value="">Selecciona una opcion</option>
                                    <?php

                                    include("db.php");

                                    $sql = "SELECT * FROM periodos ";
                                    $resultado = mysqli_query($conexion, $sql);
                                    while ($consulta = mysqli_fetch_array($resultado)) {
                                        echo '<option value="' . $consulta['id'] . '">' . $consulta['periodo'] . ' ( ' . $consulta['date_in'] . ' - ' . $consulta['date_fin'] . ')</option>';
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="id_evaluacion"> Num. de  evaluación:</label>
                                <select name="id_evaluacion" id="id_evaluacion" class="control" required>
                                    <option value="">Selecciona una opcion</option>
                                    <?php

                                    include("db.php");

                                    $sql = "SELECT * FROM evaluacion ";
                                    $resultado = mysqli_query($conexion, $sql);
                                    while ($consulta = mysqli_fetch_array($resultado)) {
                                        echo '<option value="' . $consulta['id'] . '">' . $consulta['evaluacion'] . '</option>';
                                    }

                                    ?>
                                </select>
                            </div>
                                <div class="col-sm-3">
                                     <button type="button" class="btn btn-success" id="save">Guardar <i class="fa fa-check"></i></button>
                             </div>
                    </div>
                </form>
            </div>


            <div class="card-body">
                <div class="table-responsive">
                <div class="alert alert-info is-completed" role="alert"> Selecciona un periodo y el numero de evaluación. </div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Materias</th>
                                <th>Puntuacion</th>

                            </tr>
                        </thead>

                        <tbody id="calificaciones-body">

                            <!-- <?php
                            extract($_GET);
                            $id_alumno = $_GET['id'];
                            require_once("../includes/db.php"); 
                            $result = mysqli_query($conexion, "SELECT m.materia, m.id_profesor, m.id_periodo, m.id_grado, g.descripcion, a.nombre, 
                            a.apellido FROM materias m INNER JOIN grados g ON m.id_grado = g.id INNER JOIN alumnos a ON a.id_grado = g.id WHERE a.id = '$id_alumno'");
                            while ($fila = mysqli_fetch_assoc($result)) :
                                
                            ?>

                            <?php endwhile; ?> -->
                            <tr>
                                    <td><?php echo $fila['materia']; ?></td>
                                    <td><input type="number" class="form-control" placeholder="0/100pts"></td>

                                </tr>
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

<script src="../js/save.js"></script>
<?php include "../includes/footer.php"; ?>

</html>