<?php
// agregar.php
include 'conexion.php'; // Asegúrate de que la conexión sea correcta

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $resultado = $_POST['resultado'];
    $fecha = $_POST['fecha'];

    // Consulta SQL para insertar los datos
    $query = "INSERT INTO resultados (nombre, cedula, resultado, fecha) 
              VALUES (:nombre, :cedula, :resultado, :fecha)";

    // Preparar la consulta
    $stmt = $conn->prepare($query);

    // Enlazar los parámetros
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':resultado', $resultado);
    $stmt->bindParam(':fecha', $fecha);
  
    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Datos agregados exitosamente.";
        header("Location: index.php"); // Redirigir a la página principal para ver los datos
        exit();
    } else {
        echo "Error al agregar los datos.";
    }
}
?>
