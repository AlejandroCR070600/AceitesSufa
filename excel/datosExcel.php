<?php 
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require '../BD/conexion.php';

$nombreArchivo='../excel/aceites.xlsx';
if (isset($_POST['actualizar'])) {
    ActualizarDatosExcel(); // Llamar la función PHP
    header("Location: /AceitesSufa/index.php");
}


function datosExcel(){
    global $conn;
    global $nombreArchivo;
if(!file_exists($nombreArchivo)){
    die("El archivo $nombreArchivo no existe");
}
//obtiene el ultimo valor de la fila id en excel
$spreadsheet = IOFactory::load($nombreArchivo);
$sheet = $spreadsheet->getActiveSheet();
$ultimaFila = $sheet->getHighestRow();
$id2 = $sheet->getCell('A' . $ultimaFila)->getValue();


$sql=$sqlA="SELECT id FROM control_aceites ORDER BY id DESC LIMIT 1";
$result=$conn->query($sql);

if($result->num_rows>0){
    $row=$result->fetch_assoc();
        $id1=$row['id'];
        validarID($id1, $id2);
}
}




function validarID($id1, $id2){
if($id1!=$id2){
    agregarDatosExcel();
}else{
    echo 'no puede agregar datos, ya que el ultimo id es igual al id proporcionado';
}
}
function obtenerDatosExcel(){
    global $conn;
    global $nombreArchivo;

    $spreadsheet = IOFactory::load($nombreArchivo);

    $sheet=$spreadsheet->getActiveSheet();

    $dataFromExcel=[];
    foreach($sheet->getRowIterator() as $row){
        $rowData=[];
        foreach($row->getCellIterator() as $cell){
            $rowData[] =$cell->getValue();
        }
        $dataFromExcel[]=$rowData;
    }
    var_dump($dataFromExcel);
}

function obtenerBaseDatos(){
   global $conn;
   
$sql=("SELECT * FROM control_aceites");
$result=$conn->query($sql);
$dataFromDatabase=[];
if($result->num_rows>0){
    while($row=$result-> fetch_assoc()){
        $dataFromDatabase[]=$row;
    }
}
return $dataFromDatabase;
}



function eliminarDatosExcel($id) {
    global $nombreArchivo;

    $spreadsheet = IOFactory::load($nombreArchivo);
    $sheet = $spreadsheet->getActiveSheet();

    $highestRow = $sheet->getHighestRow(); // Última fila con datos

    for ($row = 2; $row <= $highestRow; $row++) { // Asumiendo que la primera fila es el encabezado
        $cellValue = $sheet->getCell("A" . $row)->getValue(); // Columna A contiene el ID
        if ($cellValue == $id) {
            $sheet->removeRow($row); // Eliminar la fila del Excel
            break;
        }
    }

    // Guardar el archivo actualizado
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($nombreArchivo);
}


function ActualizarDatosExcel(){
    global $nombreArchivo;
    $dataFromDatabase=obtenerBaseDatos();
    // Volver a cargar los datos del Excel (después de modificaciones)
$spreadsheet = IOFactory::load($nombreArchivo);
$sheet = $spreadsheet->getActiveSheet();

// Limpiar el contenido actual del archivo Excel
$sheet->removeRow(2, $sheet->getHighestDataRow() - 1); // Eliminar todas las filas excepto la cabecera

// Escribir los datos actualizados
$rowIndex = 2; // Empezar desde la fila 2 (la primera fila es para los encabezados)
foreach ($dataFromDatabase as $row) {
    $sheet->setCellValue('A' . $rowIndex, $row['id']);
    $sheet->setCellValue('B' . $rowIndex, $row['Fecha']);
    $sheet->setCellValue('C' . $rowIndex, $row['Moto_Num']);
    $sheet->setCellValue('D' . $rowIndex, $row['Cant_Aceites']);
    $rowIndex++;
}

// Guardar el archivo Excel actualizado
$writer = new Xlsx($spreadsheet);
$writer->save($nombreArchivo);
}



function agregarDatosExcel(){
    global $conn;
    global $nombreArchivo;



$spreadsheet=IOFactory::load($nombreArchivo);
$sheet=$spreadsheet->getActiveSheet();
$sql="SELECT * FROM control_aceites ORDER BY id DESC LIMIT 1";
$result=$conn->query($sql);

if($result->num_rows>0){
    $ultimaFila=$sheet->getHighestRow() + 1;
    while($row=$result->fetch_assoc()){
        $sheet->setCellValue("A$ultimaFila",$row['id']);
        $sheet->setCellValue("B$ultimaFila",$row['Fecha']);
        $sheet->setCellValue("C$ultimaFila",$row['Moto_Num']);
        $sheet->setCellValue("D$ultimaFila",$row['Cant_Aceites']);
        $ultimaFila++;
    }

    $writer=new Xlsx($spreadsheet);
    $writer->save($nombreArchivo);
    echo"los datos se guardaron correctamente";

}else{
    echo"no hay datos en la base de datos";
}
}

?>