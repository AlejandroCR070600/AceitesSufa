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





if(isset($_GET['ing_Aceites'])){
    if(isset($_GET['ingresoAceites'])){
        $numIngreso=(int)$_GET['ingresoAceites'];
        $fechaHoy=date("Y-m-d");
        echo $fechaHoy;
        $formulaM=$numIngreso+$aceites_Stock;
        $sqlIngresar="INSERT INTO aceites_Stock(Cant_Aceites, Fecha_Aceites, Entrada, Salida) VALUES($formulaM, '$fechaHoy',$numIngreso,0 )";
        $sqlInforme="INSERT INTO informe (inicio) VALUES('$fechaHoy')";
        if($conn->query($sqlIngresar) === TRUE){
            if($conn->query($sqlInforme)){
                echo "Datos guardados correctamente.";
            header("Location: /AceitesSufa/index.php");
            exit;
            }
        }
        
        echo "<h1>". $numIngreso."</h1>";
        echo "<h1>".$aceites_Stock."</h1>";

        
        
        
    }
}










?>