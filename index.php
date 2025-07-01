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

   <div class="container-fluid">
        <div class="row ">

            <header class="col-md-6 col-sm-12 d-flex flex-column bg-secondary p-0  vh-100 border border-2 border-black">
                         
                <div class="btn-group groupBtn" role="group" aria-label="Basic outlined example">
                        <button class="btn border-0 btn-outline-danger text-black rounded-0" onclick="mostrarFormulario(1)">Entregar</button>
                        <button class="btn border-0 btn-outline-danger text-black rounded-0" onclick="mostrarFormulario(2)" >Agregar</button>
                        <button class="btn border-0 btn-outline-danger text-black rounded-0" onclick="mostrarFormulario(3)">Buscar</button>
                        <button type="button" class="btn border-0 btn-outline-danger text-black rounded-0" onclick="mostrarFormulario(4)">Informe</button>
                </div>

                <div class="d-flex align-items-center justify-content-center bg-secondary vh-100 ">

                    <div class="forms">
                        <form class="  d-flex  flex-column align-items-center bg-light rounded-4 border  shadow-sm">
                            <article class="container-fluid text-center bg-danger bg-gradiant m-3 mt-4">
                                <h4 class="text-white m-0" >ENTREGAR ACEITE</h4>
                            </article>
                            <div class="container text-center m-3">
                                
                                <input type="date" id="fecha" name="fecha" class="form-control mb-3" require>
                                <input type="number" id="aceites" name="aceites" value="1" placeholder="NUMERO" class="form-control mb-3" require>
                                <input type="text" id="Num_moto" name="Num_Moto" placeholder="MOTO" class="form-control mb-3" require>
                                                
                                <button id="btnAgregar" value="AGREGAR" class="btn btn-outline-danger">AGREGAR</button>
                            </div>
                    
                        </form>

                    </div>
                   <div class="forms d-none">

                        <form  class="  d-flex  flex-column align-items-center bg-light  rounded-4  shadow-sm">

                            <article class="container-fluid text-center bg-danger  m-3 mt-4">
                                <h4 class="text-white m-0" >INGRESAR ACEITES</h4>
                            </article>
                            <div class="container text-center m-3">

                                <input type="number" name="ingresoAceites" id="ingresoAceites" placeholder="ACEITES" class="form-control mb-3">
                                <input type="text" name="ingresoFolio" id="ingresoFolio" placeholder="FOLIO" class="form-control mb-3">
                                <button type="button" value="ingresarAceites" id="btnAgregarDatos" name="btnAgregarDatos" class="btn btn-outline-dark">INGRESAR ACEITES</button>

                            </div>
                        </form>
                   </div>


                    <div class="forms d-none">
                        <form class="  d-flex  flex-column align-items-center bg-light rounded-4 shadow-sm">
                            <article class="container-fluid text-center bg-danger bg-gradiant m-3 mt-4">
                                    <h4 class="text-white m-0" >BUSCAR POR</h4>
                            </article>
                            <div class="container text-center m-3">

                                <select name="opciones" id="opciones" required class="form-control mb-3">
                                    <option value="Fecha" >fecha</option>
                                    <option value="Moto_Num">Moto</option>
                                    <option value="folio">folio</option>
                                </select>

                                <input type="text" id="buscar" name="buscar" class="form-control mb-3">
                                <button id="btnBuscar" value="buscar" class="btn btn-outline-dark" >BUSCAR</button>
                            </div>
                        </form>
                    </div>
                       
                    <div class="forms d-none">
        
                        <form  class="  d-flex  flex-column align-items-center bg-light rounded-4  shadow-sm">
                            <article class="container-fluid text-center bg-danger bg-gradiant m-3 mt-4">
                                    <h4 class="text-white m-0" >INFORME</h4>
                                </article>
                            <div class="container text-center m-3">
                                <input id="download_Folio" name="download_Folio" placeholder="FOLIO" type="text" class="form-control mb-3">
                                <button id="btnDownload" name="download" value="DOWNLOAD"  class="btn btn-outline-dark">DESCARGAR</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
                
            </header>
            <section class="col-md-6 col-sm-12 vh-100 bg-light  border border-2 border-warning  p-0">

                        
                <article class="text-center p-0">
                    <h2 >Aceites Disponibles</h2>   
                    <div class="bg-danger shadow-sm mb-3">
                            
                        <h1 id="aceites_stock" class="text-white"></h1>
                        
                    </div>
                    
                    <div class=" container ">
                        <div class="d-flex justify-content-center pb-3">
                             <h2 class="">FOLIO: </h2>
                            <select id="selectF" name="selectF" class="btn border-0 btn-outline-danger text-black rounded-0  "></select>
                        </div>
                    </div>
                    
                </article>

                
                <article class="" style="height:450px; overflow:auto;">

                    <div class="  ">
                        <table class="table table-hover bg-transparent">
                            <thead class="">
                                <tr>
                                    <th class="bg-danger text-white">ID</th>
                                    <th class="bg-danger text-white">FECHA</th>
                                    <th class="bg-danger text-white">MOTO</th>
                                    <th class="bg-danger text-white">ACEITES</th>
                                    <th class="bg-danger text-white">FOLIO</th>
                                    <th class="bg-danger text-white">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="tbody" class="">
                                
                            </tbody>
                        </table> 
                       
                    </div>
                    
                </article>
                
                        
            </section> 
        </div>
   </div>
            
<script src="js/mostrar_Datos.js"></script>
<script src="js/mandar_Datos.js"></script>
<script src="js/entregar_Aceites.js"></script>
<script src="js/ingresar_Aceites.js"></script>
<script src="js/buscar.js"></script>
<script src="js/download_Informe.js"></script>
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
