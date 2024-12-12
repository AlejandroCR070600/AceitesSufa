<?php


require 'conexion.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener el registro para mostrarlo en el formulario
    $sql = "SELECT * FROM control_aceites WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);  // "i" indica que estamos pasando un entero
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Registro no encontrado.";
        exit;
    }
} else {
    echo "ID no proporcionado.";
    exit;
}



function editar_datos($conn, $id){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha = $_POST['FechaE'];
    $num_moto = $_POST['Num_MotoE'];
    $aceites = $_POST['AceitesE'];
    $cant_motos = $_POST['Cant_ME'];

    $sqlE="UPDATE control_aceites SET Moto_Num = $num_moto, Cant_Aceites=$aceites, Fecha=$fecha WHERE id=$id";

    if ($conn->query($sqlE)=== TRUE){
        echo"datos actualizados";
    }else{
        echo "error";
    }

    }else{
        echo "no hay datos";
    }
    


}
editar_datos($conn, $id);
?>

<form method='POST'> 
        <input type='date' id='FechaE' name='FechaE' value='<?php echo $row['Fecha']?>'>
        <input type='num' id='Num_MotoE' name='Num_MotoE' value='<?php echo $row['Moto_Num']?>'>
        <input type='num' id='AceitesE' name='AceitesE' value='<?php  echo $row['Cant_Aceites']?>'>
        <input type='num' id='Cant_ME' name='Cant_ME' value='<?php echo $row['Cant_Motos']?>'>
        <input type='submit'>
</form>





