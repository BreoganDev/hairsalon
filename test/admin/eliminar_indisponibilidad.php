<?php
include('model/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'], $_POST['peluquera'])) {
        $id = $_POST['id'];
        $peluquera = $_POST['peluquera'];

        // Determinar la tabla en la que eliminar
        if ($peluquera === "grissel") {
            $tabla = "disponibilidad_grissel";
        } elseif ($peluquera === "judith") {
            $tabla = "disponibilidad_judith";
        } else {
            die("Error: Peluquera no válida.");
        }

        try {
            $sql = "DELETE FROM $tabla WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);

            // Redirigir de vuelta a la lista después de la eliminación
            header('Location: listar_indisponibilidad.php?deleted=' . $peluquera);
            exit();
        } catch (PDOException $e) {
            echo 'Error al eliminar la disponibilidad: ' . $e->getMessage();
        }
    } else {
        echo 'Error: ID o peluquera no especificados.';
    }
}
?>
