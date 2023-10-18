<?php


	$id = $_GET['id'];
	require_once ("db.php");
	$query = mysqli_query($conexion,"DELETE FROM categorias WHERE id = '$id'");
	
	header ('Location: ../views/categorias.php?m=1');
