<?php
include_once "../includes/header.php";
include_once "../includes/db.php";
?>
<?php
error_reporting(0);
session_start();
$actualsesion = $_SESSION['correo'];

if ($actualsesion == null || $actualsesion == '') {
}
?>
<?php

$sql = "SELECT  u.id, u.usuario, u.correo, u.password,
u.fecha, u.imagen, p.rol FROM users u
LEFT JOIN permisos p ON u.id_rol= p.id   WHERE correo ='$actualsesion'";
$usuarios = mysqli_query($conexion, $sql);
if ($usuarios->num_rows > 0) {
    foreach ($usuarios as $key => $fila) {
        $ruta_imagen = $fila["imagen"];

?>

<?php
    }
}
?>

<?php
$consulta = "SELECT * FROM settings";
$sql = mysqli_query($conexion, $consulta);
if ($sql->num_rows > 0) {
    foreach ($sql as $key => $filas) {

?>
<?php
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/profile.css">



</head>

<body>
    <div class="container">
        <main id="main" class="main">

            <div class="pagetitle">
                <h1>Perfil</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <section class="section profile">
                <div class="row">
                    <div class="col-xl-4">

                        <div class="card">
                            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                                <img src="<?php echo $ruta_imagen; ?>" alt="Profile" class="rounded-circle">
                                <h2><?php echo $fila['usuario']; ?></h2>
                                <h3><?php echo $fila['rol']; ?></h3>
                                <div class="social-links mt-2">
                                    <a href="#" class="facebook" target="_blank"><i class="fab fa-facebook"></i></a>
                                    <a href="#" class="instagram" target="_blank"><i class="fab fa-instagram"></i></a>
                                    <a href="#" class="twitter" target="_blank"><i class="fab fa-twitter"></i></a>


                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-8">

                        <div class="card">
                            <div class="card-body pt-3">
                                <!-- Bordered Tabs -->
                                <ul class="nav nav-tabs nav-tabs-bordered">

                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Perfil</button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar Perfil</button>
                                    </li>



                                </ul>
                                <div class="tab-content pt-2">

                                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                        <br>
                                        <h5 class="card-title">Informacion</h5>
                                        <p class="small " style="text-align: justify;">Bienvenido al Sistema de Control Escolar</p>
                                        <br>
                                        <h5 class="card-title">Detalles de Perfil</h5>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Nombre:</div>
                                            <div class="col-lg-9 col-md-8"><?php echo $fila['usuario']; ?></div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Correo:</div>
                                            <div class="col-lg-9 col-md-8"><?php echo $fila['correo']; ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Tu Institucion:</div>
                                            <div class="col-lg-9 col-md-8"><?php echo $filas['instituto']; ?></div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Tipo de usuario:</div>
                                            <div class="col-lg-9 col-md-8"><?php echo $fila['rol']; ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Fecha de Registro:</div>
                                            <div class="col-lg-9 col-md-8"><?php echo $fila['fecha']; ?></div>
                                        </div>




                                    </div>

                                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                        <!-- Profile Edit Form -->

                                        <form id="form" enctype="multipart/form-data">


                                            <div class="row mb-3">
                                                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Imagen de perfil</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <img src="<?php echo $ruta_imagen; ?>" alt="Profile">
                                                    <div class="pt-2">
                                                        <input type="file" class="form-control" name="imagen" id="imagen">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Usuario:</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="usuario" type="text" data-id="<?php echo $fila['id']; ?>" class="form-control" id="usuario" value="<?php echo $fila['usuario']; ?>">
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label for="company" class="col-md-4 col-lg-3 col-form-label">Correo:</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="correo" type="text" class="form-control" id="correo" value="<?php echo $fila['correo']; ?>">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="Job" class="col-md-4 col-lg-3 col-form-label">Tipó de Usuario</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="id_rol" type="text" class="form-control" id="id_rol" readonly value="<?php echo $fila['rol']; ?>">
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="button" id="submitedit" class="btn btn-primary">Guardar Cambios</button>
                                            </div>
                                        </form><!-- End Profile Edit Form -->

                                    </div>


                                </div>

</body>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="../js/edit.js"></script>

<?php include "../includes/footer.php"; ?>

</html>