<?php
require 'conexion.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['buscar']);
    echo "$id";



if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['buscar'])) {
        $id = $_GET['buscar'];
        $sqlBuscar="SELECT * FROM control_aceites where id=$id ";
        $result=$conn->query($sqlBuscar);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr >";
                echo "<td > ".$row['id']."---</td>";
                echo "<td >".$row['Fecha']."---</td>";
                echo "<td>".$row['Moto_Num']."---</td>";
                echo "<td>".$row['Cant_Aceites']."---</td>";
                echo "<td>".$row['Cant_Motos']."---</td>";
                echo "<td>
                        <a href='BD/eliminar.php?id=" . $row['id'] . "' onclick='return confirm(\"¿Estás seguro de eliminar este registro?\")'>
                          <button class='btn btn-ligth btn-sm'>Eliminar</button>
                        </a>
                        <a href='BD/agregar_datosE.php?id=" . $row['id'] . "'>
                          <button class='btn btn-ligth btn-sm'>Editar</button>
                        </a>
                      </td>";
                echo "</tr>";
            }
        }
        header("Location: /AceitesSufa/index.php");
        


        exit;
        
    
        
    }
 
}
}


?>
