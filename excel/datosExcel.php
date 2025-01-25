<?php 
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require '../BD/conexion.php';

$nombreArchivo='../excel/aceites.xlsx';

datosExcel();
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