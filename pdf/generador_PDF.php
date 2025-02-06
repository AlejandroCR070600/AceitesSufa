<?php
// Iniciar sesión
require "../BD/conexion.php"; // Archivo de conexión a la base de datos
require('fpdf.php'); // Librería FPDF
date_default_timezone_set('America/Mexico_City');

$FechaInforme = date("Y-m-d"); // Fecha actual por defecto

if (isset($_POST['submitInforme']) && isset($_POST['select_Informe'])) {
    $FechaInforme = $_POST['select_Informe']; // Fecha de inicio del informe
}

// 🔹 1️⃣ Obtener el ID del informe basado en la fecha de inicio
$sqlInforme = "SELECT * FROM informe WHERE inicio = ?";
$stmtInforme = $conn->prepare($sqlInforme);
$stmtInforme->bind_param('s', $FechaInforme);
$stmtInforme->execute();
$resultInforme = $stmtInforme->get_result();

if ($resultInforme->num_rows > 0) {
    $informe = $resultInforme->fetch_assoc();
    $idInforme = $informe['id']; // Obtener el ID del informe
} else {
    die("No se encontró un informe con la fecha proporcionada.");
}

// 🔹 2️⃣ Obtener datos de `control_aceites` filtrando por `id_Informe`
$sql = "SELECT Moto_Num, SUM(Cant_Aceites) AS Total_Aceites, SUM(precio) as Precio
        FROM control_aceites 
        WHERE id_Informe = ?
        GROUP BY Moto_Num"; // Agrupar por Moto_Num

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $idInforme);
$stmt->execute();
$result = $stmt->get_result();

// 🔹 3️⃣ Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Cabecera del reporte
$pdf->Cell(180, 10, 'Reporte de Motos y Aceites', 0, 1, 'C');
$pdf->Cell(180, 10,"folio: ". $informe['folio'], 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(10); // Espaciado

// Calculamos el ancho total de la tabla
$anchoTotalTabla = 180; // 3 columnas de 60mm

// Calculamos el espacio que debe haber a la izquierda para centrar la tabla
$espacioIzquierda = (210 - $anchoTotalTabla) / 2; // 210mm es el ancho total de la página A4

// Mover el cursor X a la posición centrada
$pdf->SetX($espacioIzquierda);

// Encabezados de la tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 10, 'Numero de Moto', 1, 0, 'C');
$pdf->Cell(60, 10, 'Cantidad Total de Aceites', 1, 0, 'C');
$pdf->Cell(60, 10, 'Gasto', 1, 1, 'C');

// Iterar por cada fila y mostrar resultados
$pdf->SetFont('Arial', '', 12);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->SetX($espacioIzquierda); // Volver a centrar cada fila
        $pdf->Cell(60, 10, $row['Moto_Num'], 1, 0, 'C');
        $pdf->Cell(60, 10, $row['Total_Aceites'], 1, 0, 'C');
        $pdf->Cell(60, 10, "$".$row['Precio'], 1, 1, 'C');
    }
    // Generar el PDF para descarga
    $pdf->Output('D', 'Reporte_Motos.pdf');
} else {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(180, 10, 'No se encontraron datos para este informe.', 0, 1, 'C');
    $pdf->Output('D', 'Reporte_Vacio.pdf');
}

// 🔹 4️⃣ Cerrar conexiones
$stmt->close();
$stmtInforme->close();
$conn->close();

?>
