<?php
require 'conexion.php';
if ($conn -> connect_error){
    die("Error en la conexion".$conn->connect_error);
}
$sqlA="SELECT Cant_Aceites FROM aceites_Stock ORDER BY id DESC LIMIT 1";
$sql="SELECT * FROM control_aceites";
$result = $conn->query($sql);
$resultA = $conn->query($sqlA);


    if($resultA && $resultA->num_rows>0){
        $rowA= $resultA->fetch_assoc();
        $aceites_Stock=$rowA['Cant_Aceites'];
        if($aceites_Stock>0){
            $aceites_Stock="Aceites disponibles: ".$rowA['Cant_Aceites'];
        }else{
            $aceites_Stock="Ya no hay aceites prro";
        }  
    }else{
            $aceites_Stock="tabla aceites_Stock vacia";
        } 



?>