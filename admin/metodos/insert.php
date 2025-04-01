<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

# Verificar si se ha enviado el formulario
if (!isset($_POST['oculto'])) {
    exit(); // Si no se ha enviado, salir del script.
}

# Incluir el archivo de conexión a la base de datos
include '../model/conexion.php';

# Obtener los datos del formulario
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$telefono = $_POST['telefono'];
$servicio = $_POST['servicio'];
$fecha = $_POST['fecha'];
$hora_inicio = $_POST['hora'];
$mensaje = $_POST['mensaje'];
$estado = $_POST['estado'];
$peluquera = $_POST['peluquera'];

# Convertir la fecha y hora en un objeto DateTime
$fechaHora = DateTime::createFromFormat('Y-m-d H:i', $fecha . ' ' . $hora_inicio);

if (!$fechaHora) {
    die("Error: Fecha u hora no válida.");
}

$diaSemana = $fechaHora->format('w'); // 0 para Domingo, 6 para Sábado

// Validar si es domingo
if ($diaSemana == 0) {
    die("Error: No se puede reservar en domingo. Por favor, selecciona otro día.");
}

// Validar si es sábado y la hora está fuera del rango 10:00 - 14:00
if ($diaSemana == 6) {
    $horaInicio = $fechaHora->format('H:i');
    if ($horaInicio < '10:00' || $horaInicio >= '14:00') {
        die("Error: Los sábados solo puedes reservar entre las 10:00 y las 14:00.");
    }
}

// Duraciones de servicios
$duraciones_servicios = [
    "mechas" => 240, 
    "alisado" => 240, 
    "color" => 60, 
    "color+peinar" => 90,
    "color+peinar+cortar" => 120, 
    "matizar" => 60, 
    "matizar+peinar" => 90, 
    "matizar+peinar+cortar" => 120, 
    "cortar" => 30, 
    "contouring" => 120, 
    "peinar" => 30, 
    "tratamiento" => 30, 
    "botulinica" => 30, 
    "botulinica extra" => 30, 
    "cejas" => 30 
];

// Verificar que el servicio existe en el array de duraciones
if (array_key_exists($servicio, $duraciones_servicios)) {
    $duracion = $duraciones_servicios[$servicio];
} else {
    die("Error: Servicio no válido.");
}

// Calcular hora de fin
$hora_inicio_dt = new DateTime($hora_inicio);
$hora_fin_dt = clone $hora_inicio_dt;
$hora_fin_dt->add(new DateInterval('PT' . $duracion . 'M')); 
$hora_fin = $hora_fin_dt->format('H:i:s'); 

try {
    // Verificar si el cliente ya está registrado
    $sql_cliente = "SELECT id FROM clientes WHERE nombre = ? AND apellidos = ? AND telefono = ?";
    $stmt_cliente = $db->prepare($sql_cliente);
    $stmt_cliente->execute([$nombre, $apellidos, $telefono]);

    if ($stmt_cliente->rowCount() > 0) {
        // El cliente existe
        $cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);
        $cliente_id = $cliente['id'];
    } else {
        // Si el cliente no existe, lo registramos
        $sql_nuevo_cliente = "INSERT INTO clientes (nombre, apellidos, telefono) VALUES (?, ?, ?)";
        $stmt_nuevo_cliente = $db->prepare($sql_nuevo_cliente);
        $stmt_nuevo_cliente->execute([$nombre, $apellidos, $telefono]);

        // Obtener el ID del nuevo cliente
        $cliente_id = $db->lastInsertId();
    }

    // Verificar la disponibilidad de Grissel
    $sql_indisponibilidad = "SELECT * FROM disponibilidad_grissel WHERE fecha = ? AND (
        (hora_inicio <= ? AND hora_fin > ?) OR
        (hora_inicio < ? AND hora_fin >= ?))";
    $stmt_indisponibilidad = $db->prepare($sql_indisponibilidad);
    $stmt_indisponibilidad->execute([$fecha, $hora_inicio, $hora_inicio, $hora_fin, $hora_fin]);

    if ($stmt_indisponibilidad->rowCount() > 0) {
        die("Error: Grissel no está disponible en este horario.");
    }

    // Insertar la reserva en la tabla
    $sql_reserva = "INSERT INTO reservas (Nombre, Apellidos, Telefono, Servicio, Fecha, Hora, HoraFin, Peluquera, MensajeAdicional, Estado, cliente_id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_reserva = $db->prepare($sql_reserva);
    $stmt_reserva->execute([$nombre, $apellidos, $telefono, $servicio, $fecha, $hora_inicio, $hora_fin, $peluquera, $mensaje, $estado, $cliente_id]);

    // Redirigir después de guardar
    header("Location: /admin/inicio.php");
    exit;

} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
}
