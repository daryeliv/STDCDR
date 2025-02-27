<?php
// index.php
include 'conexion.php';

// Insertar datos cuando se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $resultado = $_POST['resultado'];
    $fecha = $_POST['fecha'];

    $query = "INSERT INTO resultados (nombre, cedula, resultado, fecha) VALUES (:nombre, :cedula, :resultado, :fecha)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':resultado', $resultado);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->execute();

    header('Location: index.php');
    exit();
}

// Consultar la base de datos
$query = "SELECT * FROM resultados";
$stmt = $conn->query($query);
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Eliminar un registro si se pasa el parámetro 'eliminar' por URL
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    try {
        // Preparar y ejecutar la consulta de eliminación
        $query = "DELETE FROM resultados WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Dato eliminado correctamente.";
        } else {
            echo "Error al eliminar el dato.";
        }
    } catch (PDOException $e) {
        // Captura y muestra el error
        echo "Error: " . $e->getMessage();
    }

    // Redirigir después de eliminar el dato para evitar duplicación
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Control de Resultados</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container">
    <h1>Sistema de Control de Resultados</h1>

    <!-- Gráfico -->
    <canvas id="graficoResultados" width="400" height="200"></canvas>

    <!-- Botón para mostrar el formulario -->
    <button onclick="mostrarFormulario()">Agregar Datos</button>

    <!-- Formulario oculto -->
    <div class="form-container" id="formularioAgregar" style="display:none;">
        <h2>Agregar Nuevo Resultado</h2>
        <form action="index.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required><br><br>

            <label for="cedula">Cédula:</label>
            <input type="text" name="cedula" required><br><br>

            <label for="resultado">Resultado:</label>
            <input type="text" name="resultado" required><br><br>

            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" required><br><br>

            <button type="submit">Agregar Datos</button>
        </form>
    </div>

    <!-- Tabla de resultados -->
    <table id="tablaResultados" class="display">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Resultado</th>
                <th>Fecha</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultados as $fila): ?>
                <tr>
                    <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($fila['cedula']); ?></td>
                    <td><?php echo htmlspecialchars($fila['resultado']); ?></td>
                    <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
                    <td>
                        <a href="modificar.php?id=<?php echo $fila['id']; ?>" class="modificar">Modificar</a>
                        <a href="?eliminar=<?php echo $fila['id']; ?>" class="eliminar" onclick="return confirm('¿Estás seguro de eliminar este dato?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    // Mostrar formulario al hacer clic
    function mostrarFormulario() {
        document.getElementById('formularioAgregar').style.display = 'block';
    }

    // Inicializar DataTable
    $(document).ready(function() {
        $('#tablaResultados').DataTable();
    });

    // Generar gráfico con Chart.js
    const ctx = document.getElementById('graficoResultados').getContext('2d');
    const datosResultados = <?php echo json_encode(array_column($resultados, 'resultado')); ?>;
    const nombres = <?php echo json_encode(array_column($resultados, 'nombre')); ?>;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: nombres,
            datasets: [{
                label: 'Resultados',
                data: datosResultados,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>
</html>
