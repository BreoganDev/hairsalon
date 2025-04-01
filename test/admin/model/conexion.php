<?php
// Archivo: db_connection.php

$pass = 'Rosdeli2020';
$user = 'u590131054_test_hostinger';
$namedb = 'u590131054_citas_test';

try {
    $db = new PDO('mysql:host=localhost;dbname='.$namedb, $user, $pass);
} catch (Exception $error) {
    echo 'Error en la conexión: ' . $error->getMessage();
    die();
}
?>
