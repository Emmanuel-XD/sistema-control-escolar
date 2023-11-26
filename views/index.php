<?php
include "../includes/header.php";
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 ">Bienvenido <?php echo $_SESSION['usuario']; ?> al Sistema De Control Escolar</h1>

    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Materiales Prestados</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                include "../includes/db.php";

                                $SQL = "SELECT id FROM prestamos ORDER BY id";
                                $dato = mysqli_query($conexion, $SQL);
                                $fila = mysqli_num_rows($dato);

                                echo ($fila); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Estudiantes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                include "../includes/db.php";

                                $SQL = "SELECT id FROM alumnos ORDER BY id";
                                $dato = mysqli_query($conexion, $SQL);
                                $fila = mysqli_num_rows($dato);

                                echo ($fila); ?>
                            </div>
                        </div>
                        <div class="col-auto">

                            <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Profesores</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                include "../includes/db.php";

                                $SQL = "SELECT id FROM profesores ORDER BY id";
                                $dato = mysqli_query($conexion, $SQL);
                                $fila = mysqli_num_rows($dato);

                                echo ($fila); ?>
                            </div>
                        </div>
                        <div class="col-auto">

                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Usuarios</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php
                                include "../includes/db.php";

                                $SQL = "SELECT id FROM users WHERE id_rol <> 4 ORDER BY id";
                                $dato = mysqli_query($conexion, $SQL);
                                $fila = mysqli_num_rows($dato);

                                echo ($fila); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

<!-- End of Main Content -->
<?php include "../includes/footer.php";
?>