<?php
session_start();
$typeUser = $_SESSION['type'];
if ($typeUser === '2' || $typeUser === '1') {

    error_reporting(0);
    $varsesion = $_SESSION['usuario'];

    if ($varsesion == null || $varsesion = '') {

        header("Location: ../includes/sesion/login.php");
        die();
    }
?>
    <?php include "../includes/header.php"; ?>

    <?php require_once('../includes/db.php') ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../js/fullcalendar/lib/main.min.css">
        <script src="../js/jquery-3.6.0.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/fullcalendar/lib/main.min.js"></script>

    </head>

    <body class="bg-light">

        <div class="container py-5" id="page-container">

            <div class="row">

                <div class="col-md-9">


                    <div id="calendar"></div>
                </div>
                <div class="col-md-3">
                    <div class="cardt rounded-0 shadow">
                        <div class="card-header bg-gradient bg-primary text-light">
                            <h5 class="card-title">Formulario De Prestamo</h5>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <form action="../includes/save_cita.php" method="post" id="schedule-form">
                                    <input type="hidden" name="id" value="">

                                    <div class="form-group mb-2">
                                        <label for="start_datetime" class="control-label">Fecha Solicitada</label>
                                        <input type="date" class="form-control form-control-sm rounded-0" name="fecha" id="fecha" required>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="start_datetime" class="control-label">Hora De Inicio</label>
                                        <input type="time" class="form-control form-control-sm rounded-0" name="hora" id="hora" required>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="start_datetime" class="control-label">Hora De Regreso</label>
                                        <input type="time" class="form-control form-control-sm rounded-0" name="hora" id="hora" required>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="start_datetime" class="control-label">Personal Solicita:</label>
                                        <select class="form-control" id="id_paciente" name="id_paciente">
                                            <option value="0">--Selecciona una opcion--</option>
                                            <?php

                                            include("../includes/db.php");
                                            //Codigo para mostrar categorias desde otra tabla
                                            $sql = "SELECT * FROM alumnos ";
                                            $resultado = mysqli_query($conexion, $sql);
                                            while ($consulta = mysqli_fetch_array($resultado)) {
                                                echo '<option value="' . $consulta['id'] . '">' . $consulta['nombre'] . '</option>';
                                            }

                                            ?>


                                        </select>
                                    </div>


                                    <div class="form-group mb-2">
                                        <label for="start_datetime" class="control-label">Materia Asignada</label>
                                        <select class="form-control" id="id_doctor" name="id_doctor">
                                            <option value="0">--Selecciona una opcion--</option>
                                            <?php

                                            include("../includes/db.php");
                                            //Codigo para mostrar categorias desde otra tabla
                                            $sql = "SELECT * FROM profesores ";
                                            $resultado = mysqli_query($conexion, $sql);
                                            while ($consulta = mysqli_fetch_array($resultado)) {
                                                echo '<option value="' . $consulta['id'] . '">' . $consulta['nombres'] . '</option>';
                                            }

                                            ?>


                                        </select>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="start_datetime" class="control-label">Estado</label>
                                        <select name="estado" id="estado" class="form-control" required>
                                            <option value="">--Selecciona una opcion--</option>
                                            <option value="1">Aprobado</option>
                                            <option value="2">Pendiente</option>
                                            <option value="3">Rechazado</option>
                                        </select>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-center">
                                <button class="btn btn-primary " type="submit" form="schedule-form">Guardar</button>
                                <button class="btn btn-danger " type="reset" form="schedule-form"> Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Event Details Modal -->
        <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-0">
                    <div class="modal-header rounded-0">
                        <h5 class="modal-title">Detalles de cita</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body rounded-0">
                        <div class="container-fluid">
                            <dl>
                                <dt class="text-muted">Fecha de cita</dt>
                                <dd id="fecha" class=""></dd>
                                <dt class="text-muted">Hora de cita</dt>
                                <dd id="hora" class=""></dd>
                                <dt class="text-muted">Paciente</dt>
                                <dd id="nombre" class=""></dd>
                                <dt class="text-muted">Doctor</dt>
                                <dd id="name" class=""></dd>
                                <dt class="text-muted">Estado</dt>
                                <dd id="estado" class=""></dd>

                            </dl>
                        </div>
                    </div>
                    <div class="modal-footer rounded-0">
                        <div class="text-end">

                            <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Event Details Modal -->

        <?php
        // $consulta = $conexion->query("SELECT ct.id, ct.fecha, ct.hora, ct.estado, ct.fecha_registro, 
        //p.nombre, d.name, est.estado FROM citas ct INNER JOIN pacientes p ON ct.id_paciente = p.id 
        //INNER JOIN doctor d ON ct.id_doctor = d.id LEFT JOIN estado est ON ct.estado = est.id");
        //$array = [];
        //foreach($consulta->fetch_all(MYSQLI_ASSOC) as $fila){
        //** $fila['sdate'] = date("F d, Y h:i A",strtotime($fila['hora']));
        //$fila['edate'] = date("F d, Y h:i A",strtotime($fila['fecha']));
        //$array[$fila['id']] = $fila;
        //}
        ?>
        <?php
        if (isset($conexion)) $conexion->close();
        ?>
    </body>
    <script>
        var fila = $.parseJSON('<?= json_encode($array) ?>')
    </script>

    <script src="../js/es.js"></script>
    <script src="../js/script.js"></script>

    </html>
    <?php include "../includes/footer.php"; ?>
    </body>

    </html>
<?php } else {
?>
    <!-- <div id="notAllow" ></div>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script  src="../js/not-allowed.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --><?php
                                                                            } ?>