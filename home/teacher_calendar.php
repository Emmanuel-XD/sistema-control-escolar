<?php
error_reporting(0);
session_start();
include "../includes/header.php";

$typeUser = $_SESSION['type'];
if ($typeUser === '1' || $typeUser === '2' || $typeUser === '3') {


    $varsesion = $_SESSION['correo'];

    if ($varsesion == null || $varsesion = '') {

        header("Location: ../includes/sesion/login.php");
        die();
    }

?>



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
    <style>
        .two-columns {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .two-columns>div {
            flex: 1;
            padding: 10px;
        }

        .fc-day.fc-day-disabled {
            background-color: transparent;
            color: #333;

        }

        #calendar {
            max-width: 1000px;
        }

        .col-centered {
            float: none;
            margin: 0 auto;
        }

        .hidden {
            display: none;
        }
    </style>


    <body class="bg-light">

        <div class="container " id="page-container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3>CALENDARIO DE PRESTAMOS</h3>
                    <p class="lead">¡Agrega los eventos que quieres guardar! Seleciona los dias con el cursor.</p>
                    <div id="calendar" class="col-centered"></div>
                </div>
                <div class="modal fade" id="modal-registro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h3 class="modal-title" id="exampleModalLabel">Formulario De Prestamo</h3>

                            </div>
                            <div class="modal-body">
                                <form id="prestForm">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="start_datetime" class="control-label">Fecha Solicitada</label>
                                                <input type="date" class="form-control form-control-sm rounded-0" name="fecha_slt" id="fecha_slt" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="start_datetime" class="control-label">Fecha De Devolucion</label>
                                                <input type="date" class="form-control form-control-sm rounded-0" name="fecha_fin" id="fecha_fin" required>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="start_datetime" class="control-label">Hora De Inicio</label>
                                                <input type="time" class="form-control form-control-sm rounded-0" name="hora_in" id="hora_in" required>
                                            </div>
                                        </div>


                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="start_datetime" class="control-label">Hora De Regreso</label>
                                                <input type="time" class="form-control form-control-sm rounded-0" name="hora_fin" id="hora_fin" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="start_datetime" class="control-label">Personal Solicita:</label>
                                                <select class="form-control" id="id_profesor" name="id_profesor">

                                                    <?php

                                                    include("../includes/db.php");
                                                    //Codigo para mostrar categorias desde otra tabla
                                                    $sql = "SELECT * FROM profesores WHERE id_usuario = '$id'";
                                                    $resultado = mysqli_query($conexion, $sql);
                                                    while ($consulta = mysqli_fetch_array($resultado)) {
                                                        echo '<option value="' . $consulta['id'] . '">' . $consulta['nombres'] . ' ' . $consulta['apellidos'] . '</option>';
                                                    }

                                                    ?>


                                                </select>
                                            </div>
                                        </div>



                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="start_datetime" class="control-label">Materia Asignada</label>
                                                <select class="form-control" id="id_materia" name="id_materia">
                                                    <option value="0">--Selecciona una opcion--</option>
                                                    <?php

                                                    include("../includes/db.php");
                                                    //Codigo para mostrar categorias desde otra tabla
                                                    $sql = "SELECT * FROM materias ";
                                                    $resultado = mysqli_query($conexion, $sql);
                                                    while ($consulta = mysqli_fetch_array($resultado)) {
                                                        echo '<option value="' . $consulta['id'] . '">' . $consulta['materia'] . '</option>';
                                                    }

                                                    ?>


                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="start_datetime" class="control-label">Cantidad a Prestar</label>
                                                <input type="number" name="cant" id="cant" class="form-control" required>
                                            </div>
                                        </div>



                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="start_datetime" class="control-label">Estado De Solicitud</label>
                                                <select name="status" id="status" class="form-control" required>
                                                    <option value="">--Selecciona una opcion--</option>
                                                    <option value="Solicitar">Solicitar</option>
                                                    <?php if ($_SESSION["type"] == 1) { ?>
                                                        <option value="Aprobado">Aprobado</option>
                                                        <option value="Pendiente">Pendiente</option>
                                                        <option value="Rechazado">Rechazado</option>
                                                        <option value="Agotado">Agotado</option>
                                                        <option value="Devuelto">Devuelto</option>
                                                        <option value="No Devuelto">No Devuelto</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="start_datetime" class="control-label">Material Solicitado</label>
                                        <select class="form-control" id="id_material" name="id_material">
                                            <option value="0">--Selecciona una opcion--</option>
                                            <?php

                                            include("../includes/db.php");
                                            //Codigo para mostrar categorias desde otra tabla
                                            $sql = "SELECT * FROM inventario ";
                                            $resultado = mysqli_query($conexion, $sql);
                                            while ($consulta = mysqli_fetch_array($resultado)) {
                                                echo '<option value="' . $consulta['id'] . '">' . $consulta['descripcion'] . '</option>';
                                            }

                                            ?>


                                        </select>
                                    </div>

                                    <input type="hidden" name="accion" value="insert_prest">
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" id="register" name="registrar">Guardar</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                <?php
                $consulta = $conexion->query("SELECT pr.id, pr.id_profesor, pr.id_materia, pr.id_material, pr.fecha_slt, pr.fecha_fin,
                pr.hora_in, pr.hora_fin, pr.cant, pr.status, pr.fecha_registrado,p.nombres, p.apellidos, m.materia, i.descripcion, i.unidad 
                FROM prestamos pr INNER JOIN profesores p ON pr.id_profesor = p.id INNER JOIN materias m ON pr.id_materia = m.id 
                INNER JOIN inventario i ON pr.id_material = i.id");
                $array = [];
                foreach ($consulta->fetch_all(MYSQLI_ASSOC) as $fila) {
                    $fila['sdate'] = date("F d, Y h:i A", strtotime($fila['fecha_slt']));
                    $fila['edate'] = date("F d, Y h:i A", strtotime($fila['fecha_fin']));
                    $array[$fila['id']] = $fila;
                }
                ?>
                <?php
                if (isset($conexion)) $conexion->close();
                ?>

                <!-- Event Details Modal -->
                <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h3 class="modal-title" id="exampleModalLabel">Datos De Solicitud</h3>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <dl class="two-columns">
                                        <div>
                                            <dt class="text-muted">Material Solicitado:</dt>
                                            <dd id="descripcion" class=""></dd>

                                            <dt class="text-muted">Cantidad:</dt>
                                            <dd id="cant" class=""></dd>

                                            <dt class="text-muted">Fecha De Prestamo:</dt>
                                            <dd id="fecha_slt" class=""></dd>

                                            <dt class="text-muted">Fecha De Devolucion:</dt>
                                            <dd id="fecha_fin" class=""></dd>

                                            <dt class="text-muted">Clase En Uso:</dt>
                                            <dd id="materia" class=""></dd>

                                        </div>

                                        <div>
                                            <dt class="text-muted">Hora De Inicio:</dt>
                                            <dd id="hora_in" class=""></dd>

                                            <dt class="text-muted">Hora De Regreso:</dt>
                                            <dd id="hora_fin" class=""></dd>

                                            <dt class="text-muted">Personal Escolar:</dt>
                                            <dd id="nombres" class=""></dd>

                                            <dt class="text-muted">Estado:</dt>
                                            <dd id="status" class=""></dd>

                                            <dt class="text-muted hidden">NumSolicitud#:</dt>
                                            <dd id="id" class="hidden"><?php echo $fila['id']; ?></dd>

                                        </div>
                                    </dl>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-id="<?php echo $fila['id']; ?>" onclick="generarPDF(this)">
                                    PDF <i class="fa fa-file"></i>
                                </button>

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>


    </body>
    <script>
        function generarPDF() {
            var id = $('#id').text(); // Obtén el id del elemento en el modal
            var url = `../includes/pdf_prestamo.php?id=${id}`;
            window.open(url, '_blank');
        }
    </script>


    <script>
        var fila = $.parseJSON('<?= json_encode($array) ?>')
    </script>

    <script src="../js/es.js"></script>
    <script src="script.js"></script>

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