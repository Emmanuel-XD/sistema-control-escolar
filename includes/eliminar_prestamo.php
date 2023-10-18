<?php


	$id = $_GET['id'];
	require_once ("db.php");
	$query = mysqli_query($conexion,"DELETE FROM prestamos WHERE id = '$id'");
	
	header ('Location: ../views/prestamos.php?m=1');
