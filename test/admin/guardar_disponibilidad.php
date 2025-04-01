<?php
include('model/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que los campos requeridos se envíen correctamente
    if (isset($_POST['fecha'], $_POST['hora_inicio'], $_POST['hora_fin'])) {
        $fecha = $_POST['fecha'];
        $hora_inicio = $_POST['hora_inicio'];
        $hora_fin = $_POST['hora_fin'];
        $motivo = isset($_POST['motivo']) ? $_POST['motivo'] : null;
        $peluquera = $_POST['peluquera']; // Obtener la peluquera del formulario


       // Validar que la hora de inicio sea anterior a la hora de fin
        if ($hora_inicio < $hora_fin) {
            try {
                // Determinar en qué tabla guardar los datos
                if ($peluquera === "grissel") {
                    $tabla = "disponibilidad_grissel";
                } elseif ($peluquera === "judith") {
                    $tabla = "disponibilidad_judith";
                } else {
                    die("Error: Peluquera no válida.");
                }

                // Insertar en la tabla correspondiente
                $sql = "INSERT INTO $tabla (fecha, hora_inicio, hora_fin, motivo) VALUES (?, ?, ?, ?)";
                $stmt = $db->prepare($sql);
                $stmt->execute([$fecha, $hora_inicio, $hora_fin, $motivo]);

                // Redirigir después de guardar los datos
                header('Location: panel_grissel.php?success=' . $peluquera);
                exit();
            } catch (PDOException $e) {
                echo 'Error al guardar los datos: ' . $e->getMessage();
            }
        } else {
            echo 'Error: La hora de inicio debe ser anterior a la hora de fin.';
        }
    } else {
        echo 'Error: Todos los campos son obligatorios.';
    }
}
?>
