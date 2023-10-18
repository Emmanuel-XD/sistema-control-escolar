<?php include "../includes/header.php"; ?>
<?php
error_reporting(0);
session_start();
$actualsesion = $_SESSION['usuario'];

if ($actualsesion == null || $actualsesion == '') {
}
?>
<?php

$sql = "SELECT  u.id, u.usuario, u.correo, u.password, u.fecha, p.rol, a.nombre, a.apellido, a.id AS id_alumno,
g.descripcion FROM users u LEFT JOIN permisos p ON u.id_rol= p.id LEFT JOIN alumnos a ON a.id_user = u.id 
INNER JOIN grados g ON a.id_grado = g.id  WHERE usuario ='$actualsesion' ";
$usuarios = mysqli_query($conexion, $sql);
if ($usuarios->num_rows > 0) {
    foreach ($usuarios as $key => $row) {
        $id_alumno = $row["id_alumno"];
    }
}

//echo $id_alumno;
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Materias de <?php echo $row['nombre'] . ' ' . $row['apellido'] . ' ' . $row['descripcion']; ?></h6>
                <br>


            </div>


            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Grado</th>
                                <th>Calificacion</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            extract($_GET);
                            require_once("../includes/db.php");
                            $result = mysqli_query($conexion, "SELECT m.materia, m.id_profesor, m.id_periodo, m.id_grado, 
                            g.descripcion, a.nombre, a.apellido FROM materias m INNER JOIN grados g ON m.id_grado = g.id 
                            INNER JOIN alumnos a ON a.id_grado = g.id WHERE a.id = '$id_alumno' AND a.id_grado = '$id'");

                            if (mysqli_num_rows($result) > 0) {
                                while ($fila = mysqli_fetch_assoc($result)) :
                            ?>
                                    <tr>
                                        <td><?php echo $fila['materia']; ?></td>
                                        <td><input type="number" class="form-control" placeholder="0/100pts" disabled></td>
                                    </tr>
                            <?php
                                endwhile;
                            } else {
                                // No hay datos, muestra una alerta
                                echo '<script>';
                                echo 'Swal.fire({';
                                echo 'icon: "warning",';
                                echo 'title: "Acceso denegado",';
                                echo 'text: "No hay materias disponibles para este grado."';
                                echo '}).then(() => {';
                                echo 'window.location = "consultar.php";'; // Redirige o realiza otra acción si es necesario
                                echo '});';
                                echo '</script>';
                            }
                            ?>
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


    <?php include "../includes/footer.php"; ?>