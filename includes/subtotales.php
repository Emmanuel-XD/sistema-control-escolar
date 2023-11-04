<?php

include("../includes/db.php");

$sql = "SELECT * FROM cargos";
$resultado = mysqli_query($conexion, $sql);

$subtotales = array();

while ($fila = mysqli_fetch_assoc($resultado)) {
    $subtotales[$fila['cargo']] = $fila['monto'];
}

echo json_encode($subtotales);
?>
