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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body class="container-fluid">
    <div class="">
        
         <div class="row vh-100">
            
          
                
    <aside id="aside" class="">
        <ul class="">
            <li class="">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="">
                    <path fill-rule="evenodd" d="M10.5 3.798v5.02a3 3 0 0 1-.879 2.121l-2.377 2.377a9.845 9.845 0 0 1 5.091 1.013 8.315 8.315 0 0 0 5.713.636l.285-.071-3.954-3.955a3 3 0 0 1-.879-2.121v-5.02a23.614 23.614 0 0 0-3 0Zm4.5.138a.75.75 0 0 0 .093-1.495A24.837 24.837 0 0 0 12 2.25a25.048 25.048 0 0 0-3.093.191A.75.75 0 0 0 9 3.936v4.882a1.5 1.5 0 0 1-.44 1.06l-6.293 6.294c-1.62 1.621-.903 4.475 1.471 4.88 2.686.46 5.447.698 8.262.698 2.816 0 5.576-.239 8.262-.697 2.373-.406 3.092-3.26 1.47-4.881L15.44 9.879A1.5 1.5 0 0 1 15 8.818V3.936Z" clip-rule="evenodd" />
                </svg>
                <button type="button" class="" onclick="mostrarFormulario(1)">ENTREGAR ACEITES</button>
            </li>
            <li id="form1" class="">
                <form method="POST" action="BD/agregar_datos.php" class="">
                    <label class=""><h4>SALIDA DE ACEITES</h4></label>
                    <div class="">
                        <input type="date" id="fecha" name="fecha" placeholder="FECHA" class="">
                        <input type="number" id="Aceites" name="Aceites" placeholder="ACEITES" class="">
                        <input type="text" id="Num_moto" name="Num_Moto" placeholder="Numero de Moto" class="">
                    </div>
                    <input type="submit" value="AGREGAR" class="">
                </form>
            </li>
            <li class="">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                </svg>
                <button type="button" class="" onclick="mostrarFormulario(2)">AGREGAR ACEITES</button>
            </li>
            <li id="form2" class="">
                <form method="GET" action="BD/aceites_Disponibles.php" class="">
                    <label class=""><h4>INGRESAR ACEITES</h4></label>
                    <input type="number" name="ingresoAceites" id="ingresoAceites" placeholder="ACEITES" class="">
                    <input type="text" name="ingresoFolio" id="ingresoFolio" placeholder="FOLIO" class="">
                    <input type="submit" value="INGRESAR ACEITES" id="ing_Aceites" name="ing_Aceites" class="">
                </form>
            </li>
            <li class="">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="">
                    <path d="M8.25 10.875a2.625 2.625 0 1 1 5.25 0 2.625 2.625 0 0 1-5.25 0Z" />
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.125 4.5a4.125 4.125 0 1 0 2.338 7.524l2.007 2.006a.75.75 0 1 0 1.06-1.06l-2.006-2.007a4.125 4.125 0 0 0-3.399-6.463Z" clip-rule="evenodd" />
                </svg>
                <button type="button" class="" onclick="mostrarFormulario(3)">BUSCAR</button>
            </li>
            <li id="form3" class="">
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
            </li>
            <li class="">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="">
                    <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                    <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                </svg>
                <button type="button" class="" onclick="mostrarFormulario(4)">INFORME</button>
            </li>
            <li id="form4" class="">
                <form method="POST" action="pdf/generador_PDF.php" class="">
                    <label class=""><h5>FECHA DE LA FACTURA</h5></label>
                    <input id="select_Informe" name="select_Informe" type="DATE" class="">
                    <input type="submit" name="submitInforme" value="DESCARGAR" class="">
                </form>
            </li>
        </ul>
    </aside>



                <div class=" container tableUI col-sm-12 col-md-6">
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
