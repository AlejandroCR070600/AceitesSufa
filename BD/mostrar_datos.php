<?php
require 'conexion.php';
session_start();
if ($conn -> connect_error){
    die("Error en la conexion".$conn->connect_error);
}

$sqlA="SELECT Cant_Aceites FROM aceites_Stock ORDER BY id DESC LIMIT 1";
$sql="SELECT * FROM control_aceites";
$sqlI="SELECT inicio FROM informe ORDER BY id DESC LIMIT 1";


$resultI = $conn->query($sqlI);
$result = $conn->query($sql);
$resultA = $conn->query($sqlA);

function cierreInforme($conn, $info) {


    // Verifica si el mensaje ya está establecido
    if (!isset($_SESSION['mensaje'])) {
        $dateHoy = date('Y-m-d');
        
        // Consulta preparada para actualizar la base de datos
        $stmt = $conn->prepare("UPDATE informe SET final = ? WHERE inicio = ?");
        $stmt->bind_param('ss', $dateHoy, $info);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Termino la factura";
        } else {
            $_SESSION['mensaje'] = "No se realizó el informe: " . $conn->error;
        }

        $stmt->close();

        // Redirigir solo si no hay bucle
        header("Location: /AceitesSufa/index.php");
        exit;
    }
}


    if($resultA && $resultA->num_rows>0){
    if($resultI->num_rows>0){


        $rowA= $resultA->fetch_assoc();
        $aceites_Stock=$rowA['Cant_Aceites'];
        
        if ($resultI && $resultI->num_rows > 0) {
            $rowI = $resultI->fetch_assoc();
            $info = $rowI['inicio'];
        }


        if($aceites_Stock>0){
            $aceites_Stock="Aceites disponibles: ".$rowA['Cant_Aceites'];
            
        }else{
           if($aceites_Stock==0){
            $aceites_Stock="Ya no  hay aceites prro";
            cierreInforme($conn, $info);
            
           }
        }  
    }
    }else{
            $aceites_Stock="tabla aceites_Stock vacia";
        } 
      


     


?>