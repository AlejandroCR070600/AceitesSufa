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


<!-- Contenedor principal -->
<section class="d-flex justify-content-center align-items-center p-4" style="min-height: 100vh; background-color: #373E40;">

  <div class="container-fluid d-flex flex-wrap gap-5 justify-content-center align-items-center">
    
    <!-- Tarjeta de Formularios -->
    <div class="p-4 text-white text-center bg-dark shadow-lg rounded-3" style="max-width: 350px;">
      
      <!-- Formularios con estilos mejorados -->
      <div id="form1" class="form-container">
        <h5 class="mb-3">Entregar Aceites</h5>
        <form method="POST" action="BD/agregar_datos.php" class="d-flex flex-column">
          <label class="mb-1">Fecha</label>
          <input type="date" name="fecha" class="form-control form-control-lg shadow-sm rounded-pill bg-light text-dark" required>
          
          <label class="mt-2 mb-1">Número Moto</label>
          <input type="number" name="Num_Moto" class="form-control form-control-lg shadow-sm rounded-pill bg-light text-dark" required>
          
          <label class="mt-2 mb-1">Aceites</label>
          <input type="number" name="Aceites" class="form-control form-control-lg shadow-sm rounded-pill bg-light text-dark" required>
          
          <button type="submit" class="btn btn-primary rounded-pill mt-3 shadow-sm">AGREGAR</button>
        </form>
      </div>

      <div id="form2" class="form-container">
        <h5 class="mb-3">Agregar Aceites</h5>
        <form method="GET" action="BD/aceites_Disponibles.php">
          <label class="mb-1">Ingresar Aceites</label>
          <input type="number" name="ingresoAceites" class="form-control form-control-lg shadow-sm rounded-pill bg-light text-dark">
          <input type="submit" value="INGRESAR" class="btn btn-primary rounded-pill mt-3 shadow-sm">
        </form>
      </div>

      <div id="form3" class="form-container">
        <h5 class="mb-3">Buscar Registro</h5>
        <form method="GET" action="">
          <label class="mb-1">Buscar por</label>
          <select name="opciones" class="form-select form-select-lg shadow-sm rounded-pill text-dark">
            <option value="Fecha">Fecha</option>
            <option value="Moto_Num">Moto</option>
            <option value="id">Folio</option>
          </select>
          <input type="text" name="buscar" class="form-control form-control-lg shadow-sm rounded-pill bg-light text-dark mt-2">
          <input type="submit" value="BUSCAR" class="btn btn-primary rounded-pill mt-3 shadow-sm">
        </form>
      </div>

      <div id="form4" class="form-container">
        <h5 class="mb-3">Descargar Informe</h5>
        <form method="POST" action="pdf/generador_PDF.php">
          <label class="mb-1">Fecha de la factura</label>
          <input type="date" name="select_Informe" class="form-control form-control-lg shadow-sm rounded-pill bg-light text-dark">
          <input type="submit" name="submitInforme" value="DESCARGAR" class="btn btn-primary rounded-pill mt-3 shadow-sm">
        </form>
      </div>

    </div>

    <!-- Botones de navegación -->
    <div class="col-6">
      <div class="container d-flex flex-wrap gap-2 justify-content-center">
        <button type="button" class="btn btn-secondary rounded-pill shadow-sm" onclick="mostrarFormulario(1)">Entregar Aceites</button>
        <button type="button" class="btn btn-secondary rounded-pill shadow-sm" onclick="mostrarFormulario(2)">Agregar Aceites</button>
        <button type="button" class="btn btn-secondary rounded-pill shadow-sm" onclick="mostrarFormulario(3)">Buscar</button>
        <button type="button" class="btn btn-secondary rounded-pill shadow-sm" onclick="mostrarFormulario(4)">Informe</button>
      </div>
    </div>

  </div>

</section>

<!-- JS para mostrar formularios -->
<script>
  function mostrarFormulario(formId) {
    document.querySelectorAll('.form-container').forEach(form => form.style.display = 'none');
    document.getElementById('form' + formId).style.display = 'block';
  }
</script>


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
