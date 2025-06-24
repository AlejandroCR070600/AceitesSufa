<?php
require "conexion.php";
$variable1="Fecha";
$variable2="2025-01-12";
$sql="SELECT * from control_aceites where ?=?";
$stmt=$conn->prepare($sql);
$stmt->bind_param("ss", $variable1,$variable2);
$stmt->execute();
$result=$stmt->get_result();

if($result->num_rows<0){
echo"hola";
}


?>