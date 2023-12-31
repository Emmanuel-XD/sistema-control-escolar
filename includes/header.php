<?php
error_reporting(0);
session_start();
$usuario = $_SESSION['correo'];
$permiso = $_SESSION['type'];
require_once "db.php";
if ($usuario == null || $usuario == ''  && $permiso == null || $permiso == '') {

?>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/validacion.js"></script>
    <script src="../package/dist/sweetalert2.all.js"></script>
    <script src="../package/dist/sweetalert2.all.min.js"></script>
<?php die();
} ?>
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
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php if ($_SESSION["type"] == '2' || $_SESSION["type"] == '1') { ?>../views/index.php
                    <?php } ?> ">

                    <div class=" sidebar-brand-text mx-3"><?php echo $fila['instituto']; ?><sup></sup>
                    </div>
                </a>
            <?php    } ?>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?php if ($_SESSION["type"] == '4' || $_SESSION["type"] == '2' || $_SESSION["type"] == '1') { ?>../views/index.php
                    <?php } ?> ">

                    <i class="fa fa-home" aria-hidden="true"></i>
                    <span>Home</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>
            <?php if ($_SESSION["type"] == '1' || $_SESSION["type"] == '4') { ?>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fa fa-graduation-cap"></i>
                        <span>Alumnos</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Ver Modulos</h6>
                            <a class="collapse-item" href="../views/alumnos.php">Ver Alumnos</a>
                            <!--     <a class="collapse-item" href="../views/consultar.php">Ver Calificaciones</a>-->

                        </div>
                    </div>
                </li>




                <!-- Nav Item - Utilities Collapse Menu -->
                <li class=" nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fa fa-user" aria-hidden="true"></i>
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
                            <a class="collapse-item" href="../views/aulas.php">Aulas</a>
                            <a class="collapse-item" href="../views/materias.php">Materias</a>
                            <a class="collapse-item" href="../views/grupos.php">Grupos</a>
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
                            <a class="collapse-item" href="../views/categorias.php">Categorias</a>
                            <a class="collapse-item" href="../views/prestamos.php">Historial de Prestamos</a>
                            <a class="collapse-item" href="../views/calendario.php">Calendario de Eventos</a>

                        </div>
                    </div>
                </li>
            <?php }
            ?>
            <!--Profesores-->
            <?php if ($_SESSION["type"] == 2) {

            ?>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwos" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <span>Tu Informacion</span>
                    </a>
                    <div id="collapseTwos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Ver Modulos</h6>
                            <a class="collapse-item" href="../home/consult_teacher.php">Consultar tu informacion</a>
                            <h6 class="collapse-header">Otras Acciones</h6>
                            <a class="collapse-item" href="../views/calificaciones.php">Asignar Calificaciones</a>
                            <a class="collapse-item" href="../views/inventario.php">Consultar Inventario</a>
                        </div>
                    </div>
                </li>
            <?php } ?>
            <!--End Profesoores-->

            <!--Alumnos-->
            <?php if ($_SESSION["type"] == 3) {

            ?>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwos" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <span>Tu Informacion</span>
                    </a>
                    <div id="collapseTwos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Ver Modulos</h6>
                            <a class="collapse-item" href="../views/inventario.php">Consultar Inventario</a>
                            <a class="collapse-item" href="../home/consult_student.php">Consultar tu informacion</a>


                        </div>
                    </div>
                </li>
            <?php } ?>
            <!--End Alumnos-->
            <?php if ($_SESSION["type"] == '1' || $_SESSION["type"] == '4') { ?>
                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOtss" aria-expanded="true" aria-controls="collapsePages">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Accesos Administrativos</span>
                    </a>
                    <div id="collapseOtss" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Ver Modulos</h6>
                            <a class="collapse-item" href="../views/cargos.php">Cargos Escolares</a>
                            <a class="collapse-item" href="../views/pagos.php">Pagos Escolares</a>
                            <a class="collapse-item" href="../views/historial.php">Historial de Pagos</a>
                        </div>
                    </div>
                </li>


                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Addons
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOtxs" aria-expanded="true" aria-controls="collapsePages">
                        <i class="fas fa-fw fa-file-pdf"></i>
                        <span>Reportes</span>
                    </a>
                    <div id="collapseOtxs" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Ver Modulos</h6>
                            <a class="collapse-item" href="../views/classroom_report.php">Reporte de Aula</a>

                        </div>
                    </div>
                </li>

                <!-- Nav Item - Tables -->
                <li class="nav-item">
                    <a class="nav-link" href="../views/usuarios.php">
                        <i class="fa fa-users" aria-hidden="true"></i>
                        <span>Usuarios</span></a>
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
                            <?php if ($_SESSION["type"] == '1' || $_SESSION["type"] == '2' || $_SESSION["type"] == '4') { ?>
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
                                            CENTRO DE NOTIFICACIONES
                                        </h6>
                                        <div id="notificationContent">
                                            <!-- notificaciones -->
                                        </div>
                                        <a class="dropdown-item text-center small text-gray-500" href="../views/prestamos.php">Show All Notifications</a>
                                    </div>
                                </li>


                                <script>
                                    $(document).ready(function() {
                                        function loadNotifications() {
                                            $.ajax({
                                                url: '../includes/verificar.php',
                                                method: 'POST',
                                                success: function(response) {
                                                    $('#notificationContent').html(response);
                                                }
                                            });
                                        }

                                        function updateNotificationCount() {
                                            $.ajax({
                                                url: '../includes/contar.php',
                                                type: 'GET',
                                                success: function(response) {
                                                    $('#count-label').text(response);
                                                    if (response === '0') {
                                                        $('#count-label').hide();
                                                    } else {
                                                        $('#count-label').show();
                                                    }
                                                },
                                                error: function() {
                                                    Swal.fire({
                                                        title: 'Error de conexión',
                                                        text: 'No se pudo cargar las notificaciones. Por favor, verifica tu conexión a internet.',
                                                        icon: 'info'
                                                    });
                                                }
                                            });
                                        }

                                        loadNotifications();
                                        updateNotificationCount();

                                        setInterval(function() {
                                            loadNotifications();
                                            updateNotificationCount();
                                        }, 5000);
                                    });
                                </script>



                                <!-- End Notificaciones-->
                            <?php } ?>
                            <?php
                            include "db.php";

                            $id = $_GET['id'];
                            $sql = "SELECT  u.id, u.usuario, u.correo, u.password, u.fecha, u.imagen, p.rol FROM users u
                        LEFT JOIN permisos p ON u.id_rol= p.id  WHERE correo ='$usuario'";
                            $usuarios = mysqli_query($conexion, $sql);
                            if ($usuarios->num_rows > 0) {
                                foreach ($usuarios as $key => $fila) {
                                    $ruta_imagen = $fila["imagen"];
                                }
                            }
                            ?>
                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?php echo $fila["usuario"]; ?></span>
                                    <img class="img-profile rounded-circle" src="<?php echo $ruta_imagen; ?>">
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="../views/profile.php">
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