<?php
include("../model/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    // Verificar si la fecha de fin está presente
    if ($end) {
        $sql = "UPDATE reservas SET Fecha = ?, HoraFin = ? WHERE ID = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$start, $end, $id]);
    } else {
        $sql = "UPDATE reservas SET Fecha = ? WHERE ID = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$start, $id]);
    }

    if ($stmt->rowCount() > 0) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
