<?php
// Incluir archivo de configuración de la base de datos
include("model/conexion.php");

try {
    // Obtener todas las indisponibilidades de Grissel
    $sqlGrissel = "SELECT id, fecha, hora_inicio, hora_fin, motivo FROM disponibilidad_grissel";
    $stmtGrissel = $db->prepare($sqlGrissel);
    $stmtGrissel->execute();
    $indisponibilidadesGrissel = $stmtGrissel->fetchAll(PDO::FETCH_ASSOC);

    // Obtener todas las indisponibilidades de Judith
    $sqlJudith = "SELECT id, fecha, hora_inicio, hora_fin, motivo FROM disponibilidad_judith";
    $stmtJudith = $db->prepare($sqlJudith);
    $stmtJudith->execute();
    $indisponibilidadesJudith = $stmtJudith->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indisponibilidades</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            margin: 20px;
            text-align: center;
        }

        .container {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .table-container {
            width: 45%;
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
         @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }
            .table-container {
                width: 100%;
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:hover {
            background-color: #f1f5f9;
        }

        .btn-eliminar {
            padding: 8px 12px;
            background-color: #FF5A5F;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-eliminar:hover {
            background-color: #E04E4E;
        }

        .btn-volver {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #28A745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-volver:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h2>Indisponibilidades de Grissel y Judith</h2>

<div class="container">
    <!-- Disponibilidades de Grissel -->
    <div class="table-container">
        <h3>Grissel</h3>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Motivo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($indisponibilidadesGrissel)): ?>
                    <?php foreach ($indisponibilidadesGrissel as $dispo): ?>
                        <tr>
                            <td><?= htmlspecialchars($dispo['fecha']); ?></td>
                            <td><?= htmlspecialchars($dispo['hora_inicio']); ?></td>
                            <td><?= htmlspecialchars($dispo['hora_fin']); ?></td>
                            <td><?= htmlspecialchars($dispo['motivo']); ?></td>
                            <td>
                                <form action="eliminar_indisponibilidad.php" method="post" onsubmit="return confirm('¿Eliminar esta disponibilidad?');">
                                    <input type="hidden" name="id" value="<?= $dispo['id']; ?>">
                                    <input type="hidden" name="peluquera" value="grissel">
                                    <button type="submit" class="btn-eliminar">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5">No hay disponibilidades registradas.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Disponibilidades de Judith -->
    <div class="table-container">
        <h3>Judith</h3>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Motivo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($indisponibilidadesJudith)): ?>
                    <?php foreach ($indisponibilidadesJudith as $dispo): ?>
                        <tr>
                            <td><?= htmlspecialchars($dispo['fecha']); ?></td>
                            <td><?= htmlspecialchars($dispo['hora_inicio']); ?></td>
                            <td><?= htmlspecialchars($dispo['hora_fin']); ?></td>
                            <td><?= htmlspecialchars($dispo['motivo']); ?></td>
                            <td>
                                <form action="eliminar_indisponibilidad.php" method="post" onsubmit="return confirm('¿Eliminar esta disponibilidad?');">
                                    <input type="hidden" name="id" value="<?= $dispo['id']; ?>">
                                    <input type="hidden" name="peluquera" value="judith">
                                    <button type="submit" class="btn-eliminar">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5">No hay disponibilidades registradas.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<a href="panel_grissel.php" class="btn-volver">Volver</a>

</body>
</html>
