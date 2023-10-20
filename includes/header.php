<?php
error_reporting(0);
session_start();
$usuario = $_SESSION['usuario'];
$permiso = $_SESSION['type'];
if ($usuario == null || $usuario == ''  && $permiso == null || $permiso == '') {

    echo "<script language='JavaScript'>
    alert('Error: Debes iniciar sesion primero ');
    location.assign('../includes/sesion/login.php');
    </script>";

    die();
}
require_once "db.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SISTEMA DE CONTROL ESCOLAR</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../package/dist/sweetalert2.css">
    <!-- Custom styles for this template-->

    <link href="../css/sb-admin-2.min.css" rel="stylesheet">


    <script src="../js/jquery.min.js"></script>

</head>
<style>
    .lgs {
        border-radius: 126px;
        width: 75px;
        height: auto;
    }
</style>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
       
        $consulta = mysqli_query($conexion, "SELECT * FROM settings ");

        while ($fila = mysqli_fetch_array($consulta)) {

        ?>
            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-<?php echo $fila['tema']; ?> sidebar sidebar-dark accordion" id="accordionSidebar">

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">

                    <div class=" sidebar-brand-text mx-3"><?php echo $fila['instituto']; ?><sup></sup>
                    </div>
                </a>
            <?php    } ?>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="../views/index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Panel</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Alumnos</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Ver Modulos</h6>
                        <a class="collapse-item" href="../views/alumnos.php">Ver Alumnos</a>
                        <a class="collapse-item" href="../views/consultar.php">Ver Calificaciones</a>

                    </div>
                </div>
            </li>




            <!-- Nav Item - Utilities Collapse Menu -->
            <li class=" nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Profesores</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Ver Modulos</h6>
                        <a class="collapse-item" href="../views/profesores.php">Ver Profesores</a>
                        <a class="collapse-item" href="../views/calificaciones.php">Asignar Calificaciones</a>
                    </div>
                </div>
            </li>


            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOts" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Accesos Escolares</span>
                </a>
                <div id="collapseOts" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Ver Modulos</h6>
                        <a class="collapse-item" href="../views/materias.php">Materias</a>
                        <a class="collapse-item" href="../views/grados.php">Grados</a>
                        <a class="collapse-item" href="../views/especialidades.php">Especialidades</a>
                        <a class="collapse-item" href="../views/periodos.php">Periodos</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Prestamos & Almacen</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Ver Modulos</h6>
                        <a class="collapse-item" href="../views/inventario.php">Inventario</a>
                        <a class="collapse-item" href="../views/prestamos.php">Historial de Prestamos</a>
                        <a class="collapse-item" href="../views/calendario.php">Calendario de Eventos</a>

                    </div>
                </div>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="../views/categorias.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Categorias</span></a>
            </li>
            <?php

            $consulta = mysqli_query($conexion, "SELECT * FROM settings ");
            while ($fila = mysqli_fetch_array($consulta)) {
            ?>
                <!-- Nav Item - Charts -->
                <li class="nav-item">
                    <a class="nav-link" href="../views/settings.php?id=<?php echo $fila['id']; ?>">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Configuracion</span></a>
                </li>
            <?php } ?>

            <?php if ($_SESSION["type"] == 1) { ?>
                <!-- Nav Item - Tables -->
                <li class="nav-item">
                    <a class="nav-link" href="../views/usuarios.php">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Usuarios</span></a>
                </li>
            <?php }
            ?>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>



            </ul>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                        <!-- Sidebar Toggle (Topbar) -->
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>



                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">

                            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                            <li class="nav-item dropdown no-arrow d-sm-none">
                                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-search fa-fw"></i>
                                </a>
                                <!-- Dropdown - Messages -->
                                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="form-inline mr-auto w-100 navbar-search">
                                        <div class="input-group">
                                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button">
                                                    <i class="fas fa-search fa-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>

                            <!-- Nav Item - Alerts -->
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bell fa-fw"></i>
                                    <!-- Counter - Alerts -->
                                    <span class="badge bg-danger" id="count-label"></span>
                                </a>
                                <!-- Dropdown - Alerts -->
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                    <h6 class="dropdown-header">
                                        Alerts Center
                                    </h6>
                                    <div id="notificationContent">

                                    </div>




                                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                                </div>
                            </li>


                            <?php
                            include "db.php";

                            $id = $_GET['id'];
                            $sql = "SELECT  u.id, u.usuario, u.correo, u.password, u.fecha, p.rol FROM users u
                        LEFT JOIN permisos p ON u.id_rol= p.id  WHERE usuario ='$usuario'";
                            $usuarios = mysqli_query($conexion, $sql);
                            if ($usuarios->num_rows > 0) {
                                foreach ($usuarios as $key => $fila) {
                                }
                            }
                            ?>
                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?php echo $_SESSION['usuario']; ?></span>
                                    <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Profile
                                    </a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>

                        </ul>

                    </nav>
                    <!-- End of Topbar -->

                    <?php include "../views/salir.php"; ?>