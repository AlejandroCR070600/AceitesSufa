<?php
if (isset($_GET['opciones'])) {
  $buscar_id = isset($_GET['buscar']) ? trim($_GET['buscar']) : ''; // Valor de búsqueda (puede ser vacío)
  $buscar_opc = $_GET['opciones']; // Columna por la que buscar

  // Lista blanca de columnas permitidas
  $columnas_permitidas = ['Fecha', 'Moto_Num', 'id', 'folio'];

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
