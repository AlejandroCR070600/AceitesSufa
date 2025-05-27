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
    <style>
     

.transparent{
    background:transparent !important;
}
     
  
        .form-container {
            display: none; /* Ocultar formularios inicialmente */
            
            
        }
        #form1 {
            display: block;
        }
    </style>
</head>

<body class="">
    <div class=" container-fluid ">
        <section class="row  ">
            
            <aside class="col-md-3  bg-dark min-vh-100  text-center  p-3 d-flex flex-column align-items-center justify-content-evenly" >
                
                    <nav class=" d-flex flex-column justify-content-center align-items-center" role="group" aria-label="Basic example" >
                       
                                <button type="button" class=" m-1 btn btn-primary form-control" onclick="mostrarFormulario(1)">ENTREGAR ACEITES</button>
                                <button type="button" class=" m-1 btn btn-primary form-control" onclick="mostrarFormulario(2)">AGREGAR ACEITES</button>
                          
                                <button type="button" class=" m-1 btn btn-primary form-control" onclick="mostrarFormulario(3)">BUSCAR</button>
                                <button type="button" class=" m-1 btn btn-primary form-control" onclick="mostrarFormulario(4)">INFORME</button>    
                           
                        
                    </nav>
                    
                
                <form   id="form1" method="POST" action="BD/agregar_datos.php" class="d-flex flex-column container ">                    
                    <label class="text-white bg-primary mb-3 rounded-3"><h4>SALIDA DE ACEITES</h4></label>
                    
             <div class="container">           <input type="date" id="fecha" name="fecha" placeholder="FECHA" class="col-md-10 rounded-4 form-control form-control-lg mb-3" >
               
                        <input type="number" id="Aceites" name="Aceites" placeholder="ACEITES" class="col-md-10 rounded-4 form-control form-control-lg mb-3" >          
             
                        <input type="text" id="Num_moto" name="Num_Moto" placeholder="Numero de Moto" class="col-md-10 rounded-4 form-control form-control-lg mb-3" >
                    </div>

             
                        <input type="submit" value="AGREGAR" class="col-md-10 form-control btn btn-primary fs-5">
                    
                   
                </form>

                <form method="GET" action="BD/aceites_Disponibles.php" id="form2" class="form-container text-center">
                    <label> <h4>INGRESAR ACEITES</h4></label>
                    <input type="number" name="ingresoAceites" id="ingresoAceites" placeholder="ACEITES"  >
                    <input type="text" name="ingresoFolio" id="ingresoFolio" placeholder="FOLIO" >
                    <input type="submit" value="INGRESAR ACEITES" id="ing_Aceites" name="ing_Aceites" >
                </form>

                <form id="form3" class="form-container text-center " method="GET" action="" >
                    <label for="buscar" class="form-label ">Buscar por</label>
                    <select name="opciones" id="opciones" required class="form-select-sm text-white bg-secondary">
                        <option value="Fecha" >fecha</option>
                        <option value="Moto_Num">Moto</option>
                        <option value="id" >folio</option>
                    </select>
                    <input type="input" id="buscar" name="buscar" class="" >
                    <input type="submit" value="BUSCAR" class="">
                </form>
                

                
                <form id="form4" class="form-container text-center" method="POST" action="pdf/generador_PDF.php">
                    <label><h5>FECHA DE LA FACTURA</h5></label>
                    <input id="select_Informe" name="select_Informe" type="DATE" class="">
                    <input type="submit" name="submitInforme" value="DESCARGAR" class="">
                </form>
               
            </aside>  
            
            <main class=" d-flex flex-column align-items-center justify-content-center col-md-9 border" >
                <?php echo"<h1 >".$aceites_Stock."</h1>"; ?>
                <div class="tableUI container-fluid table-responsive border">
                    <table class="table" >
                        <thead class="">
                            <tr>
                                <th>ID</th>
                                <th>FECHA</th>
                                <th>MOTO</th>
                                <th>ACEITES</th>
                                <th>FOLIO</th>
                                <th>ACCIONES</th>
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
                                                <button class='btn btn-primary text-white btn-sm'>Eliminar</button>
                                            </a>
                                            <a href='BD/agregar_datosE.php?id=" . $row['id'] . "'>
                                                <button class='btn btn-primary text-white btn-sm'>Editar</button>
                                            </a>
                                        </td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>  
        </section>
    </div>
       
            
       
   

<script src=""></script>
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
