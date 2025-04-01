<?php
// Incluir la conexión a la base de datos
include('model/conexion.php');

// Verificar si se ha pasado el ID de la clienta
if (!isset($_GET['id'])) {
    die('Error: No se ha proporcionado un ID de clienta.');
}

$id = $_GET['id'];

try {
    // Obtener los datos actuales de la clienta
    $sql = "SELECT nombre, apellidos, telefono, email, notas FROM clientes WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $clienta = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si la clienta existe
    if (!$clienta) {
        die('Error: Clienta no encontrada.');
    }
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
    die();
}

// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $notas = $_POST['notas'];

    try {
        // Actualizar los datos de la clienta en la base de datos
        $sql = "UPDATE clientes SET nombre = ?, apellidos = ?, telefono = ?, email = ?, notas = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$nombre, $apellidos, $telefono, $email, $notas, $id]);

        // Redirigir de vuelta a la lista de clientas después de la actualización
        header("Location: lista_clientas.php?mensaje=modificada");
        exit;
    } catch (PDOException $e) {
        echo "Error al actualizar los datos: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Clienta</title>
    
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
            max-width: 600px;
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

        label {
            font-weight: 500;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="email"], input[type="tel"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .btn-primary {
            background-color: #ff69b4;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #ff4881;
        }

        .btn-secondary {
            background-color: #ccc;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background-color: #bbb;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Modificar Clienta</h1>
    
    <form action="" method="post">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($clienta['nombre']); ?>" required>
        </div>

        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($clienta['apellidos']); ?>" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($clienta['telefono']); ?>">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($clienta['email']); ?>">
        </div>

        <div class="form-group">
        <label for="notas">Notas o Comentarios:</label>
        <textarea id="notas" name="notas" rows="4" placeholder="Añadir notas sobre la clienta"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="lista_clientas.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<!-- Incluir jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
