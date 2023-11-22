<?php


	$id = $_GET['id'];
	require_once ("db.php");
	$query = mysqli_query($conexion,"DELETE FROM classroom_report WHERE id = '$id'");
	
	header ('Location: ../views/classroom_report.php?m=1');
