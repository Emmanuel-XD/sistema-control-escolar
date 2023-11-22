<?php


$id = $_GET['id'];
require_once("db.php");
$query = mysqli_query($conexion, "DELETE FROM aulas WHERE id = '$id'");

header('Location: ../views/aulas.php?m=1');
