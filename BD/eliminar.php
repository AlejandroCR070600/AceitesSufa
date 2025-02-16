<?php
require 'conexion.php'; // Conexión a la base de datos
require '../excel/datosExcel.php';
// Verificar si el ID ha sido recibido
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convertir el ID recibido a entero para mayor seguridad

    // Verificar si el registro existe antes de eliminarlo
    $sqlCheck = "SELECT * FROM control_aceites WHERE id = $id";
    $resultCheck = $conn->query($sqlCheck);

    $sqlA="SELECT Cant_Aceites FROM aceites_Stock ORDER BY id DESC LIMIT 1";
    $resultA=$conn->query($sqlA);

    if ($resultCheck->num_rows > 0) {
        // Preparar la consulta SQL para eliminar el registro
        $sql = "DELETE FROM control_aceites WHERE id = $id";

        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            eliminarDatosExcel($id);
            agregarAceiteElminado($conn);
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
function sumaAceites($conn) {
    $sqlA = "SELECT Cant_Aceites FROM aceites_Stock ORDER BY id DESC LIMIT 1";
    $resultA = $conn->query($sqlA);

    if ($resultA->num_rows > 0) {
        // Obtener la última fila del resultado
        $row = $resultA->fetch_assoc();
        $suma = $row['Cant_Aceites'] + 1;
        return $suma;
    } else {
        // Si no hay registros, devolver 0 como valor predeterminado
        return 0;
    }
}

function agregarAceiteElminado($conn) {
    $Suma = sumaAceites($conn);

    // Verificar que $Suma es un valor numérico antes de continuar
    if (is_numeric($Suma)) {
        $fecha = date('Y-m-d');  // Obtener la fecha actual

        // Usar una consulta preparada para mayor seguridad
        $stmt = $conn->prepare("INSERT INTO aceites_Stock (Cant_Aceites, Fecha_Aceites, Entrada, Salida) VALUES (?, ?, 1, 0)");
        $stmt->bind_param("ds", $Suma, $fecha);  // "d" para el valor decimal y "s" para la fecha (string)

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Se eliminó correctamente";
        } else {
            $_SESSION['mensaje'] = "No se pudo eliminar correctamente";
        }
        $stmt->close();
    } else {
        $_SESSION['mensaje'] = "Error: $Suma no es un valor numérico.";
    }
}



?>
