<?php
date_default_timezone_set('America/Mexico_City');
$conn = new mysqli("localhost", "root", "", "aceites");
if($conn->connect_error){
    die("conexión fallida: " . $conn->connect_error);
}


?>