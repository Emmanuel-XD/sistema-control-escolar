<?php

require('../fpdf/fpdf.php');
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

        $this->Cell(70, 10, 'COMPROBANTE DE PAGO ', 0, 1, 'C');

        include "db.php";
        $consulta = "SELECT * FROM settings";
        $sql = mysqli_query($conexion, $consulta);
        if ($sql->num_rows > 0) {
            foreach ($sql as $key => $celda) {
            }
        }

        $this->image($celda['imagen'], 5, 4, 35);  // X, Y, Tamaño

        $this->SetFont('Arial', '', 11);
        $this->setY(33);
        $this->setX(140);
        $this->Cell(60, 4,  utf8_decode($celda['instituto']), 0, 1, 'R');

        $this->SetFont('Arial', '', 11);
        $this->setY(38);
        $this->setX(131);
        $this->Cell(60, 4, utf8_decode('Clave ' . $celda['clave']), 0, 1, 'R');

        $this->SetFont('Arial', '', 11);
        $this->setY(43);
        $this->setX(134);
        $this->Cell(60, 4, utf8_decode($celda['direccion']), 0, 1, 'R');

        include "db.php";
        extract($_GET);
        $consulta = "SELECT p.id, p.descuento, p.pago, p.fecha, a.matricula, a.nombre, a.apellido,a.beca, g.descripcion, c.cargo, c.monto
        FROM pagos p INNER JOIN alumnos a ON p.id_alumno = a.id INNER JOIN grados g ON p.id_grado = g.id INNER JOIN cargos c 
        ON p.id_cargo = c.id WHERE p.id = $id;";

        $sql = mysqli_query($conexion, $consulta);
        if ($sql->num_rows > 0) {
            foreach ($sql as $key => $filas) {
            }
        }
        $this->SetFont('Arial', '', 10);
        $this->SetY(60);
        $this->SetX(12.5);
        $this->Cell(60, 4, 'Matricula: ' . utf8_decode($filas['matricula']), 0, 1, 'L');

        $this->SetFont('Arial', '', 10);
        $this->SetY(65);
        $this->SetX(12.5);
        $this->Cell(60, 4, 'Tipo de Cargo: ' . utf8_decode($filas['cargo']), 0, 1, 'L');

        $this->SetFont('Arial', '', 10);
        $this->SetY(70);
        $this->SetX(12.5);
        $this->Cell(60, 4, 'Fecha de Impresion: ' . utf8_decode($fecha = date("Y-m-d ")), 0, 1, 'L');


        // Salto de línea
        $this->SetFont('Arial', 'B', 10);
        $this->Ln(10);
        $this->SetX(20);


        $this->Ln(3);
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(12);

        $this->Cell(55, 10, 'ESTUDIANTE', 0, 0, 'L', 0);
        $this->Cell(45, 10, 'FECHA PAGADO', 0, 0, 'L', 0);
        $this->Cell(40, 10, 'GRADO - GRUPO', 0, 0, 'L', 0,);
        $this->Cell(20, 10, 'BECA', 0, 0, 'L', 0,);
        $this->Cell(20, 10, 'IMPORTE', 0, 1, 'L', 0);
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
        $this->setY(200);
        $this->setX(18);
        $this->Cell(50, 0, '', 'T'); // DIVISION

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(205);
        $this->setX(12);
        $this->Cell(60, 0, utf8_decode('RECIBE'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(210);
        $this->setX(12);
        $this->Cell(60, 0, utf8_decode('NOMBRE Y FIRMA '), 0, 1, 'C');

       
        //Otra firma
        $this->SetFont('Helvetica', 'B', 7);
        $this->Ln(20);
        $this->setY(200);
        $this->setX(140);
        $this->Cell(50, 0, '', 'T'); // DIVISION

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(205);
        $this->setX(136);
        $this->Cell(60, 0, utf8_decode('ENTREGA'), 0, 1, 'C');

        $this->SetFont('Helvetica', 'B', 10);
        $this->Ln(20);
        $this->setY(210);
        $this->setX(136);
        $this->Cell(60, 0, utf8_decode('NOMBRE Y FIRMA'), 0, 1, 'C');
        //$this->SetFillColor(223, 229,235);
        //$this->SetDrawColor(181, 14,246);
        //$this->Ln(0.5);
    }
}
include "db.php";
$id = $_GET['id'];

$consulta = "SELECT p.id, p.descuento, p.pago, p.fecha, a.matricula, a.nombre, a.apellido,a.beca, g.descripcion, c.cargo, c.monto
FROM pagos p INNER JOIN alumnos a ON p.id_alumno = a.id INNER JOIN grados g ON p.id_grado = g.id INNER JOIN cargos c 
ON p.id_cargo = c.id WHERE p.id = $id;";
$resultado = mysqli_query($conexion, $consulta);

$pdf = new PDF();

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 0);
//$pdf->SetWidths(array(10, 30, 27, 27, 20, 20, 20, 20, 22));
while ($row = $resultado->fetch_assoc()) {

    $pdf->SetX(12);

    $pdf->Cell(55, 10,  $row['nombre'] . ' ' . $row['apellido'], 1, 0, 'L', 0);
    $pdf->Cell(45, 10, $row['fecha'], 1, 0, 'L', 0);
    $pdf->Cell(40, 10, $row['descripcion'], 1, 0, 'L', 0);
    $pdf->Cell(20, 10, $row['beca'] . '%', 1, 0, 'L', 0);
    $pdf->Cell(20, 10, '$' . $row['monto'], 1, 1, 'L', 0);

    $pdf->SetFont('Arial', 'B', 12.5);

    $pdf->setY(130);
    $pdf->setX(145);
    $pdf->Cell(60, 4, 'SUBTOTAL: $' . $row['monto'] . ' MXN', 0, 1, 'C');

    $pdf->setY(140);
    $pdf->setX(141);
    $pdf->Cell(60, 4, 'TOTAL: $' . $row['pago'] . ' MXN', 0, 1, 'C');
}
/////////////////////////////

$pdf->SetFont('Arial', 'B', 10);
$pdf->setY(235);
$pdf->setX(-190);
$pdf->Cell(60, 4, "CONDICIONES Y FORMA DE PAGO");

$pdf->SetFont('Arial', 'B', 9);
$pdf->setY(245);
$pdf->setX(-190);
$pdf->Cell(60, 4, "El pago se realizara en el periodo establecido por el instituto.");

$pdf->SetFont('Arial', 'B', 9);
$pdf->setY(255);
$pdf->setX(-190);
$pdf->Cell(60, 4, "Metodo de pago: En efectivo o transferencia bancaria.");




$pdf->Output(utf8_decode($fecha) . '_Recibo.pdf', 'i');
