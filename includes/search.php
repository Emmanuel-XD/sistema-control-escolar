<?php
require_once("../includes/db.php");


$searchTerm = $_GET['term'];

$query = "SELECT a.id, a.matricula, a.nombre, a.apellido, a.beca, a.id_grado,  g.descripcion
FROM alumnos a INNER JOIN grados g ON a.id_grado = g.id
WHERE a.matricula LIKE '%$searchTerm%' OR a.nombre LIKE '%$searchTerm%'  LIMIT 3";

$result = mysqli_query($conexion, $query);

$data = array();
while ($fila = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id_alumno' => $fila['id'],
        'id_grado' => $fila['id_grado'],
        'matricula' => $fila['matricula'],
        'nombre' => $fila['nombre'],
        'apellido' => $fila['apellido'],
        'descripcion' => $fila['descripcion'],
        'beca' => $fila['beca']
    );
}


echo json_encode($data);
