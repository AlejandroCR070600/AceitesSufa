<?php 
require 'BD/conexion.php';
require 'BD/mostrar_datos.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aceites Sufacen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<!-- Contenedor principal centrado -->
<section class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <!-- Fila que contiene dos columnas -->
  <div class="row w-100 justify-content-center ">
    
    <!-- Columna para el formulario -->
    <div class="col-md-2">
      <form method="POST" action="BD/agregar_datos.php" class="form-group">
        <label>Fecha</label>
        <input type="date" id="fecha" name="fecha" class="form-control bg-light text-muted">
        
        <label>Numero Moto</label>
        <input type="number" id="Num_moto" name="Num_Moto" class="form-control bg-light text-muted">
        
        <label>Aceites</label>
        <input type="number" id="Aceites" name="Aceites" class="form-control bg-light text-muted">
        
        <label>Cantidad de motos</label>
        <input type="number" id="Cant_Motos" name="Cant_Motos" class="form-control bg-light text-muted">
        
        <button type="submit" class="btn btn-primary mt-3">AGREGAR</button>
      </form>
      <form method="POST" action="BD/buscar.php">
    <label for="buscar">Buscar por ID:</label>
    <input type="number" id="buscar" name="buscar" required>
    <input type="submit" value="Buscar">
</form>

    </div>

    <!-- Columna para la tabla -->
    <div class="col-md-6 table-responsive p-0 m-0" style="max-height: 550px; overflow-y: auto;">
  
    <table class="table table-borderless table-hover m-0">
        <thead class="table-danger">
          <tr>
            <th>ID</th>
            <th>FECHA</th>
            <th>MOTO</th>
            <th>ACEITES</th>
            <th>CANT MOTOS</th>
            <th>ACCIONES</th>
          </tr>
        </thead>
        <tbody class="table-bordered">
          <?php
  

          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr >";
                  echo "<td > ".$row['id']."</td>";
                  echo "<td >".$row['Fecha']."</td>";
                  echo "<td>".$row['Moto_Num']."</td>";
                  echo "<td>".$row['Cant_Aceites']."</td>";
                  echo "<td>".$row['Cant_Motos']."</td>";
                  echo "<td>
                          <a href='BD/eliminar.php?id=" . $row['id'] . "' onclick='return confirm(\"¿Estás seguro de eliminar este registro?\")'>
                            <button class='btn btn-ligth btn-sm'>Eliminar</button>
                          </a>
                          <a href='BD/agregar_datosE.php?id=" . $row['id'] . "'>
                            <button class='btn btn-ligth btn-sm'>Editar</button>
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
    // Obtiene la fecha actual en formato YYYY-MM-DD
    var today = new Date().toISOString().split('T')[0];
    // Asigna la fecha al input de tipo date
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
        background: #f8d7da; /* Color del scroll */
        border-radius: 4px; /* Redondeo del scroll */
    }
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #f8d7da; /* Color del scroll al pasar el mouse */
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
