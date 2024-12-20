<?php 
require 'BD/conexion.php';
require 'BD/mostrar_datos.php';

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
        echo "Error: Columna no permitida.";
        exit;
    }
} else {
    // Si no hay selección de opciones, mostrar todos los registros
    $query = "SELECT * FROM control_aceites";
    $result = $conn->query($query); 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aceites Sufacen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body style="background-color: #373E40;" class="flex-column ustify-content-center align-items-center">


<!-- Contenedor principal centrado -->
<section class="container-fluid flex-column justify-content-center align-items-center border" style="min-height: 100vh;">
 <h1>hola</h1>
  <!-- Fila que contiene dos columnas -->
  <div class="w-100 d-flex justify-content-center align-items-center ">

    <!-- Columna para el formulario -->
    <div class="col-md-2 bg-dark p-3 text-white me-5 rounded d-flex flex-column align-items-center justify-content-center">

    <form method="GET" action="" class="form-group">
    <label for="buscar" class="form-label mb-2">Buscar por</label>
    <select name="opciones" id="opciones" required class="form-select-sm">
      <option value="Fecha" >fecha</option>
      <option value="Moto_Num" >moto</option>
      <option value="id" >folio</option>


    <input type="input" id="buscar" name="buscar" class="form-control" >
    <input type="submit" value="Buscar" class="btn btn-primary mt-3 form-control">
</form>
      <form method="POST" action="BD/agregar_datos.php" class="form-group ">
        <label>Fecha</label>
        <input type="date" id="fecha" name="fecha" class="form-control bg-light text-muted" required>
        
        <label>Numero Moto</label>
        <input type="number" id="Num_moto" name="Num_Moto" class="form-control bg-light text-muted" required>
        
        <label>Aceites</label>
        <input type="number" id="Aceites" name="Aceites" class="form-control bg-light text-muted" required>
        
        <label>Cantidad de motos</label>
        <input type="number" id="Cant_Motos" name="Cant_Motos" class="form-control bg-light text-muted" required>
        
        <button type="submit" class="btn btn-primary mt-3 form-control">AGREGAR</button>
      </form>
    

    </div>

    <!-- Columna para la tabla -->
    <div class="col-md-6 table-responsive p-0 m-0 rounded" style="max-height: 550px; overflow-y: auto;">
  
    <table class="table table-borderless table-hover m-0 ">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>FECHA</th>
            <th>MOTO</th>
            <th>ACEITES</th>
            <th>CANT MOTOS</th>
            <th>ACCIONES</th>
          </tr>
        </thead>
        <tbody class="table-bordered table-dark text-white">

          <?php
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>".$row['id']."</td>";
                  echo "<td>".$row['Fecha']."</td>";
                  echo "<td>".$row['Moto_Num']."</td>";
                  echo "<td>".$row['Cant_Aceites']."</td>";
                  echo "<td>".$row['Cant_Motos']."</td>";
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

  </div>
</section>

<!-- Script para establecer la fecha del día automáticamente -->
<script>
  
  window.onload = function() {
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('fecha').value = today;
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
