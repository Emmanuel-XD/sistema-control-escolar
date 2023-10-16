<?php


	$id = $_GET['id'];
	require_once ("db.php");
	$query = mysqli_query($conexion,"DELETE FROM especialidades WHERE id = '$id'");
	
	header ('Location: ../views/especialidades.php?m=1');
