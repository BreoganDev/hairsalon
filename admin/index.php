<?php
session_start();

// Incluye el archivo de conexión a la base de datos
require_once 'model/conexion.php';

// Verificar si el usuario ya ha iniciado sesión
if (isset($_SESSION['usuario_id'])) {
    header("Location: inicio.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta para verificar el inicio de sesión
    $query = "SELECT * FROM usuarios WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            // Guardar información en la sesión
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];  // Guardar el nombre para el navbar

            // Redirigir al usuario al inicio
            header("Location: inicio.php");
            exit();
        } else {
            $error_message = "Contraseña incorrecta. Por favor, inténtalo de nuevo.";
        }
    } else {
        $error_message = "Nombre de usuario no encontrado. Por favor, regístrate o verifica tus credenciales.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inicio Sesión</title>
        <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fullcalendar.css">
    <style>
        .btn {
            display: block;
            width: 100%;
            margin-bottom: 1rem;
        }

        .cardi {
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .cardi-header {
            background-color: #007bff;
            color: #fff;
            padding: 1rem;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        .cardi-body {
            padding: 2rem;
        }

        .formi-control {
            border-radius: 0.5rem;
        }

        .logotipo {
            display: block;
            text-align: center;
        }

        .logotipo img {
            width: 150px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5 d-flex justify-content-center">
        <a class="logotipo" href="https://grisselsantanahairsalon.com">
            <img src="/img/logoGrissel.jpeg" alt="Grissel Santana">
        </a>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card cardi">
                    <div class="cardi-header text-center">Iniciar Sesión</div>
                    <div class="cardi-body">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="username">Nombre de usuario:</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="../" class="btn btn-warning">Regresar</a>
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                        </form>
                        <?php if (isset($error_message)) { ?>
                            <p class="text-danger mt-3 text-center"><?php echo $error_message; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
