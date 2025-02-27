<?php
include 'conexion.php';

// Eliminar un registro si se pasa el parámetro 'eliminar' por URL
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    // Verificar el valor del id
    echo "ID a eliminar: " . $id; // Verifica que el id se está pasando correctamente
    
    try {
        // Preparar y ejecutar la consulta de eliminación
        $query = "DELETE FROM resultados WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo "Dato eliminado correctamente.";
        } else {
            echo "Error al eliminar el dato.";
        }
    } catch (PDOException $e) {
        // Captura y muestra el error
        echo "Error: " . $e->getMessage();
    }

    // Redirigir después de eliminar el dato
    header('Location: index.php');
    exit();
}

// Consultar la base de datos
$query = "SELECT * FROM resultados";
$stmt = $conn->query($query);
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
