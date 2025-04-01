<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si la sesión ya está iniciada antes de llamar a session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Iniciar sesión para acceder a las variables de sesión
}

// Incluir el archivo de conexión a la base de datos
include 'conex_bot.php';

// Obtener el nombre del usuario de la sesión, si está definido
$nombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario';

// Consulta para contar los cuestionarios que no han sido revisados
$sql = "SELECT COUNT(*) as pendientes FROM cuestionario_respuestas WHERE revisado = FALSE";
$stmt = $db->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
$pendientes = $resultado['pendientes'];
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<link rel="stylesheet" href="../css/navbaradmin.css">
<!-- Navbar -->
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">

    <a class="navbar-brand" href="#">Grissel Santana</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="collapsibleNavbar">

        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/admin/inicio.php">Inicio</a>
            </li>
            <!-- Diagnósticos con notificación -->
            <li class="nav-item">
                <a class="nav-link" href="/admin/ver_cuestionarios.php">
                    Diagnósticos 
                    <?php if ($pendientes > 0): ?>
                        <span class="badge badge-danger"><?php echo $pendientes; ?></span> <!-- Globo de notificación -->
                    <?php endif; ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/admin/cambiarPassword.php">Cambiar Contraseña</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" style="color:white">Bienvenido, <?php echo htmlspecialchars($nombre); ?>!</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-danger" href="metodos/cerrar_sesion.php">Cerrar Sesión</a>
            </li>
        </ul>
    </div>
</nav>
<!-- Include Bootstrap JS and dependencies -->
<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>


