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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aceites Sufacen</title>
    
    <link href="styles.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
      *{
        margin:none;
        padding:none;
      }
      html, body {
  height: 100%;  /* Establece la altura del html y body al 100% de la pantalla */
  margin: 0;     /* Elimina el margen por defecto del body */
  padding: 0;    /* Elimina el relleno por defecto */
  
}
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
    

       <div class="container border" >
        
         <nav class="" role="group" aria-label="Basic example" >
                <button type="button" class="" onclick="mostrarFormulario(1)">ENTREGAR ACEITES</button>
                <button type="button" class="" onclick="mostrarFormulario(2)">AGREGAR ACEITES</button>
                <button type="button" class="" onclick="mostrarFormulario(3)">BUSCAR</button>
                <button type="button" class="" onclick="mostrarFormulario(4)">INFORME</button>    
                
        </nav>
      
    
        
        
            
        <section class="border">
            <?php echo"<h1 >".$aceites_Stock."</h1>"; ?>
            <aside class=" " >
                <form   id="form1" method="POST" action="BD/agregar_datos.php" class="">                    
                    <label class=""><h4>SALIDA DE ACEITES</h4></label>
                    <input type="date" id="fecha" name="fecha" placeholder="FECHA" class="" >
                    <input type="number" id="Aceites" name="Aceites" placeholder="ACEITES" class="" >          
                    <input type="text" id="Num_moto" name="Num_Moto" placeholder="Numero de Moto" class="" >
                    <input type="submit" value="AGREGAR" class="" style="width: 100px;">
                </form>

                <form method="GET" action="BD/aceites_Disponibles.php" id="form2" class="form-container text-center">
                    <label> <h4>INGRESAR ACEITES</h4></label>
                    <input type="number" name="ingresoAceites" id="ingresoAceites" placeholder="ACEITES" class="form-control form-control-sm rounded-5 bg-light text-muted mb-3 ">
                    <input type="text" name="ingresoFolio" id="ingresoFolio" placeholder="FOLIO" class="form-control form-control-sm rounded-5 bg-light text-muted mb-3">
                    <input type="submit" value="INGRESAR ACEITES" id="ing_Aceites" name="ing_Aceites" class="btn btn-secondary text-white form-control-sm rounded-5 mt-2">
                </form>

                <form id="form3" class="form-container text-center " method="GET" action="" >
                    <label for="buscar" class="form-label ">Buscar por</label>
                    <select name="opciones" id="opciones" required class="form-select-sm text-white bg-secondary">
                        <option value="Fecha" >fecha</option>
                        <option value="Moto_Num">Moto</option>
                        <option value="id" >folio</option>
                    </select>
                    <input type="input" id="buscar" name="buscar" class="form-control form-control-sm rounded-5 bg-light text-muted" >
                    <input type="submit" value="BUSCAR" class="btn btn-secondary text-white  form-control-sm rounded-5 mt-2">
                </form>
                

                
                <form id="form4" class="form-container text-center" method="POST" action="pdf/generador_PDF.php">
                    <label><h5>FECHA DE LA FACTURA</h5></label>
                    <input id="select_Informe" name="select_Informe" type="DATE" class="form-control form-control-sm rounded-5 bg-light text-muted">
                    <input type="submit" name="submitInforme" value="DESCARGAR" class="btn btn-secondary text-white  form-control-sm rounded-5 mt-2">
                </form>
            </aside>  
            <main class="" >
                
                <div class="">
                    <table class="" >
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
