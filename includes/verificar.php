<?php
include_once("db.php");

date_default_timezone_set('America/Mexico_City');
$fecha_actual = date('Y-m-d');
$day1 = date('Y-m-01');
$dayt = date('Y-m-t', strtotime($day1));

$SQL = mysqli_query($conexion, "SELECT pr.id, pr.id_profesor, pr.id_materia, pr.id_material, pr.fecha_slt, pr.fecha_fin,
pr.hora_in, pr.hora_fin, pr.cant, pr.status, pr.fecha_registrado,p.nombres, p.apellidos, m.materia, i.descripcion, i.unidad 
FROM prestamos pr INNER JOIN profesores p ON pr.id_profesor = p.id INNER JOIN materias m ON pr.id_materia = m.id 
INNER JOIN inventario i ON pr.id_material = i.id 
WHERE pr.fecha_slt >= '$day1' AND pr.fecha_slt <= '$dayt'
ORDER BY pr.id DESC LIMIT 5");

if (mysqli_num_rows($SQL) > 0) {
    while ($result = mysqli_fetch_assoc($SQL)) {

        $notification = array(
            'responsable' => $result['nombres'] . ' ' . $result['apellidos'],
            'descripcion' => '<br> Realizó el préstamo de <i>' . $result['descripcion'] . '</i> llevándose <i>' . $result['cant'] .  $result['unidad'] . ' </i> con fecha de devolución <b>' . $result['fecha_fin'].'</b>'
        );

        echo '<a class="dropdown-item d-flex align-items-center" href="#">
            <div class="mr-3">
                <div class="icon-circle bg-success">
                    <i class="fa fa-archive text-white" style="font-size: 18px;"></i>
                </div>
            </div>
            <span class="message-description"><b>' . $notification['responsable'] . '</b> ' . $notification['descripcion'] . '</span>
        </a>';
    }
}
