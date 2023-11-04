<?php


$id = $_GET['id'];
require_once("db.php");
$query = mysqli_query($conexion, "DELETE FROM cargos WHERE id = '$id'");

header('Location: ../views/cargos.php?m=1');
