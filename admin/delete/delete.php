<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//print_r($_GET);
//var_dump($_GET);

if (!isset($_GET["id"])) {
    die("No ID provided");
}

$EliminarRegistro = $_GET['id'];

include '../model/conexion.php';

$sentencia = $db->prepare('DELETE FROM reservas WHERE id = ?');

try {
    $resultado = $sentencia->execute([$EliminarRegistro]);
    if ($resultado) {
        //echo "Record deleted successfully";
        // Uncomment the next line when you're sure it's working
         header('Location: /admin/inicio.php');
        exit;
    } else {
        echo "Failed to delete record";
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>