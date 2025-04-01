<?php
// Incluir el archivo de conexión a la base de datos
include 'conex_bot.php';

// Consulta SQL para obtener los datos de los cuestionarios
$sql = "SELECT * FROM cuestionario_respuestas ORDER BY fecha DESC";
$stmt = $db->prepare($sql);
$stmt->execute();

// Obtener todos los resultados
$cuestionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css"> <!-- Estilos personalizados -->

    <title>Cuestionarios Realizados</title>
</head>
<body>
<?php include "navbar.php"; ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <h1 class="mb-3 mb-md-0">Cuestionarios Pre-Diagnóstico</h1>
        <a href="inicio.php" class="btn btn-secondary">Regresar</a> <!-- Botón de Regresar -->
    </div>
        <!-- Verifica si hay cuestionarios -->
        <?php if (count($cuestionarios) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Teléfono</th>
                            <th>Cómo nos conoció</th>
                            <th>Tratamientos</th>
                            <th>Red Social</th>
                            <th>Reacción a Tinte</th>
                            <th>Alergias</th>
                            <th>Dermatitis</th>
                            <th>Alisado</th>
                            <th>Último Alisado</th>
                            <th>Champús</th>
                            <th>Fecha</th>
                            <th>Acciones</th> <!-- Nueva columna para el botón de eliminar -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Bucle para mostrar cada cuestionario -->
                        <?php foreach ($cuestionarios as $cuestionario): ?>
                            <tr>
                                <td><?php echo $cuestionario['id']; ?></td>
                                <td><?php echo $cuestionario['nombre']; ?></td>
                                <td><?php echo $cuestionario['apellidos']; ?></td>
                                <td><?php echo $cuestionario['telefono']; ?></td>
                                <td><?php echo $cuestionario['conociste']; ?></td>
                                <td><?php echo $cuestionario['tratamiento']; ?></td>
                                <td><?php echo $cuestionario['red_social']; ?></td>
                                <td><?php echo $cuestionario['reaccion_tinte']; ?></td>
                                <td><?php echo $cuestionario['alergias']; ?></td>
                                <td><?php echo $cuestionario['dermatitis']; ?></td>
                                <td><?php echo $cuestionario['alisado']; ?></td>
                                <td><?php echo $cuestionario['tiempo_alisado']; ?></td>
                                <td><?php echo $cuestionario['champu']; ?></td>
                                <td><?php echo $cuestionario['fecha']; ?></td>

                                <!-- Añadir un formulario en cada fila de cuestionario para marcar como revisado -->
                                <td>
                                    <form action="marcar_revisado.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $cuestionario['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-success">Revisado</button>
                                    </form>
                                </td>

                                <!-- Botón para eliminar -->
                                <td>
                                    <form action="eliminar_cuestionario.php" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este cuestionario?');">
                                        <input type="hidden" name="id" value="<?php echo $cuestionario['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No hay cuestionarios registrados.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
