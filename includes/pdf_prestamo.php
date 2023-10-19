<?php

session_start();
error_reporting(0);

date_default_timezone_set('America/Mexico_City');
$fecha = date("Y-m-d ");
include "db.php";
extract($_POST);


require('../fpdf/fpdf.php');

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


        $this->SetFont('Arial', 'B', 14);
        $this->setY(10);
        $this->SetX(75);

       // $this->image('./img/logo.jpg', 5, 4, 35);  // X, Y, Tamaño
       // $this->image('./img/sistemas.png', 170, 0, 50);  // X, Y, Tamaño

        $this->Cell(70, 10, 'NOMBRE DE INSTITUCION', 0, 1, 'C');

        $this->SetFont('Arial', 'B', 12);
        $this->setY(20);
        $this->setX(80);

        $this->Cell(60, 4, 'AREASOLICITADA', 0, 1, 'C');

        $this->SetFont('Arial', 'B', 12);
        $this->setY(35);
        $this->setX(80);

        $this->Cell(60, 4, 'VALE DE PRESTAMOS DE MATERIALES', 0, 1, 'C');

        $this->SetFont('Arial', '', 10);
        $this->SetY(50);
        $this->SetX(10);


        /* $this->setY(70);
        $this->setX(50);
        $this->Cell(60, 4, 'Semestre:', 0, 1, 'C');*/

        // Salto de línea
        $this->SetFont('Arial', 'B', 10);
        $this->Ln(15);
        $this->SetX(20);



        $this->SetFont('Arial', 'B', 8);
        $this->SetX(15);

        $this->Cell(30, 10, 'N. Del. Material', 1, 0, 'C', 0);
        $this->Cell(17, 10, 'Cantidad', 1, 0, 'C', 0);
        $this->Cell(100, 10, 'Observaciones', 1, 0, 'C', 0);
        $this->Cell(30, 10, 'Fecha', 1, 1, 'C', 0);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);

        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(-80);
        $this->setX(-224);
        $this->Cell(60, 0, utf8_decode('Nota:'), 0, 1, 'C');

        $this->SetFont('Helvetica', '', 10);
        $this->Ln(20);
        $this->setY(-75);
        $this->setX(10);
        $this->MultiCell($this->GetPageWidth() - 20, 5, utf8_decode('El alumno tiene 5 días máximos desde que pide el material, para que lo devuelva.En caso de extravío o daño por mal uso que haga el solicitante del material y equipo será responsabilidad del mismo y deberá ser repuesto por un máximo de 6 días hábiles.
        '), 0, 'J');

        $this->SetFont('Helvetica', 'B', 7);
        $this->Ln(20);
        $this->setY(-30);
        $this->setX(18);
        $this->Cell(50, 0, '', 'T'); // DIVISION

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(-25);
        $this->setX(12);
        $this->Cell(60, 0, utf8_decode('Nombre y Firma'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(-20);
        $this->setX(12);
        $this->Cell(60, 0, utf8_decode('De quien recibe'), 0, 1, 'C');
        //Otra firma
        $this->SetFont('Helvetica', 'B', 7);
        $this->Ln(20);
        $this->setY(-30);
        $this->setX(140);
        $this->Cell(50, 0, '', 'T'); // DIVISION

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(-25);
        $this->setX(136);
        $this->Cell(60, 0, utf8_decode('Nombre y Firma'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(-20);
        $this->setX(136);
        $this->Cell(60, 0, utf8_decode('Del Responsable'), 0, 1, 'C');
    }
}

include "db.php";



extract($_POST);
$consulta = "SELECT pr.id, pr.id_profesor, pr.id_materia, pr.id_material, pr.fecha_slt, pr.fecha_fin,
pr.hora_in, pr.hora_fin, pr.cant, pr.status, pr.fecha_registrado,p.nombres, p.apellidos, m.materia, i.descripcion, i.unidad 
FROM prestamos pr INNER JOIN profesores p ON pr.id_profesor = p.id INNER JOIN materias m ON pr.id_materia = m.id 
INNER JOIN inventario i ON pr.id_material = i.id
WHERE pr.id = $id";
$resultado = mysqli_query($conexion, $consulta);


$pdf = new PDF();

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 0);
//$pdf->SetWidths(array(10, 30, 27, 27, 20, 20, 20, 20, 22));
while ($row = $resultado->fetch_assoc()) {

    $pdf->SetX(15);

    $pdf->Cell(30, 10, $row['descripcion'], 1, 0, 'C', 0);
    $pdf->Cell(17, 10, $row['cant'], 1, 0, 'C', 0);
    $pdf->Cell(100, 10, $row['id_material'], 1, 0, 'L', 0);
    $pdf->Cell(30, 10, $row['status'], 1, 1, 'C', 0);
}


$pdf->Output();
