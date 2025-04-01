<?php
// Incluir la conexión a la base de datos
include('model/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $notas = $_POST['notas'];

    try {
        // Verificar si ya existe una clienta con el mismo número de teléfono
        $sqlVerificarTelefono = "SELECT * FROM clientes WHERE telefono = ?";
        $stmtVerificar = $db->prepare($sqlVerificarTelefono);
        $stmtVerificar->execute([$telefono]);
        $clienteExistente = $stmtVerificar->fetch(PDO::FETCH_ASSOC);

        // Si el número de teléfono ya existe, no permitir el registro
        if ($clienteExistente) {
            echo "<div class='message error'>Error: Ya existe una clienta con este número de teléfono.</div>";
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'registrar_cliente.php';
                    }, 3000);
                </script>";
        } else {
            // Si el teléfono no existe, proceder con el registro
            $sql = "INSERT INTO clientes (nombre, apellidos, telefono, email, notas) VALUES (?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$nombre, $apellidos, $telefono, $email, $notas]);

            // Mensaje de éxito con estilo
            echo "<div class='message success'>Clienta registrada correctamente. Redirigiendo...</div>";

            // Redirección después de 3 segundos
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'registrar_cliente.php';
                    }, 3000);
                </script>";
        }
    } catch (PDOException $e) {
        echo "<div class='message error'>Error al registrar la clienta: " . $e->getMessage() . "</div>";
    }
}
?>

<!-- Estilos para los mensajes -->
<style>
    .message {
        padding: 15px;
        margin: 20px auto;
        width: 50%;
        text-align: center;
        border-radius: 8px;
        font-size: 1.2rem;
    }

    .success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>
