<?php

// Configuración de la base de datos
$user = 'u590131054_root';
$pass = 'Rosdeli2020';
$namedb = 'u590131054_bot';

// Conexión a la base de datos utilizando PDO
try {
    $db = new PDO('mysql:host=localhost;dbname=' . $namedb, $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $error) {
    echo 'Error en la conexión: ' . $error->getMessage();
    die();
}

?>