<?php

error_reporting(0);
require('../fpdf/fpdf.php');
include "fecha.php";

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {

        //$this->image('', 150, 1, 40); // X, Y, Tamaño
        $this->Ln(20);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 16);

        // Movernos a la derecha
        $this->Cell(100);
        // Título
        $this->setY(15);
        $this->setX(110);

        $this->Cell(70, 10, utf8_decode('REPORTE INDIVIDUAL DE AULAS '), 0, 1, 'C');

        include "db.php";
        $consulta = "SELECT * FROM settings";
        $sql = mysqli_query($conexion, $consulta);
        if ($sql->num_rows > 0) {
            foreach ($sql as $key => $celda) {
            }
        }

        $this->image($celda['imagen'], 5, 4, 35);  // X, Y, Tamaño

        $this->SetFont('Arial', '', 13);
        $this->setY(25);
        $this->setX(110);
        $this->Cell(60, 4,  utf8_decode($celda['instituto']), 0, 1, 'R');

        $this->SetFont('Arial', '', 12);
        $this->setY(30);
        $this->setX(103);
        $this->Cell(60, 4, utf8_decode('Clave ' . $celda['clave']), 0, 1, 'R');

        $this->SetFont('Arial', '', 12);
        $this->setY(35);
        $this->setX(105);
        $this->Cell(60, 4, utf8_decode($celda['direccion']), 0, 1, 'R');



        include "db.php";
        extract($_POST);
        $consulta = "SELECT c.id,c.id_profesor, c.id_materia, c.id_grado, c.id_grupo, c.id_aula,c.hor_ini,c.num_alum,
        c.sillas_disp,c.status,c.aula_limpia,c.material,c.hor_fin, c.fecha,c.fecha2, 
        p.nombres, p.apellidos, a.aula, m.materia, g.descripcion, gr.grupo FROM classroom_report c INNER JOIN profesores p 
        ON c.id_profesor = p.id INNER JOIN aulas a ON c.id_aula = a.id INNER JOIN materias m ON c.id_materia = m.id
        INNER JOIN grados g ON c.id_grado = g.id INNER JOIN grupos gr ON c.id_grupo = gr.id WHERE c.id_aula = '$id_aula' ";

        $sql = mysqli_query($conexion, $consulta);
        if ($sql->num_rows > 0) {
            foreach ($sql as $key => $filas) {
            }
        }

        $this->SetFont('Arial', '', 10);
        $this->SetY(45);
        $this->SetX(7);
        $this->Cell(60, 4, 'Alua: ' . utf8_decode($filas['aula']), 0, 1, 'L');

        $this->SetFont('Arial', '', 10);
        $this->SetY(52);
        $this->SetX(7);
        $this->Cell(60, 4, 'Fecha de Reporte: ' . utf8_decode($filas['fecha']), 0, 1, 'L');


        $this->SetFont('Arial', '', 10);
        $this->SetY(30);
        $this->SetX(220);
        $this->Cell(60, 4, '' . utf8_decode(fecha()), 0, 1, 'L');

        // Salto de línea
        $this->SetFont('Arial', 'B', 10);
        $this->Ln();
        $this->SetX(20);


        $this->Ln();
        $this->SetFont('Arial', 'B', 8);
        $this->SetY(68);
        $this->SetX(7);

        $this->Cell(40, 10, 'Profesor', 1, 0, 'C', 0);
        $this->Cell(34, 10, 'Materia', 1, 0, 'C', 0);
        $this->Cell(25, 10, 'Grado & Grupo', 1, 0, 'C', 0);
        $this->Cell(23, 10, 'Hora Entrada', 1, 0, 'C', 0,);
        $this->Cell(25, 10, 'Num Alum.', 1, 0, 'C', 0);
        $this->Cell(20, 10, 'Sillas Disp.', 1, 0, 'C', 0);
        $this->Cell(30, 10, 'Status Material', 1, 0, 'C', 0);
        $this->Cell(22, 10, 'Status Aula', 1, 0, 'C', 0);
        $this->Cell(22, 10, 'Mat Compl.', 1, 0, 'C', 0);
        $this->Cell(22, 10, 'Hora Salida', 1, 1, 'C', 0);
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
        $this->setY(-15);
        $this->setX(20);
        $this->Cell(60, 0, utf8_decode('ELABORADO'), 0, 1, 'C');



        $this->SetFont('Helvetica', 'B', 7);
        $this->Ln(20);
        $this->setY(-15);
        $this->setX(90);
        $this->Cell(60, 0, utf8_decode('FECHA DE IMPRESION'), 0, 1, 'C');



        $this->SetFont('Helvetica', 'B', 7);
        $this->Ln(20);
        $this->setY(-15);
        $this->setX(160);
        $this->Cell(60, 0, utf8_decode('VERSION DE FORMATO'), 0, 1, 'C');



        $this->SetFont('Helvetica', 'B', 7);
        $this->Ln(20);
        $this->setY(-12);
        $this->setX(18);
        $this->Cell(250, 0, '', 'T'); // DIVISION

        $this->SetFont('Helvetica', 'B', 7);
        $this->Ln(20);
        $this->setY(-9);
        $this->setX(20);
        $this->Cell(60, 0, utf8_decode('SISTEMA ESCOLAR'), 0, 1, 'C');



        $this->SetFont('Helvetica', 'B', 7);
        $this->Ln(20);
        $this->setY(-9);
        $this->setX(90);
        $this->Cell(60, 0, ''  . utf8_decode(fecha()), 0, 1, 'C');



        $this->SetFont('Helvetica', 'B', 7);
        $this->Ln(20);
        $this->setY(-9);
        $this->setX(160);
        $this->Cell(60, 0, utf8_decode('0.2'), 0, 1, 'C');




        //$this->SetFillColor(223, 229,235);
        //$this->SetDrawColor(181, 14,246);
        //$this->Ln(0.5);
    }
}

