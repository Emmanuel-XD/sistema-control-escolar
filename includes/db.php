<?php

$host = "czu.h.filess.io";
$user = "controlEscolar_valuableif";
$password = "72659f651655f158ad383189884879d156b523bf";
$database = "controlEscolar_valuableif";
$puerto = "3305";


$conexion = mysqli_connect($host, $user, $password, $database, $puerto);
if (!$conexion) {
    echo "No se realizo la conexion a la basa de datos, el error fue:" .
        mysqli_connect_error();
}
