<?php
require 'conexion.php'; // Conexión a la base de datos
require '../excel/datosExcel.php';
// Verificar si el ID ha sido recibido
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convertir el ID recibido a entero para mayor seguridad

    // Verificar si el registro existe antes de eliminarlo
    $sqlCheck = "SELECT * FROM control_aceites WHERE id = $id";
    $resultCheck = $conn->query($sqlCheck);

    if ($resultCheck->num_rows > 0) {
        // Preparar la consulta SQL para eliminar el registro
        $sql = "DELETE FROM control_aceites WHERE id = $id";

        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            eliminarDatosExcel($id);
            echo "Registro eliminado correctamente.";
            // Redirigir a otra página
            header("Location: /AceitesSufa/index.php");
            exit(); // Detener la ejecución del script
        } else {
            echo "Error al eliminar el registro: " . $conn->error;
        }
    } else {
        echo "El registro con ID $id no existe.";
    }
} else {
    echo "ID no especificado.";
}
?>
