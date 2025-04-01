<?php
// Incluir conexión a la base de datos
include("model/conexion.php");

try {
    // Consulta SQL para obtener todas las clientas, incluyendo la columna "notas"
    $sql = "SELECT id, nombre, apellidos, telefono, email, notas FROM clientes";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $clientas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientas</title>
    
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Fuente Krub de Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Krub:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Krub', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-weight: 600;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ccc;
        }

        table th {
            background-color: #f1f1f1;
            font-weight: 600;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: #ff69b4;
            border: none;
            margin-right: 10px;
        }

        .btn-primary:hover {
            background-color: #ff4881;
        }

        .btn-danger {
            background-color: #ff4d4d;
            border: none;
        }

        .btn-danger:hover {
            background-color: #ff1a1a;
        }

        .btn-container {
            text-align: right;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        /* Responsivo */
        @media (max-width: 768px) {
            table th, table td {
                padding: 10px;
            }

            .btn {
                font-size: 0.85rem;
                padding: 7px 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Lista de Clientas</h1>

    <!-- Barra de búsqueda -->
    <input type="text" id="buscar" class="form-control search-bar" placeholder="Buscar clienta por nombre, apellidos, teléfono o email...">

    <!-- Tabla para mostrar la lista de clientas -->
    <table class="table table-bordered" id="tabla-clientas">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Notas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientas as $clienta) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($clienta['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($clienta['apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($clienta['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($clienta['email']); ?></td>
                    <td><?php echo htmlspecialchars($clienta['notas']); ?></td>
                    <td>
                        <a href="modificar_clienta.php?id=<?php echo $clienta['id']; ?>" class="btn btn-primary">Modificar</a>
                        <a href="eliminar_clienta.php?id=<?php echo $clienta['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta clienta?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="btn-container">
        <a href="registrar_cliente.php" class="btn btn-primary">Registrar Nueva Clienta</a>
        <a href="inicio.php" class="btn btn-secondary">Regresar</a> <!-- Botón Regresar -->
    </div>
</div>

<!-- Incluir jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Filtro de búsqueda -->
<script>
document.getElementById("buscar").addEventListener("keyup", function() {
    var valorBusqueda = this.value.toLowerCase();
    var filas = document.querySelectorAll("#tabla-clientas tbody tr");

    filas.forEach(function(fila) {
        var textoFila = fila.textContent.toLowerCase();
        fila.style.display = textoFila.includes(valorBusqueda) ? "" : "none";
    });
});
</script>

</body>
</html>
