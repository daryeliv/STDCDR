<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener el resultado de la base de datos
    $query = "SELECT * FROM resultados WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    die('ID no especificado');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $resultado_val = $_POST['resultado'];
    $fecha = $_POST['fecha'];

    // Actualizar los datos en la base de datos
    $query = "UPDATE resultados SET nombre = :nombre, cedula = :cedula, resultado = :resultado, fecha = :fecha WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':resultado', $resultado_val);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Resultado</title>
    <link rel="stylesheet" href="styles.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <div class="form-container">
        <h1>Modificar Resultado</h1>

        <form method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $resultado['nombre']; ?>" required>

            <label for="cedula">Cédula:</label>
            <input type="text" name="cedula" value="<?php echo $resultado['cedula']; ?>" required>

            <label for="resultado">Resultado:</label>
            <input type="text" name="resultado" value="<?php echo $resultado['resultado']; ?>" required>

            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" value="<?php echo $resultado['fecha']; ?>" required>

            <button type="submit">Actualizar</button>
        </form>
    </div>
</body>
</html>
