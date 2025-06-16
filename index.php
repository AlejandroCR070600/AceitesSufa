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

<body class="container-fluid">
    <div class="">
        
         <div class="row vh-100">
            
          
                
    <aside id="aside" class="col-md-1 p-0 d-flex">
        <div class="d-flex flex-column justify-content-around w-100 h-100">
                
               
                <button type="button" class="button p-3" onclick="mostrarFormulario(2)"><i class="fa-solid fa-circle-plus icon-grand fa-2x"></i></button>
              
              
                <button type="button" class="button p-3" onclick="mostrarFormulario(3)"><i class="fa-solid fa-magnifying-glass fa-2x"></i></button>
            
            

            
            
                <button type="button" class="button p-3" onclick="mostrarFormulario(1)">  <i class="fa-solid fa-circle-minus fa-2x"></i></button>
            
      
        
      
       
            
        
                <button type="button" class="button p-3" onclick="mostrarFormulario(4)">   <i class="fa-solid fa-file fa-2x"></i></button>
            
      
</div>
         
    </aside>



                <section class="col-sm-12 col-md-10">
                   <div class="row justify-content-center align-items-center g-5">
                     <div class="col-md-4 ">
                        <form method="POST" action="BD/agregar_datos.php" class="">
                            <article class="article bg-light">
                            <h4 class=" text-white text-center">SALIDA DE ACEITES</h4>
                            </article>

                            <div class="d-flex flex-column  border-light align-items-center bg-light">
                                <div class="col-md-8 d-flex flex-column p-2">
                                    <label class="">Fecha</label>
                                    <input type="date" id="fecha" name="fecha" class="">
                                </div>
                                <div class="col-md-8 d-flex flex-column p-2">
                                    <label  class="">Aceites</label>
                                    <input type="number" id="Aceites" name="Aceites"  value="1" class="">
                                </div>
                                <div class="col-md-8 d-flex flex-column p-2 ">
                                    <label  clas="">Moto</label>
                                    <input type="text" id="Num_moto" name="Num_Moto"  class="">
                                </div>
                    
                                <div class="p-2">
                                    <input type="submit" value="AGREGAR" class="">
                                </div>
</div>
                        </form>


                  <form method="GET" action="BD/aceites_Disponibles.php" class="form">
                    <label class=""><h4>INGRESAR ACEITES</h4></label>
                    <input type="number" name="ingresoAceites" id="ingresoAceites" placeholder="ACEITES" class="">
                    <input type="text" name="ingresoFolio" id="ingresoFolio" placeholder="FOLIO" class="">
                    <input type="submit" value="INGRESAR ACEITES" id="ing_Aceites" name="ing_Aceites" class="">
                </form>
                  <form method="GET" action="" class="form">
                    <label  class="">Buscar por</label>
                    <select name="opciones" id="opciones" required class="">
                        <option value="Fecha">fecha</option>
                        <option value="Moto_Num">Moto</option>
                        <option value="id">folio</option>
                    </select>
                    <input type="text" id="buscar" name="buscar" class="">
                    <input type="submit" value="BUSCAR" class="">
                </form>
                     <form method="POST" action="pdf/generador_PDF.php" class="form">
                    <label class=""><h5>FECHA DE LA FACTURA</h5></label>
                    <input id="select_Informe" name="select_Informe" type="DATE" class="">
                    <input type="submit" name="submitInforme" value="DESCARGAR" class="">
                </form>
                    </div>


                <div class="col-md-6 d-flex flex-column">
                    <article class="container-fluid bg-light article">
                        <h1 id="aceites" class="text-center"></h1>
                       <div class="d-flex justify-content-center " >
                        <h1 class="m-1">FOLIO:  </h1>
                         <select id="selectF" name="selectF" class="m-1 text-center bg-dark">

                        </select>
                       </div>
                    </article>
                    <div class="tableUI  ">
                    <table class="table table-hover border border-light" >
                    
                        <thead class="" >
                            <tr >
                                <th class="bg-light text-white">ID</th>
                                <th class=" bg-light text-white">FECHA</th>
                                <th class=" bg-light text-white">MOTO</th>
                                <th class=" bg-light text-white">ACEITES</th>
                                <th class=" bg-light text-white">FOLIO</th>
                                <th class=" bg-light text-white">ACCIONES</th>
                            </tr>
                        </thead>
                        
                        <tbody id="tbody" class="" >
                            
                        
                        </tbody>
                        
                    </table>
                </div>
                </div>
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
