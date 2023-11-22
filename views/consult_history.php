<?php
error_reporting(0);
session_start();
$usuario = $_SESSION['correo'];
$permiso = $_SESSION['type'];
if ($usuario == null || $usuario == ''  && $permiso == null || $permiso == '') {

    echo "<script language='JavaScript'>
    alert('Error: Debes iniciar sesion primero ');
    location.assign('../includes/sesion/login.php');
    </script>";

    die();
}
include "../includes/db.php";


$startDate = $_POST['start'];
$endDate = $_POST['end'];

$sql = "SELECT p.id, p.total, p.pago, p.fecha,p.beca, a.matricula, a.nombre, a.apellido, g.descripcion, c.cargo, c.monto
FROM pagos p INNER JOIN alumnos a ON p.id_alumno = a.id INNER JOIN grados g ON p.id_grado = g.id INNER JOIN cargos c 
ON p.id_cargo = c.id";

if (!empty($startDate) && !empty($endDate)) {
    $sql .= " WHERE DATE(p.fecha) BETWEEN '$startDate' AND '$endDate'";
}

$result = mysqli_query($conexion, $sql);

$output = '';
$total = 0;

while ($fila = mysqli_fetch_array($result)) {
    $output .= '<tr>
    <td>' . $fila['nombre'] . ' ' . $fila['apellido'] . '</td>
    <td>' . $fila['descripcion'] . '</td>
    <td>' . $fila['cargo'] . '</td>
    <td>' . $fila['beca'] . '%' . '</td>
    <td>' . '$' . $fila['pago'] . '</td>
    <td>' . $fila['fecha'] . '</td>
        <td>';

    if ($_SESSION["type"] == 1) {
        $output .= ' <a href="../includes/recibo.php?id=' . $fila['id'] . '" target="_blank" class="btn btn-outline-danger">
        <i class="fa fa-file "></i></a>
                    <a href="../includes/eliminar_pagina.php?id=' . $fila['id'] . '" class="btn btn-danger btn-del">
                        <i class="fa fa-trash"></i>
                    </a>';
    }

    $output .= '</td>
    </tr>';

    $total += $fila['pago'];
}

$totalOutput = '';
if ($total != 0) {
    $totalOutput = '<tr>
                        <td class="text-right"><strong>Total de Pagos:</strong></td>
                        <td><strong>$' . $total . '</strong></td>
                    </tr>';
}

if (mysqli_num_rows($result) == 0) {
    $output .= '<tr>
                    <td colspan="6" class="text-center">No se encontraron registros</td>
                </tr>';

    $output .= '<script>
                    Swal.fire({
                        icon: "info",
                        title: "No se encontraron registros",
                        text: "No hay resultados para mostrar",
                    });
                </script>';
}

$output .= $totalOutput;

echo $output;
?>
<script>
    $('.btn-del').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')

        Swal.fire({
            title: 'Estas seguro de eliminar este registro?',
            text: "¡No podrás revertir esto!!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'Cancelar!',
        }).then((result) => {
            if (result.value) {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Eliminado!',
                        'El registro fue eliminado.',
                        'success'
                    )
                }

                document.location.href = href;
            }
        })
    })
</script>