<?php
require 'conexion.php';
if ($conn -> connect_error){
    die("Error en la conexion".$conn->connect_error);
}
$sql="SELECT id, Fecha, Moto_Num, Cant_Aceites, Cant_Motos FROM control_aceites";
$result = $conn->query($sql);


?>