<?php
session_start(); // Inicia la sesión

require 'conexion.php';
require 'aceites_Disponibles.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = $_POST['fecha'];
    $num_moto = $_POST['Num_Moto'];
    $aceites = $_POST['Aceites'];
    $formulaR = $aceites_Stock - $aceites;
    agregar_datos($fecha, $num_moto, $aceites, $formulaR, $conn, $aceites_Stock);
}

function agregar_datos($fecha, $num_moto, $aceites, $formulaR, $conn, $aceites_Stock){

    
    if ($aceites_Stock > 0) {
        $sql = "INSERT INTO control_aceites (Fecha, Moto_Num, Cant_Aceites) VALUES ('$fecha', $num_moto, $aceites)";
        $sqlIngresar = "INSERT INTO aceites_Stock (Cant_Aceites, Fecha_Aceites, Entrada, Salida) VALUES ($formulaR, '$fecha', 0, $aceites)";
        

        if ($conn->query($sql) === TRUE) {
            if ($conn->query($sqlIngresar)) {
                $_SESSION['mensaje'] = "Datos guardados correctamente.";
                header("Location: /AceitesSufa/index.php");
                exit;
            }
        } else {
            $_SESSION['mensaje'] = "Error al guardar los datos.";
            header("Location: /AceitesSufa/index.php");
            exit;
        }
    } else {
        $_SESSION['mensaje'] = "Aceites insuficientes.";
        header("Location: /AceitesSufa/index.php");
        exit;
    }
}
?>
