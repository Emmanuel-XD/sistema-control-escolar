<?php
require('../fpdf/fpdf.php');

// Clase extendida de FPDF para crear el documento PDF
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Detalles de la Solicitud', 0, 1, 'C');
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtén los datos enviados a través de POST
    $data = $_POST;

    // Crear el objeto PDF
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    // Agregar los datos al PDF
    $pdf->Cell(0, 10, 'Material Solicitado: ' . $data['descripcion'], 0, 1);
    $pdf->Cell(0, 10, 'Cantidad: ' . $data['cant'], 0, 1);
    $pdf->Cell(0, 10, 'Fecha de Prestamo: ' . $data['fecha_slt'], 0, 1);
    $pdf->Cell(0, 10, 'Fecha de Devolucion: ' . $data['fecha_fin'], 0, 1);
    $pdf->Cell(0, 10, 'Clase en Uso: ' . $data['materia'], 0, 1);
    $pdf->Cell(0, 10, 'Hora de Inicio: ' . $data['hora_in'], 0, 1);
    $pdf->Cell(0, 10, 'Hora de Regreso: ' . $data['hora_fin'], 0, 1);
    $pdf->Cell(0, 10, 'Personal Escolar: ' . $data['nombres'], 0, 1);
    $pdf->Cell(0, 10, 'Estado: ' . $data['status'], 0, 1);

    // Generar el PDF
    $pdf->Output();
} else {
    die('Solicitud no válida');
}

