<?php
require_once 'conex_bot.php';

$datos = json_decode(file_get_contents('php://input'), true);

$query = "INSERT INTO clientes (nombre, apellido, telefono, email, tipoCabello, colorCabello, tratamientoPrevio, objetivo, alergia) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $db->prepare($query);
$stmt->execute(array_values($datos));
?>
