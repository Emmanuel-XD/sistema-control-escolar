<?php

session_start();
error_reporting(0);

date_default_timezone_set('America/Mexico_City');
$fecha = date("Y-m-d ");

extract($_GET);


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
        include("db.php");
        $consulta = mysqli_query($conexion, "SELECT * FROM settings ");

        while ($fila = mysqli_fetch_array($consulta)) {
            $this->SetFont('Arial', 'B', 14);
            $this->setY(10);
            $this->SetX(75);

            $this->image($fila['imagen'], 5, 4, 40);  // X, Y, Tamaño
            // $this->image('./img/sistemas.png', 170, 0, 50);  // X, Y, Tamaño

            $this->Cell(70, 10,  utf8_decode($fila['instituto']), 0, 1, 'C');

            $this->SetFont('Arial', '', 10);
            $this->setY(20);
            $this->setX(80);

            $this->Cell(60, 4,  utf8_decode($fila['direccion']), 0, 1, 'C');
        }
        $this->SetFont('Arial', 'B', 12);
        $this->setY(35);
        $this->setX(80);

        $this->Cell(60, 4, 'VALE DE PRESTAMOS DE MATERIALES', 0, 1, 'C');

        $this->SetFont('Arial', '', 10);
        $this->SetY(50);
        $this->SetX(10);

        extract($_GET);
        include "db.php";
        $consulta = "SELECT pr.id, pr.id_profesor, pr.id_materia, pr.id_material, pr.fecha_slt, pr.fecha_fin,pr.fecha_registrado,
        pr.hora_in, pr.hora_fin, pr.cant, pr.status, pr.fecha_registrado,p.nombres, p.apellidos, m.materia, i.descripcion, i.unidad, 
        g.descripcion AS grado FROM prestamos pr INNER JOIN profesores p ON pr.id_profesor = p.id INNER JOIN materias m ON pr.id_materia = m.id 
        INNER JOIN inventario i ON pr.id_material = i.id INNER JOIN grados g ON m.id_grado = g.id WHERE pr.id = $id";
        $resultado = mysqli_query($conexion, $consulta);
        $fila = mysqli_fetch_assoc($resultado);
        $this->Cell(60, 4, 'Nombre del Solicitante: ' . utf8_decode($fila['nombres'] . ' ' . $fila['apellidos']), 0, 1, 'L');

        $this->setY(57);
        $this->setX(10);
        $this->Cell(60, 4, 'Clase Solicitada: ' . utf8_decode($fila['materia'] . ' - ' . $fila['grado']), 0, 1, 'L');


        $this->setY(65);
        $this->setX(10);
        $this->Cell(60, 4, 'Fecha Registrada: ' . utf8_decode($fila['fecha_registrado']), 0, 1, 'L');

        /* $this->setY(70);
        $this->setX(50);
        $this->Cell(60, 4, 'Semestre:', 0, 1, 'C');*/

        // Salto de línea
        $this->SetFont('Arial', 'B', 10);
        $this->Ln(15);
        $this->SetX(10);



        $this->SetFont('Arial', 'B', 8);
        $this->SetX(12);

        $this->Cell(14, 10, '#ID', 0, 0, 'L', 0);
        $this->Cell(43, 10, 'Material Solicitado', 0, 0, 'L', 0);
        $this->Cell(20, 10, 'Cant', 0, 0, 'L', 0);
        $this->Cell(25, 10, 'Fecha Solicitada', 0, 0, 'L', 0);
        $this->Cell(25, 10, 'Fecha Devuelta', 0, 0, 'L', 0);
        $this->Cell(25, 10, 'Hora Inicio', 0, 0, 'L', 0);
        $this->Cell(20, 10, 'Hora Fin', 0, 0, 'L', 0);
        $this->Cell(30, 10, 'Estado', 0, 1, 'L', 0);
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
        $this->Cell(60, 0, utf8_decode('NOTA:'), 0, 1, 'C');

        $this->SetFont('Helvetica', '', 10);
        $this->Ln(20);
        $this->setY(-75);
        $this->setX(10);
        $this->MultiCell($this->GetPageWidth() - 20, 5, utf8_decode('El solicitante tiene 5 días máximos desde que pide el material, para que lo devuelva. En caso de extravío o daño por mal uso que haga el solicitante del material y equipo será responsabilidad del mismo y deberá ser repuesto por un máximo de 6 días hábiles.
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
        $this->Cell(60, 0, utf8_decode('Del Solicitante'), 0, 1, 'C');
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



extract($_GET);
$id = $_GET['id'];
$consulta = "SELECT pr.id, pr.id_profesor, pr.id_materia, pr.id_material, pr.fecha_slt, pr.fecha_fin,
pr.hora_in, pr.hora_fin, pr.cant, pr.status, pr.fecha_registrado,p.nombres, p.apellidos, m.materia, i.descripcion, i.unidad 
FROM prestamos pr INNER JOIN profesores p ON pr.id_profesor = p.id INNER JOIN materias m ON pr.id_materia = m.id 
INNER JOIN inventario i ON pr.id_material = i.id WHERE pr.id = $id";
$resultado = mysqli_query($conexion, $consulta);


$pdf = new PDF();

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 0);
//$pdf->SetWidths(array(10, 30, 27, 27, 20, 20, 20, 20, 22));
while ($row = $resultado->fetch_assoc()) {

    $pdf->SetX(12);


    $pdf->Cell(14, 10, $row['id'], 0, 0, 'L', 0);
    $pdf->Cell(43, 10, $row['descripcion'], 0, 0, 'L', 0);
    $pdf->Cell(20, 10, $row['cant'] . '-' . $row['unidad'], 0, 0, 'L', 0);
    $pdf->Cell(25, 10, $row['fecha_slt'], 0, 0, 'L', 0);
    $pdf->Cell(25, 10, $row['fecha_fin'], 0, 0, 'L', 0);
    $pdf->Cell(25, 10, $row['hora_in'], 0, 0, 'L', 0);
    $pdf->Cell(20, 10, $row['hora_fin'], 0, 0, 'L', 0);
    $pdf->Cell(30, 10, $row['status'], 0, 1, 'L', 0);
}


$pdf->Output();
