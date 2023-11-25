<?php
error_reporting();
session_start();
$usuario = $_SESSION['correo'];
$permiso = $_SESSION['type'];
if ($usuario == null || $usuario == ''  && $permiso == null || $permiso == '') {

    echo "<script language='JavaScript'>
    alert('Error: Debes iniciar sesion primero ');
    location.assign('sesion/login.php');
    </script>";

    die();
}

require('../fpdf/fpdf.php');
include "fecha.php";
// include "fecha.php";
date_default_timezone_set('America/Mexico_City');
$fecha = date("Y-m-d ");

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {

        //$this->image('', 150, 1, 40); // X, Y, Tamaño
        $this->Ln();
        // Arial bold 15
        $this->SetFont('Arial', 'B', 10);

        // Movernos a la derecha
        $this->Cell(100);

        // Título
        $this->setY(10);
        $this->setX(45);



        $this->SetFont('Arial', 'B', 17);
        $this->setY(15);
        $this->SetX(70);

        $this->Cell(70, 10, 'BOLETA DE CALIFICACION ', 0, 1, 'C');



        include "db.php";
        $consulta = "SELECT * FROM settings";
        $sql = mysqli_query($conexion, $consulta);
        if ($sql->num_rows > 0) {
            foreach ($sql as $key => $celda) {
            }
        }

        $this->image($celda['imagen'], 5, 4, 35);  // X, Y, Tamaño

        $this->SetFont('Arial', '', 11);
        $this->setY(38);
        $this->setX(140);
        $this->Cell(60, 4,  utf8_decode($celda['instituto']), 0, 1, 'R');

        $this->SetFont('Arial', '', 11);
        $this->setY(43);
        $this->setX(131);
        $this->Cell(60, 4, utf8_decode('Clave ' . $celda['clave']), 0, 1, 'R');

        $this->SetFont('Arial', '', 11);
        $this->setY(48);
        $this->setX(134);
        $this->Cell(60, 4, utf8_decode($celda['direccion']), 0, 1, 'R');

        include "db.php";
        //Aqui deberian llegar los id xd

        $id_alumno = $_POST['idStudent'];
        $id_periodo = $_POST['perEval'];
        $grado = $_POST['grado'];
        $is_history = 1;
        $consulta = "SELECT ce.id, ce.grade, c.promedio, m.materia, a.matricula, a.id 
        AS id_alumno, a.nombre, a.apellido, a.correo, e.evaluacion,
        p.periodo, p.date_in, p.date_fin, gr.grupo, g.descripcion 
        FROM calificacion_eval ce 
        INNER JOIN calificacion c ON ce.id_calificacion = c.id 
        INNER JOIN alumnos a ON ce.id_alumno = a.id 
        INNER JOIN materias m ON ce.id_materia = m.id 
        INNER JOIN evaluacion e ON ce.id_evaluacion = e.id 
        INNER JOIN periodos p ON ce.id_periodo = p.id 
        INNER JOIN grupos gr ON a.id_grupo = gr.id 
        INNER JOIN grados g ON m.id_grado = g.id 
        WHERE g.id = $grado AND id_alumno = '$id_alumno' AND ce.id_periodo = '$id_periodo' AND ce.is_history = '$is_history'";
        $sql = mysqli_query($conexion, $consulta);
        if ($sql->num_rows > 0) {
            foreach ($sql as $key => $filas) {
            }
        }
        $this->SetFont('Arial', '', 10);
        $this->SetY(25);
        $this->SetX(74);
        $this->Cell(60, 4, '' . utf8_decode($filas['periodo'] . ' (' . $filas['date_in'] . ' - ' . $filas['date_fin'] . ')'), 0, 1, 'C');

        $this->SetFont('Arial', '', 10);
        $this->SetY(60);
        $this->SetX(12.5);
        $this->Cell(60, 4, 'Matricula: ' . utf8_decode($filas['matricula']), 0, 1, 'L');

        $this->SetFont('Arial', '', 10);
        $this->SetY(65);
        $this->SetX(12.5);
        $this->Cell(60, 4, 'Alumno (a): ' . utf8_decode($filas['nombre'] . ' ' . $filas['apellido']), 0, 1, 'L');

        $this->SetFont('Arial', '', 10);
        $this->SetY(70);
        $this->SetX(12.5);
        $this->Cell(60, 4, 'Grado & Grupo: ' . utf8_decode($filas['descripcion'] . ' ' . $filas['grupo']), 0, 1, 'L');

        $this->SetFont('Arial', '', 10);
        $this->SetY(75);
        $this->SetX(12.5);
        $this->Cell(60, 4, 'Fecha de Impresion: ' . utf8_decode(fecha()), 0, 1, 'L');



        // Salto de línea
        $this->SetFont('Arial', 'B', 10);
        $this->Ln(10);
        $this->SetX(20);


        $this->Ln(3);
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(12);

        $this->Cell(60, 10, 'MATERIAS', 1, 0, 'L', 0);
        $this->Cell(30, 10, 'CALIFICACION 1', 1, 0, 'L', 0);
        $this->Cell(30, 10, 'CALIFICACION 2', 1, 0, 'L', 0,);
        $this->Cell(30, 10, 'CALIFICACION 3', 1, 0, 'L', 0,);
        $this->Cell(35, 10, 'PROMEDIO FINAL', 1, 1, 'L', 0,);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);

        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página



        $this->SetFont('Helvetica', 'B', 7);
        $this->Ln(20);
        $this->setY(240);
        $this->setX(18);
        $this->Cell(50, 0, '', 'T'); // DIVISION

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(245);
        $this->setX(12);
        $this->Cell(60, 0, utf8_decode('TUTOR(A)'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(250);
        $this->setX(12);
        $this->Cell(60, 0, utf8_decode('NOMBRE Y FIRMA '), 0, 1, 'C');


        //Otra firma
        $this->SetFont('Helvetica', 'B', 7);
        $this->Ln(20);
        $this->setY(240);
        $this->setX(140);
        $this->Cell(50, 0, '', 'T'); // DIVISION

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(245);
        $this->setX(136);
        $this->Cell(60, 0, utf8_decode('DIRECTOR(A)'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(250);
        $this->setX(136);
        $this->Cell(60, 0, utf8_decode('NOMBRE Y FIRMA'), 0, 1, 'C');
        //$this->SetFillColor(223, 229,235);
        //$this->SetDrawColor(181, 14,246);
        //$this->Ln(0.5);
    }
}

include "db.php";
$id_alumno = $_POST['idStudent'];
$id_periodo = $_POST['perEval'];
$grado = $_POST['grado'];
$is_history = 1;
$consulta = "SELECT m.materia,
       MAX(CASE WHEN ce.id_evaluacion = 1 THEN ce.grade END) AS calificacion_1,
       MAX(CASE WHEN ce.id_evaluacion = 2 THEN ce.grade END) AS calificacion_2,
       MAX(CASE WHEN ce.id_evaluacion = 3 THEN ce.grade END) AS calificacion_3,
       AVG(ce.grade) AS promedio_materia
FROM calificacion_eval ce
INNER JOIN alumnos a ON ce.id_alumno = a.id
INNER JOIN materias m ON ce.id_materia = m.id
INNER JOIN evaluacion e ON ce.id_evaluacion = e.id
INNER JOIN periodos p ON ce.id_periodo = p.id
INNER JOIN grupos gr ON a.id_grupo = gr.id
INNER JOIN grados g ON m.id_grado = g.id
WHERE ce.id_alumno = '$id_alumno'
  AND ce.id_periodo = '$id_periodo'
  AND ce.is_history = '$is_history'
  AND g.id = '$grado'
GROUP BY m.materia;
SELECT AVG(promedio_materia) AS promedio_general
FROM (
    SELECT AVG(ce.grade) AS promedio_materia
    FROM calificacion_eval ce
    INNER JOIN materias m ON ce.id_materia = m.id
    INNER JOIN alumnos a ON ce.id_alumno = a.id
    INNER JOIN grados g ON m.id_grado = g.id
       WHERE g.id = $grado
      AND ce.id_alumno = '$id_alumno'
      AND ce.id_periodo = '$id_periodo'
      AND ce.is_history = '$is_history'
    GROUP BY ce.id_alumno
) AS promedios_alumnos;

";

$resultado = mysqli_multi_query($conexion, $consulta);

if (!$resultado) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}

$resultado_materia = mysqli_store_result($conexion);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 0);

