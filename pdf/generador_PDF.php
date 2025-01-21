<?php
require "../BD/conexion.php";
require('fpdf.php');

$sql = "SELECT Moto_Num as 'Numero de moto', SUM(Cant_Aceites) AS 'total Aceites' FROM control_aceites GROUP BY Moto_Num ORDER BY Moto_Num;";
$result = $conn->query($sql);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16); // Usamos Arial en lugar de Helvetica

if ($result->num_rows > 0) {
    $pdf->Cell(90, 10, 'Numero de Moto', 1, 0, 'C');
    $pdf->Cell(90, 10, 'Total Aceites', 1, 1, 'C');

    // Iterar por cada fila y mostrar resultados
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(90, 10, $row['Numero de moto'], 1, 0, 'C');
        $pdf->Cell(90, 10, $row['total Aceites'], 1, 1, 'C');
    }
    $pdf->Output('D', 'Reporte_Motos.pdf');
}
?>
