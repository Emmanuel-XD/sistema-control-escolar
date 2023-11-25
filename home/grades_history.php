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
<style>
  .swal2-html-container{
    overflow: hidden;
  }
</style>
<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ver calificaciones pasadas de: <?php echo $row['nombre'] . ' ' . $row['apellido']; ?></h6>
                <br>
                <form action="../includes/saveCalificacion.php" method="POST">

                    <div class="row">
                        <div class="col-sm-4">
                            <label for="id_periodo">Num. de periodo:</label>
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
                        <div class="col-sm-4">
                            <label for="id_grade"> Grado cursado:</label>
                            <select name="id_grade" id="id_grade" class="control" required>
                                <option value="">Selecciona una opcion</option>
                                <?php

                                include("db.php");
                                $idUser = $_GET['id'];
                                $sql = "SELECT DISTINCT grados.id, grados.descripcion
                                FROM calificacion_eval
                                JOIN materias ON materias.id = calificacion_eval.id_materia 
                                JOIN grados ON grados.id = materias.id_grado
                                WHERE calificacion_eval.id_alumno = $idUser AND calificacion_eval.is_history = 1;";
                                $resultado = mysqli_query($conexion, $sql);
                                while ($consulta = mysqli_fetch_array($resultado)) {
                                    echo '<option value="' . $consulta['id'] . '">' . $consulta['descripcion'] . '</option>';
                                }

                                ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" id="genCalif" class="btn btn-danger" id="save">Boleta <i class="far fa-file-pdf"></i></button>
                        </div>
                    </div>
                </form>
            </div>


            <div class="card-body">
                <div class="table-responsive">
                    <div class="alert alert-info is-completed" role="alert"> Selecciona un periodo y el numero de evaluación. </div>
                    <table class="table table-bordered" id="dataTable" class="display"></table>
                    <!-- Modal -->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Content goes here -->
                                    <p id="modalContent"></p>
                                </div>
                            </div>
                        </div>
                    </div>




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

<script src="../js/saveOlds.js"></script>
<?php include "../includes/footer.php"; ?>

</html>