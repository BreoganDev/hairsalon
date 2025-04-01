<?php

// Configuración de la base de datos
$user = 'root';
$pass = 'xxxxxx';
$namedb = 'bot';

// Conexión a la base de datos utilizando PDO
try {
    $db = new PDO('mysql:host=localhost;dbname=' . $namedb, $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $error) {
    echo 'Error en la conexión: ' . $error->getMessage();
    die();
}

?>
