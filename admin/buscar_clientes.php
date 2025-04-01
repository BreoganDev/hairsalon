<?php
// Conectar a la base de datos
include('model/conexion.php');

// Obtener el término de búsqueda desde el parámetro GET
$term = isset($_GET['term']) ? $_GET['term'] : '';

// Preparar la consulta para buscar clientes por nombre o apellidos
$sql = "SELECT nombre, apellidos, telefono FROM clientes WHERE nombre LIKE ? OR apellidos LIKE ? LIMIT 10";
$stmt = $db->prepare($sql);
$searchTerm = '%' . $term . '%';
$stmt->execute([$searchTerm, $searchTerm]);

// Obtener los resultados
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Asegurar que el resultado sea devuelto como JSON
header('Content-Type: application/json');

// Devolver los resultados en formato JSON
echo json_encode($resultados);
?>
