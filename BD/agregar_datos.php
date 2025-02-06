<?php
session_start(); // Inicia la sesión

require 'conexion.php';
require 'aceites_Disponibles.php';
require '../excel/datosExcel.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = $_POST['fecha'];
    $num_moto = $_POST['Num_Moto'];
    $aceites = $_POST['Aceites'];
    $Precio= 95;
    $formulaR = $aceites_Stock - $aceites;
    agregar_datos($fecha, $num_moto, $aceites, $formulaR, $conn, $aceites_Stock, $Precio);
    
}

function obtenerIdInforme($conn){
    $sqlIdInfo="SELECT id FROM informe ORDER BY id DESC LIMIT 1";
    $result=$conn->query($sqlIdInfo);
    if($result->num_rows>0){
        $row=$result->fetch_assoc();
        $id_Informe=$row['id'];
        return $id_Informe;
    }

    
}

function agregar_datos($fecha, $num_moto, $aceites, $formulaR, $conn, $aceites_Stock, $Precio){

    
    if ($aceites_Stock > 0) {
        $id_Informe= obtenerIdInforme($conn);
        $sql = "INSERT INTO control_aceites (Fecha, Moto_Num, Cant_Aceites, id_Informe, precio) VALUES ('$fecha', $num_moto, $aceites, $id_Informe, $Precio)";
        $sqlIngresar = "INSERT INTO aceites_Stock (Cant_Aceites, Fecha_Aceites, Entrada, Salida) VALUES ($formulaR, '$fecha', 0, $aceites)";
        

        if ($conn->query($sql) === TRUE) {
            if ($conn->query($sqlIngresar)) {
                datosExcel();
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
