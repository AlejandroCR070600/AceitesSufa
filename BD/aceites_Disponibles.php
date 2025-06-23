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

$value=json_decode(file_get_contents("php://input"), true);


json_encode($value["btn"]);




    











?>