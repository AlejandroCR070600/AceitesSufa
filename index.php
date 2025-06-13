<?php 
require 'BD/conexion.php';
require 'BD/mostrar_datos.php';
date_default_timezone_set('America/Mexico_City');

if (isset($_GET['opciones'])) {
    $buscar_id = isset($_GET['buscar']) ? trim($_GET['buscar']) : ''; // Valor de búsqueda (puede ser vacío)
    $buscar_opc = $_GET['opciones']; // Columna por la que buscar

    // Lista blanca de columnas permitidas
    $columnas_permitidas = ['Fecha', 'Moto_Num', 'id'];

    if (in_array($buscar_opc, $columnas_permitidas)) {
        if ($buscar_id === '') {
            // Si el campo de búsqueda está vacío, traer todos los registros
            $query = "SELECT * FROM control_aceites";
            $result = $conn->query($query);
        } else {
            // Si hay un valor de búsqueda, realizar una consulta filtrada
            $query = "SELECT * FROM control_aceites WHERE $buscar_opc = ?";
            $stmt = $conn->prepare($query);

            // Detectar tipo de dato
            if ($buscar_opc === 'id' || $buscar_opc === 'Moto_Num') {
                $tipo_param = "i"; // Entero
            } else {
                $tipo_param = "s"; // Cadena (Fecha)
            }

            $stmt->bind_param($tipo_param, $buscar_id);
            $stmt->execute();
            $result = $stmt->get_result();
        }
    } else {
      $query = "SELECT * FROM control_aceites";
      $result = $conn->query($query); 
    }
} else {
    // Si no hay selección de opciones, mostrar todos los registros
  
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aceites Sufacen</title>
    
    <link href="styles.css" rel="stylesheet">
    <link href="index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">        

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body class="container-fluid">
    <div class="">
        
         <div class="row vh-100">
            
          
                
    <aside id="aside" class="col-md-1 p-0 d-flex shadow-sm">
        <ul class="d-flex flex-column justify-content-around w-100 h-100">
                <li class="mb-3 mt-3">
               
                <button type="button" class="button" onclick="mostrarFormulario(2)"><i class="fa-solid fa-circle-plus fa-2x"></i></button>
                </li>
                 
            <li class="mb-3">
              
                <button type="button" class="button" onclick="mostrarFormulario(3)"><i class="fa-solid fa-magnifying-glass fa-2x"></i></button>
            </li>
            

            <li class="mb-3">
            
                <button type="button" class="button" onclick="mostrarFormulario(1)">  <i class="fa-solid fa-circle-minus fa-2x"></i></button>
            </li>
      
        
      
       
            <li class="mb-3">
        
                <button type="button" class="button" onclick="mostrarFormulario(4)">   <i class="fa-solid fa-file fa-2x"></i></button>
            </li>
      
        </ul>
         
    </aside>



                <section class="container tableUI col-sm-12 col-md-10">
                    <form method="POST" action="BD/agregar_datos.php" class="">
                    <label class=""><h4>SALIDA DE ACEITES</h4></label>
                    <div class="">
                        <input type="date" id="fecha" name="fecha" placeholder="FECHA" class="">
                        <input type="number" id="Aceites" name="Aceites" placeholder="ACEITES" class="">
                        <input type="text" id="Num_moto" name="Num_Moto" placeholder="Numero de Moto" class="">
                    </div>
                    <input type="submit" value="AGREGAR" class="">
                </form>
                  <form method="GET" action="BD/aceites_Disponibles.php" class="">
                    <label class=""><h4>INGRESAR ACEITES</h4></label>
                    <input type="number" name="ingresoAceites" id="ingresoAceites" placeholder="ACEITES" class="">
                    <input type="text" name="ingresoFolio" id="ingresoFolio" placeholder="FOLIO" class="">
                    <input type="submit" value="INGRESAR ACEITES" id="ing_Aceites" name="ing_Aceites" class="">
                </form>
                  <form method="GET" action="" class="">
                    <label for="buscar" class="">Buscar por</label>
                    <select name="opciones" id="opciones" required class="">
                        <option value="Fecha">fecha</option>
                        <option value="Moto_Num">Moto</option>
                        <option value="id">folio</option>
                    </select>
                    <input type="text" id="buscar" name="buscar" class="">
                    <input type="submit" value="BUSCAR" class="">
                </form>
                     <form method="POST" action="pdf/generador_PDF.php" class="">
                    <label class=""><h5>FECHA DE LA FACTURA</h5></label>
                    <input id="select_Informe" name="select_Informe" type="DATE" class="">
                    <input type="submit" name="submitInforme" value="DESCARGAR" class="">
                </form>
                <div class=" ">
                    <table class="table table-hover " >
                        <thead class="" >
                            <tr >
                                <th class="bg-secondary  text-white">ID</th>
                                <th class="bg-secondary  text-white">FECHA</th>
                                <th class="bg-secondary  text-white">MOTO</th>
                                <th class="bg-secondary  text-white">ACEITES</th>
                                <th class="bg-secondary  text-white">FOLIO</th>
                                <th class="bg-secondary  text-white">ACCIONES</th>
                            </tr>
                        </thead>
                        
                        <tbody class="" >
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>".$row['id']."</td>";
                                    echo "<td>".$row['Fecha']."</td>";
                                    echo "<td>".$row['Moto_Num']."</td>";
                                    echo "<td>".$row['Cant_Aceites']."</td>";
                                    echo "<td>".$row['folio']."</td>";
                                    echo "<td>
                                            <a href='BD/eliminar.php?id=" . $row['id'] . "' onclick='return confirm(\"¿Estás seguro de eliminar este registro?\")'>
                                                <button class='btn btn-secondary text-white btn-sm'>Eliminar</button>
                                            </a>
                                            <a href='BD/agregar_datosE.php?id=" . $row['id'] . "'>
                                                <button class='btn btn-secondary text-white btn-sm'>Editar</button>
                                            </a>
                                        </td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                        
                    </table>
                </div>
                </section>
            
         </div>
            
   
        
    </div>
       
            
       
   

<script src="index.js"></script>
<style>
    .table-responsive::-webkit-scrollbar {
        width: 8px; /* Ancho del scroll */
    }
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1; /* Color del fondo del scroll */
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background:rgb(177, 177, 177); /* Color del scroll */
        border-radius: 4px; /* Redondeo del scroll */
    }
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background:rgb(255, 255, 255); /* Color del scroll al pasar el mouse */
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
