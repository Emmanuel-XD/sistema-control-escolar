<?php


$id = $_GET['id'];
require_once("db.php");
$query = mysqli_query($conexion, "DELETE FROM profesores WHERE id = '$id'");

header('Location: ../views/profesores.php?m=1');
