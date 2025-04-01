<?php
// Archivo: db_connection.php

$pass = 'xxxxx';
$user = 'root';
$namedb = 'citas';

try {
    $db = new PDO('mysql:host=localhost;dbname='.$namedb, $user, $pass);
} catch (Exception $error) {
    echo 'Error en la conexión: ' . $error->getMessage();
    die();
}
?>
