<?php
// Incluir el archivo de conexión a la base de datos
include 'conex_bot.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID enviado desde el formulario
    $id = $_POST['id'];

    // Consulta SQL para eliminar el cuestionario
    $sql = "DELETE FROM cuestionario_respuestas WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Ejecutar la consulta y verificar el resultado
    if ($stmt->execute()) {
        // Redirigir de vuelta a la página de cuestionarios después de la eliminación
        header('Location: ver_cuestionarios.php');
        exit();
    } else {
        echo "Error al eliminar el cuestionario.";
    }
}
?>
