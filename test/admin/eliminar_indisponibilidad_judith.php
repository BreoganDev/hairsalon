<?php
include("model/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    try {
        // Eliminar la indisponibilidad por su ID
        $sql = "DELETE FROM disponibilidad_judith WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);

        // Redirigir de vuelta a la lista de indisponibilidades
        header("Location: listar_indisponibilidad_judith.php");
        exit();
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
}
?>