include "db.php";
extract($_POST);
date_default_timezone_set('America/Mexico_City');
$fecha_actual = date('Y-m-d');
$consulta = "SELECT c.id,c.id_profesor, c.id_materia, c.id_grado, c.id_grupo, c.id_aula,c.hor_ini,c.num_alum,
c.sillas_disp,c.status,c.aula_limpia,c.material,c.hor_fin, c.fecha,c.fecha2, 
p.nombres, p.apellidos, a.aula, m.materia, g.descripcion, gr.grupo FROM classroom_report c INNER JOIN profesores p 
ON c.id_profesor = p.id INNER JOIN aulas a ON c.id_aula = a.id INNER JOIN materias m ON c.id_materia = m.id
INNER JOIN grados g ON c.id_grado = g.id INNER JOIN grupos gr ON c.id_grupo = gr.id  WHERE c.id_aula = '$id_aula' AND c.fecha = '$fecha_actual'";
$resultado = mysqli_query($conexion, $consulta);

$pdf = new PDF();
$pdf = new PDF('L', 'mm', 'letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 0);

//$pdf->SetWidths(array(10, 30, 27, 27, 20, 20, 20, 20, 22));
while ($row = $resultado->fetch_assoc()) {

    $pdf->SetX(7);

    $pdf->Cell(40, 10, utf8_decode($row['nombres'] . ' ' . $row['apellidos']), 1, 0, 'L', 0);
    $pdf->Cell(34, 10, utf8_decode($row['materia']), 1, 0, 'L', 0);
    $pdf->Cell(25, 10, utf8_decode($row['descripcion'] . ' ' . $row['grupo']), 1, 0, 'L', 0);
    $pdf->Cell(23, 10, utf8_decode($row['hor_ini']), 1, 0, 'L', 0);
    $pdf->Cell(25, 10, utf8_decode($row['num_alum']), 1, 0, 'L', 0);
    $pdf->Cell(20, 10, utf8_decode($row['sillas_disp']), 1, 0, 'L', 0);
    $pdf->Cell(30, 10, utf8_decode($row['status']), 1, 0, 'L', 0);
    $pdf->Cell(22, 10, utf8_decode($row['aula_limpia']), 1, 0, 'L', 0);
    $pdf->Cell(22, 10, utf8_decode($row['material']), 1, 0, 'L', 0);
    $pdf->Cell(22, 10, utf8_decode($row['hor_fin']), 1, 1, 'L', 0);
}


$pdf->Output();
