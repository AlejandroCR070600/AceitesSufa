<?php
require "conexion.php";




if($value&& isset($value['folio'])){
    $table_Date=$value['folio'];
}else{
    $table_Date=LastFolio();
}


    

    






function folios(){
    global $conn;
$sql="SELECT folio from informe";
$result=$conn->query($sql);
$folio=[];
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $folio[]=$row['folio'];
    }
    
}
return $folio;
}

function aceites_Sotck(){
    global $conn;
    $sql="SELECT Cant_Aceites from aceites_stock order by id desc limit 1";
    $result=$conn->query($sql);

    if($result->num_rows>0){
        $row=$result->fetch_assoc();
        return $row['Cant_Aceites'];
    }
}








function LastFolio(){
    global $conn;
    $sqlF="SELECT FOLIO FROM INFORME ORDER BY ID DESC LIMIT 1";
    $resultF=$conn->query($sqlF);

    if($resultF->num_rows>0){
        $row=$resultF->fetch_assoc();
        return $row['FOLIO'];
        


    }
}




function Show_Datos($lastFolio){
    global $conn;
    
    $sql="SELECT * FROM control_aceites WHERE folio='$lastFolio'";
    $result=$conn->query($sql);
    $datos=[];
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            $datos[]=$row;
        }
    }
    return $datos;
}


$table=Show_Datos($table_Date);

echo json_encode([
    'show_datos'=>$table,
    'folio'=>folios(),
    'aceites_stock'=>aceites_Sotck(),
    
    
]);



     


?>