<?php
include("../includes/db.php");


if (isset($_POST['id_grado'])) {
    $gradoId = $_POST['id_grado'];

    // Realiza una consulta para obtener las materias relacionadas con el grado seleccionado
    $sql = "SELECT * FROM materias WHERE id_grado = $gradoId";
    $result = mysqli_query($conexion, $sql);

    $materias = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $materias[] = $row['materia'];
    }

    // Devuelve las materias como JSON
    echo json_encode($materias);
}
?>