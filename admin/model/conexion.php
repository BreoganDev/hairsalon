<?php
// Archivo: db_connection.php

$pass = 'Rosdeli2020';
$user = 'u590131054_root_hostinger';
$namedb = 'u590131054_citas';

try {
    $db = new PDO('mysql:host=localhost;dbname='.$namedb, $user, $pass);
} catch (Exception $error) {
    echo 'Error en la conexión: ' . $error->getMessage();
    die();
}
?>
