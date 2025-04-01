<?php
// Incluir el archivo de conexión a la base de datos
include 'conex_bot.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Verificar si la ID es válida
    if (!is_numeric($id) || $id <= 0) {
        echo "ID de cuestionario no válida";
        exit();
    }

    try {
        // Actualizar el estado de revisión del cuestionario
        $sql = "UPDATE cuestionario_respuestas SET revisado = TRUE WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Redirigir de vuelta a la página de cuestionarios
            header('Location: ver_cuestionarios.php');
            exit();
        } else {
            echo "Error al actualizar el cuestionario.";
        }
    } catch (PDOException $e) {
        echo "Error de base de datos: " . $e->getMessage();
    }
}
?>