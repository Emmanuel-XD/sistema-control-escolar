<?php
include "db.php";

date_default_timezone_set('America/Mexico_City');
$fecha_actual = date('Y-m-d');
$day1 = date('Y-m-01');
$dayt = date('Y-m-t', strtotime($day1));

$consult = mysqli_query($conexion, "SELECT COUNT(*) AS count FROM prestamos WHERE fecha_slt >= '$day1' AND fecha_slt <= '$dayt'");

$row = mysqli_fetch_assoc($consult);
$count = $row['count'];

echo $count;
