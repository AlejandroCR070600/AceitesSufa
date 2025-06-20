<?php 
require 'BD/conexion.php';

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
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body class="bg-light">
    
   <div class="container-fluid  ">
        <div class="row align-items-center vh-100">
            <header class="col-md-12 col-sm-12 d-flex flex-column flex-md-row justify-content-around">
             
                    <form method="POST" action="BD/agregar_datos.php" class="col-md-2 col-sm-12 d-flex flex-column bg-white m-2 p-3 shadow">
                    <article>
                        <h4>SALIDA DE ACEITES</h4>
                    </article>

                
                    <label>Fecha</label>
                    <input type="date" id="fecha" name="fecha">
            
                    <label>Aceites</label>
                    <input type="number" id="Aceites" name="Aceites" value="1">
                    
                    <label>Moto</label>
                    <input type="text" id="Num_moto" name="Num_Moto">
                    
                    <input type="submit" value="AGREGAR">
                        
                    
                    </form>

                    <form method="GET" action="BD/aceites_Disponibles.php" class="col-md-2 col-sm-12  d-flex flex-column bg-white m-2 p-3 shadow">
                        <label><h4>INGRESAR ACEITES</h4></label>
                        <input type="number" name="ingresoAceites" id="ingresoAceites" placeholder="ACEITES">
                        <input type="text" name="ingresoFolio" id="ingresoFolio" placeholder="FOLIO">
                        <input type="submit" value="INGRESAR ACEITES" id="ing_Aceites" name="ing_Aceites">
                    </form>

                        <form method="GET" class="col-md-2 col-sm-12 border d-flex flex-column bg-white m-2 p-3 shadow">
                        <label>Buscar por</label>
                        <select name="opciones" id="opciones" required>
                            <option value="Fecha">fecha</option>
                            <option value="Moto_Num">Moto</option>
                            <option value="id">folio</option>
                        </select>
                        <input type="text" id="buscar" name="buscar">
                        <input type="submit" value="BUSCAR">
                    </form>

                    <form method="POST" action="pdf/generador_PDF.php" class="col-md-2 col-sm-12 d-flex flex-column bg-white m-2 p-3 shadow">
                        <label><h5>FECHA DE LA FACTURA</h5></label>
                        <input id="select_Informe" name="select_Informe" type="DATE">
                        <input type="submit" name="submitInforme" value="DESCARGAR">
                    </form>
                
            </header>
            <section class="col-md-12">

                <div class="row justify-content-around align-items-center">
                        <article class="col-sm-10 col-md-3 shadow bg-white m-3 p-5 text-center">
                        <h1 >Aceites Disponibles</h1>
                        <h1 id="aceites"></h1>
                    
                        <div class=" container row">
                            <h1 class="col-md-6">FOLIO:</h1>
                            <select id="selectF" name="selectF" class="col-md-6"></select>
                        </div>
                    
                    </article>

                
                    <article class="table-responsive col-sm-10  col-md-8 shadow bg-white m-2 vh-50 border">
                        <table class="table  table-hover ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>FECHA</th>
                                    <th>MOTO</th>
                                    <th>ACEITES</th>
                                    <th>FOLIO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                            </tbody>
                        </table> 
                    </article>
                </div>
            </section> 
        </div>
   </div>
            
<script src="js/index.js"></script>
<script src="js/mandar_datos.js"></script>
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
