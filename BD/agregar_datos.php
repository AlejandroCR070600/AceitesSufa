<?php


require 'conexion.php';




if($_SERVER['REQUEST_METHOD']==='POST'){
$fecha = $_POST['fecha'];
$num_moto = $_POST['Num_Moto'];
$aceites = $_POST['Aceites'];
$cant_motos = $_POST['Cant_Motos'];


$sql="INSERT INTO control_aceites(Fecha, Moto_Num, Cant_Aceites, Cant_Motos) VALUES ('$fecha', $num_moto, $aceites, $cant_motos)";


  if ($conn->query($sql) === TRUE) {
    echo "Datos guardados correctamente.";
    header("Location: /AceitesSufa/index.php");

    
    exit;

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


}

?>