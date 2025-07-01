<?php

use PhpOffice\PhpSpreadsheet\Calculation\Information\Value;
require 'conexion.php';
require '../excel/datosExcel.php';

header("Content-Type: application/json");

$sqlA="SELECT Cant_Aceites FROM aceites_Stock ORDER BY id DESC LIMIT 1";
$resultA=$conn->query($sqlA);




if($resultA && $resultA->num_rows>0){
$row= $resultA->fetch_assoc();
$aceites_Stock=$row['Cant_Aceites'];

}else{
    $aceites_Stock=0;
}
$value=json_decode(file_get_contents("php://input"), true);


if ($value[0]==="vacio") {

    $datoJS=["mensaje" => "No se ingreso nada en el campo de ACEITES"];
    echo json_encode($datoJS);
    exit;
    
}else{
    if($value[1]==="vacio"){

        $datoJS=["mensaje" => "No se ingreso nada en el campo de NUMERO DE MOTO"];
        echo json_encode($datoJS);
        exit;

    }else{
        if($value[2]==="vacio"){

            $datoJS=["mensaje" => "No se ingreso nada en el campo de Fecha"];
            echo json_encode($datoJS);
            exit;

        }else{

            $fecha = $value[2];
            $num_moto = $value[1];
            $aceites = $value[0];
            $Precio= 95;
            $formulaR = $aceites_Stock - $aceites;
         
            agregar_datos($fecha, $num_moto, $aceites, $formulaR, $conn, $aceites_Stock, $Precio);
        }
    }

}

function tablaInforme($conn) {
    $sqlIdInfo = "SELECT * FROM informe ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sqlIdInfo);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return ['id' => $row['id'], 'folio' => $row['folio']];
    }

    return null; // En caso de que no haya resultados
}

function agregar_datos($fecha, $num_moto, $aceites, $formulaR, $conn, $aceites_Stock, $Precio){

    
    if ($aceites_Stock > 0) {
        $tablaInforme= tablaInforme($conn);
        $id_Informe=$tablaInforme['id'];
        $folio=$tablaInforme['folio'];
        $sql = "INSERT INTO control_aceites (Fecha, Moto_Num, Cant_Aceites, id_Informe, precio , folio) VALUES ('$fecha', $num_moto, $aceites, $id_Informe, $Precio, '$folio')";
        $sqlIngresar = "INSERT INTO aceites_Stock (Cant_Aceites, Fecha_Aceites, Entrada, Salida) VALUES ($formulaR, '$fecha', 0, $aceites)";
        $datoJS=[];
       

        if ($conn->query($sql)) {
            if ($conn->query($sqlIngresar)) {
                $mensajeExcel=datosExcel();
               // al final del archivo:
               $datoJS=["mensaje" => "SE AGREGO CORRECTAMENTE", "excel"=>$mensajeExcel];
                echo json_encode($datoJS);
                

            }
        } else {
            $datoJS=["mensaje" => "ERROR AL GUARDAR LOS DATOS"];
// al final del archivo:
                echo json_encode($datoJS);

        }
    } else {
        $datoJS=["mensaje" => "ACEITES INSUFICIENTES"];
              // al final del archivo:
                echo json_encode($datoJS);

    }
}
?>