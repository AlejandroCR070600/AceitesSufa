<?php
session_start();
require "./BD/conexion.php";
require '../excel/datosExcel.php';

class Aceite{
    public $id;
    public $Moto_Num;
    public $Cant_Aceites;
    public $fecha;

private function informeActual($conn){
      $sqlIdInfo = "SELECT * FROM informe ORDER BY id DESC LIMIT 1";
      $result=$conn->query($sqlIdInfo);
      if($result->num_rows>0){
        $row = $result->fetch_assoc();
        return [['id']=> $row['id'],'folio'=>$row['folio']];
      }else{
        return null;

      }
      
      
}

    public static function insert($conn){
        $Informe=informeActual($conn);
        $id_Informe=$Informe['id'];
        $folio=$Informe['folio'];
        $sql = "INSERT INTO control_aceites (Fecha, Moto_Num, Cant_Aceites, id_Informe, precio , folio) VALUES ('$fecha', $Moto_Num, $Cant_Aceites, $id_Informe, $Precio, '$folio')";
        $sqlIngresar = "INSERT INTO aceites_Stock (Cant_Aceites, Fecha_Aceites, Entrada, Salida) VALUES ($formulaR, '$fecha', 0, $aceites)";      
        
        if($conn->query($sql)=== TRUE){
            datosExcel();
            $_SESSION['mensaje'] = "Datos guardados correctamente.";
            header("Location: /AceitesSufa/index.php");
            exit;
        }
        else {
            $_SESSION['mensaje'] = "Error al guardar los datos.";
            header("Location: /AceitesSufa/index.php");
            exit;
        }
    }
}


?>