<?php
include_once "../includes/db.php";
if (isset($_POST['id_aula'])) {
    $idAula = $_POST['id_aula'];


    $result = mysqli_query($conexion, "SELECT c.id,c.id_profesor, c.id_materia, c.id_grado, c.id_grupo, c.id_aula,c.hor_ini,c.num_alum,
    c.sillas_disp,c.status,c.aula_limpia,c.material,c.hor_fin, c.fecha,c.fecha2, 
    p.nombres, p.apellidos, a.aula, m.materia, g.descripcion, gr.grupo FROM classroom_report c INNER JOIN profesores p 
    ON c.id_profesor = p.id INNER JOIN aulas a ON c.id_aula = a.id INNER JOIN materias m ON c.id_materia = m.id
    INNER JOIN grados g ON c.id_grado = g.id INNER JOIN grupos gr ON c.id_grupo = gr.id WHERE c.id_aula = '$idAula'");

    $output = '';
    while ($fila = mysqli_fetch_assoc($result)) {
        $output .= '<tr>
              <td>' . $fila['nombres'] . ' ' . $fila['apellidos'] . '</td>
              <td>' .  $fila['materia'] . '</td>
              <td>' . $fila['descripcion'] . ' ' . $fila['grupo'] . '</td>
              <td>' .  $fila['aula'] . '</td>
              <td>' . $fila['hor_ini'] . '</td>
              <td>' . $fila['num_alum'] . '</td>
              <td>' . $fila['sillas_disp'] . '</td>
              <td>' . $fila['status'] . '</td>
              <td>' . $fila['aula_limpia'] . '</td>
              <td>' . $fila['material'] . '</td>
              <td>' . $fila['hor_fin'] . '</td>
              <td>' . $fila['fecha2'] . '</td>
          </tr>';
    }

    echo $output;
}
