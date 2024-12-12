<?php

// Verifica si el formulario fue enviado por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si 'id' está presente y no está vacío
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];  // Obtener el valor de 'id' desde el formulario
        echo "El ID recibido es: " . $id;  // Mostrar el valor recibido
    } else {
        echo "No se proporcionó un ID.";
    }
}

?>
