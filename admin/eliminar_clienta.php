<?php
// Incluir la conexión a la base de datos
include('model/conexion.php');

// Verificar si se ha pasado el ID de la clienta
if (!isset($_GET['id'])) {
    die('Error: No se ha proporcionado un ID de clienta.');
}

$id = $_GET['id'];

try {
    // Eliminar la clienta de la base de datos
    $sql = "DELETE FROM clientes WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);

    // Redirigir de vuelta a la lista de clientas con un mensaje de éxito
    header("Location: lista_clientas.php?mensaje=eliminada");
    exit;
} catch (PDOException $e) {
    echo "Error al eliminar la clienta: " . $e->getMessage();
}
?>
