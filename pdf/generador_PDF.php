<?php
// Iniciar sesión
require "../BD/conexion.php"; // Archivo de conexión a la base de datos
require('fpdf.php'); // Librería FPDF
$FechaInforme = date("Y-m-d");

if (isset($_POST['submitInforme'])) {
    if (isset($_POST['select_Informe'])) {
        $FechaInforme = $_POST['select_Informe'];
    }
}

// Consulta para obtener las fechas de inicio y final del informe
$sqlInforme = "SELECT * FROM informe WHERE inicio = ?";
$stmtInforme = $conn->prepare($sqlInforme);
$stmtInforme->bind_param('s', $FechaInforme); // Usar la fecha del informe
$stmtInforme->execute();
$resultInforme = $stmtInforme->get_result();

if ($resultInforme->num_rows > 0) {
    $informe = $resultInforme->fetch_assoc();
    $fechaInicio = $informe['inicio'];
    $fechaFinal = $informe['final'];
    $idInforme = $informe['id'];
} else {
    die("No se encontró el informe con el ID proporcionado.");
}

// Consulta para obtener los datos agrupados por Moto_Num
$sql = "SELECT e.Moto_Num, SUM(e.Cant_Aceites) AS Total_Aceites 
        FROM control_aceites e 
        JOIN informe i ON e.Fecha BETWEEN i.inicio AND i.final 
        WHERE i.inicio = ?
        GROUP BY e.Moto_Num"; // Agrupar por el número de moto

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $FechaInforme); // Usar la fecha del informe
$stmt->execute();
$result = $stmt->get_result();

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Cabecera del reporte
$pdf->Cell(180, 10, 'Reporte de Motos y Aceites', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);

$pdf->Ln(10); // Espaciado

if ($result->num_rows > 0) {
    // Encabezados de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(90, 10, 'Numero de Moto', 1, 0, 'C');
    $pdf->Cell(90, 10, 'Cantidad Total de Aceites', 1, 1, 'C');

    // Iterar por cada fila y mostrar resultados
    $pdf->SetFont('Arial', '', 12);
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(90, 10, $row['Moto_Num'], 1, 0, 'C');
        $pdf->Cell(90, 10, $row['Total_Aceites'], 1, 1, 'C');
    }

    // Generar el PDF para descarga
    $pdf->Output('D', 'Reporte_Motos.pdf');
} else {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(180, 10, 'No se encontraron datos para este informe.', 0, 1, 'C');
    $pdf->Output('D', 'Reporte_Vacio.pdf');
}

// Cerrar conexión y declaración
$stmt->close();
$stmtInforme->close();
$conn->close();
?>
