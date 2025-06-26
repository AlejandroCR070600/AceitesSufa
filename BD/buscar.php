<?php
require "conexion.php";
$value=json_decode(file_get_contents("php://input"),true);

if($value["btn"]==="buscar"){
  
    $folio=$value["folio"];
    $buscar=$value["buscar"];
    $datos=[];
    $sql="SELECT * from control_aceites where ?=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("ss", $folio,$buscar);
    $stmt->execute();
    $result=$stmt->get_result();

    if($result->num_rows<0){
       
         while($row=$result->fetch_assoc()){
            $datos[]=$row;
        }
        echo json_encode([
            'datos'=>$datos,
        ]);

    }else{
           echo json_encode([
            'datos'=>"no hay datos",
            
        ]);
    }

    
}



?>