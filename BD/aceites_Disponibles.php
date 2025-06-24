<?php
require "conexion.php";
$numIngreso=0;
$sqlA="SELECT Cant_Aceites FROM aceites_Stock ORDER BY id DESC LIMIT 1";
$resultA=$conn->query($sqlA);




if($resultA && $resultA->num_rows>0){
$row= $resultA->fetch_assoc();
$aceites_Stock=$row['Cant_Aceites'];

}else{
    $aceites_Stock=0;
}
header("Content-Type: application/json");

$value=json_decode(file_get_contents("php://input"), true);


        

    if($value[2]==="ingresarAceites"){
        
        $numIngreso=(int)$value[0];
        $folio=$value[1];
        $fechaHoy=date("Y-m-d");
        $formulaM=$numIngreso+$aceites_Stock;
        $sqlIngresar="INSERT INTO aceites_Stock(Cant_Aceites, Fecha_Aceites, Entrada, Salida) VALUES($formulaM, '$fechaHoy',$numIngreso,0 )";
        $sqlInforme="INSERT INTO informe (inicio, folio) VALUES('$fechaHoy', '$folio')";
        if($conn->query($sqlIngresar) === TRUE){
            if($conn->query($sqlInforme)){
                echo json_encode("datos guardados correctamente");
        
            }
        }        
    }else{
                echo json_encode("no se encuentra el boton");
    }

    











?>