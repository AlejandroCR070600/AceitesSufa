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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
      *{
        margin:none;
        padding:none;
      }
        .form-container {
            display: none; /* Ocultar formularios inicialmente */
            
        }
        #form1 {
            display: block;
        }
    </style>
</head>

<body style="background-color: #373E40;" class="flex-column justify-content-center align-items-center">


<!-- Contenedor principal centrado -->
<section class="d-flex " style="min-height: 100vh;">
 
  <!-- Fila que contiene dos columnas -->
  <div class=" container-fluid border d-flex gap-5 flex-wrap justify-content-center align-items-center">
  

    <!-- Columna para el formulario -->
    <div class="p-3  text-white text-center bg-dark align-content-center rounded-3" style="height: 300px" >
 
    <div id="form1" class="form-container">
      <form method="POST" action="BD/agregar_datos.php" class="d-flex flex-column">
          <label>Fecha</label>
          <input type="date" id="fecha" name="fecha" class="form-control form-control-sm rounded-5 bg-light text-muted" required>
          
          <label>Numero Moto</label>
           <input type="number" id="Num_moto" name="Num_Moto" class="form-control form-control-sm rounded-5 bg-light text-muted" required>
          
          <label>Aceites</label>
          <input type="number" id="Aceites" name="Aceites" class="form-control form-control-sm rounded-5 bg-light text-muted" required>
          
        
          
          <button type="submit" class="btn btn-primary  form-control-sm rounded-5 mt-2">AGREGAR</button>
      </form>
    </div>
      
    <div id="form2" class="form-container">
        
        <form method="GET" action="BD/aceites_Disponibles.php"class="">
        <label> Ingresar Aceites</label>
        <input type="number" name="ingresoAceites" id="ingresoAceites" class="form-control form-control-sm rounded-5 bg-light text-muted">
        <input type="submit" value="INGRESAR ACEITES" id="ing_Aceites" name="ing_Aceites" class="btn btn-primary  form-control-sm rounded-5 mt-2">
        </form>
    </div>
      

      <div id="form3" class="form-container">

      <form method="GET" action="" class="">
          <label for="buscar" class="form-label ">Buscar por</label>
          <select name="opciones" id="opciones" required class="form-select-sm">
            <option value="Fecha" >fecha</option>
            <option value="Moto_Num">Moto</option>
            <option value="id" >folio</option>


          <input type="input" id="buscar" name="buscar" class="form-control form-control-sm rounded-5 bg-light text-muted" >
          <input type="submit" value="BUSCAR" class="btn btn-primary  form-control-sm rounded-5 mt-2">
      </form>
      </div>

      <div id="form4" class="form-container">
      <form method="POST" action="pdf/generador_PDF.php">
        <label>Fecha de la factura</label>
        <input id="select_Informe" name="select_Informe" type="DATE" class="form-control form-control-sm rounded-5 bg-light text-muted">
        <input type="submit" name="submitInforme" value="DESCARGAR" class="btn btn-primary  form-control-sm rounded-5 mt-2">
      </form>
</div>
      
      

    </div>

    <!-- Columna para la tabla -->
    <div class="col-6" >
    <div class="container d-flex justify-content-center  btn-group" role="group" aria-label="Formulario botones">
            <button type="button" class="btn btn-secondary" onclick="mostrarFormulario(1)">Entregar Aceites</button>
            <button type="button" class="btn btn-secondary" onclick="mostrarFormulario(2)">Agregar Aceites</button>
            <button type="button" class="btn btn-secondary" onclick="mostrarFormulario(3)">Buscar</button>
            <button type="button" class="btn btn-secondary" onclick="mostrarFormulario(4)">Informe</button>
      </div>
    <?php echo"<h2 class='fd-6 text-center' style='color:white;'>".$aceites_Stock."</h2>"; ?>
    <?php
    
// Inicia la sesión

if (isset($_SESSION['mensaje'])) {
    echo "<script>alert('" . $_SESSION['mensaje'] . "');</script>";
    unset($_SESSION['mensaje']); // Elimina el mensaje después de mostrarlo
}
?>

    
   
<div class="rounded-3" style="height:400px; max-height: 550px; overflow-y: auto;">

<table class="table table-sm table-hover table-dark ">
    <thead>
        <tr>
            <th>ID</th>
            <th>FECHA</th>
            <th>MOTO</th>
            <th>ACEITES</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['Fecha']."</td>";
                echo "<td>".$row['Moto_Num']."</td>";
                echo "<td>".$row['Cant_Aceites']."</td>";
                echo "<td>
                        <a href='BD/eliminar.php?id=" . $row['id'] . "' onclick='return confirm(\"¿Estás seguro de eliminar este registro?\")'>
                            <button class='btn btn-dark btn-sm'>Eliminar</button>
                        </a>
                        <a href='BD/agregar_datosE.php?id=" . $row['id'] . "'>
                            <button class='btn btn-dark btn-sm'>Editar</button>
                        </a>
                    </td>";
                echo "</tr>";
            }
        }
        ?>
    </tbody>
</table>

  
</div>
<form method="post" action="excel/datosExcel.php">
    <button type="submit" name="actualizar">Actualizar</button>
</from>
    </div>

  </div>
</section>

<!-- Script para establecer la fecha del día automáticamente -->
<script>
  

  function mostrarFormulario(formId) {
            // Ocultar todos los formularios
            document.querySelectorAll('.form-container').forEach(function(form) {
                form.style.display = 'none';
            });

            // Mostrar el formulario seleccionado
            document.getElementById('form' + formId).style.display = 'block';
        }
</script>
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