while ($row = mysqli_fetch_assoc($resultado_materia)) {
    $pdf->SetX(12);
    $pdf->Cell(60, 10, utf8_decode($row['materia']), 1, 0, 'L', 0);
    $pdf->Cell(30, 10, utf8_decode($row['calificacion_1']), 1, 0, 'L', 0);
    $pdf->Cell(30, 10, utf8_decode($row['calificacion_2']), 1, 0, 'L', 0);
    $pdf->Cell(30, 10, utf8_decode($row['calificacion_3']), 1, 0, 'L', 0);
    $pdf->Cell(35, 10, number_format($row['promedio_materia'], 2), 1, 1, 'L', 0);
}
mysqli_next_result($conexion);

$resultado_general = mysqli_store_result($conexion);

if ($row_general = mysqli_fetch_assoc($resultado_general)) {
    $pdf->SetX(12);
    $pdf->SetFont('Arial', 'B', 0);
    $pdf->Cell(60, 10, utf8_decode('PROMEDIO GENERAL'), 1, 0, 'L', 0);
    $pdf->Cell(30, 10, '', 1, 0, 'L', 0);
    $pdf->Cell(30, 10, '', 1, 0, 'L', 0);
    $pdf->Cell(30, 10, '', 1, 0, 'L', 0);
    $pdf->Cell(35, 10, number_format($row_general['promedio_general'], 2), 1, 1, 'L', 0);
}


$pdf->Output('_BOLETA.pdf', 'i');
