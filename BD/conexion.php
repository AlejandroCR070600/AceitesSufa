<?php
$conn = new mysqli("localhost", "root", "", "aceites");
if($conn->connect_error){
    die("conexión fallida: " . $conn->connect_error);
}


?>