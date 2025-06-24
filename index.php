<?php 
require 'BD/conexion.php';

date_default_timezone_set('America/Mexico_City');
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

<body class="bg-secondary">
    
   <div class="container-fluid">
        <div class="row align-items-center justify-content-around">

            <header class="col-md-3 col-sm-12 d-flex flex-column   p-0  vh-100">
                         
  <div class="btn-group" role="group" aria-label="Basic outlined example">
                     <button class="btn border-0 btn-outline-danger text-black rounded-0" onclick="mostrarFormulario(1)">Entregar</button>
                   <button class="btn border-0 btn-outline-danger text-black rounded-0" onclick="mostrarFormulario(2)" >Agregar</button>
                 <button class="btn border-0 btn-outline-danger text-black rounded-0" onclick="mostrarFormulario(3)">Buscar</button>
  <button type="button" class="btn border-0 btn-outline-danger text-black rounded-0" onclick="mostrarFormulario(4)">Informe</button>
</div>

             
                
                    <div class="d-flex align-items-center justify-content-center  vh-100 ">

                       <div class="forms ">
                         <form method="POST" action="BD/agregar_datos.php" class="  d-flex  flex-column align-items-center bg-light rounded-4  shadow">
                            <article class="container-fluid text-center bg-danger bg-gradiant m-3 mt-4">
                                <h4 class="text-white m-0" >ENTREGAR ACEITE</h4>
                            </article>

                
                    <div class="container text-center m-3">
                        
                                        <input type="date" id="fecha" name="fecha" class="form-control mb-3">
                                
                                        
                                        <input type="number" id="aceites" name="aceites" value="1" placeholder="NUMERO" class="form-control mb-3">
                                        
                                        
                                        <input type="text" id="Num_moto" name="Num_Moto" placeholder="MOTO" class="form-control mb-3">
                                        
                                        <button id="btnAgregar" value="AGREGAR" class="btn btn-outline-danger">AGREGAR</button>
                    </div>
                    
                    </form>

                       </div>
                   <div class="forms d-none">
                     <form  class="  d-flex  flex-column align-items-center bg-light  rounded-4  shadow">
                          <article class="container-fluid text-center bg-danger bg-gradiant m-3 mt-4">
                                <h4 class="text-white m-0" >INGRESAR ACEITES</h4>
                            </article>
                            <div class="container text-center m-3">
                        <input type="number" name="ingresoAceites" id="ingresoAceites" placeholder="ACEITES" class="form-control mb-3">
                        <input type="text" name="ingresoFolio" id="ingresoFolio" placeholder="FOLIO" class="form-control mb-3">
                        <button value="ingresarAceite" id="btnAgregarDatos" name="btnAgregarDatos" class="btn btn-outline-dark">INGRESAR</button>
                            </div>
                    </form>
                   </div>


                    <div class="forms d-none">
                                <form class="  d-flex  flex-column align-items-center bg-light rounded-4  shadow">
                          <article class="container-fluid text-center bg-danger bg-gradiant m-3 mt-4">
                                <h4 class="text-white m-0" >BUSCAR POR</h4>
                            </article>
                            <div class="container text-center m-3">
                        <select name="opciones" id="opciones" required class="form-control mb-3">
                            <option value="Fecha" >fecha</option>
                            <option value="Moto_Num">Moto</option>
                            <option value="id">folio</option>
                        </select>
                        <input type="text" id="buscar" name="buscar" class="form-control mb-3">
                        <button id="btnBuscar" class="btn btn-outline-dark" >BUSCAR</button>
                            </div>
                    </form>
                    </div>
                       
                <div class="forms d-none">
    
                    <form method="POST" action="pdf/generador_PDF.php" class="  d-flex  flex-column align-items-center bg-light rounded-4  shadow">
                        <article class="container-fluid text-center bg-danger bg-gradiant m-3 mt-4">
                                <h4 class="text-white m-0" >INFORME</h4>
                            </article>
                        <div class="container text-center m-3">
                        <input id="select_Informe" name="select_Informe" type="DATE" class="form-control mb-3">
                        <input type="submit" name="submitInforme" value="DESCARGAR" class="btn btn-outline-dark">
                        </div>
                    </form>
                </div>
                    
                   </div>
                
            </header>
            <section class="col-md-6 ">

                <div class="row vh-100">
                        <article class="bg-light text-center p-0">
                        <h1 >Aceites Disponibles</h1>   
                        <div class="container-fluid border bg-danger">
                            
                        <h1 id="aceites_stock" class="text-white">asd</h1>
                        
                        </div>
                    
                        <div class=" container ">
                           <div class="d-flex justify-content-center ">
                             <h1 class="">FOLIO: </h1>
                            <select id="selectF" name="selectF" class="p-0 btn  btn-outline-dark"></select>
                           </div>
                        </div>
                    
                    </article>

                
                    <article class="table-responsive col-sm-10  col-md-12 shadow bg-light  border">
                        <table class="table table-light  table-hover ">
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
<script src="js/acciones.js"></script>
<script src="js/agregar_Datos.js"></script>
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
