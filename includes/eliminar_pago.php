<?php


	$id = $_GET['id'];
	require_once ("db.php");
	$query = mysqli_query($conexion,"DELETE FROM pagos WHERE id = '$id'");
	
	header ('Location: ../views/historial.php?m=1');
