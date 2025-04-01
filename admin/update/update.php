<?php
# Verificar el envío de datos
print_r($_POST);

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../model/conexion.php");

if (isset($_POST["oculto"])) {
    header("Location: http://localhost:3000/admin/error.php");
}

// Verificación de los datos enviados
if (!isset($_POST['id2'], $_POST['nombre'], $_POST['apellidos'], $_POST['telefono'], $_POST['servicio'], $_POST['fecha'], $_POST['hora'], $_POST['peluquera'], $_POST['mensaje'], $_POST['estado'])) {
    echo "Error: Faltan datos en el formulario.";
    exit();
}

# Datos actualizados
$id2 = $_POST["id2"];
$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$telefono = $_POST["telefono"];
$servicio = $_POST["servicio"];
$fecha = $_POST["fecha"];
$hora_inicio = $_POST["hora"];
$peluquera = $_POST["peluquera"];
$mensaje = $_POST["mensaje"];
$estado = $_POST["estado"];

// Duraciones de los servicios en minutos
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

// Verificar si el servicio existe en el array de duraciones
if (array_key_exists($servicio, $duraciones_servicios)) {
    $duracion = $duraciones_servicios[$servicio];
} else {
    die("Error: Servicio no válido.");
}

// Calcular la hora de fin sumando la duración del servicio a la hora de inicio
$hora_inicio_dt = new DateTime($hora_inicio);
$hora_fin_dt = clone $hora_inicio_dt;
$hora_fin_dt->add(new DateInterval('PT' . $duracion . 'M')); // Sumar la duración en minutos
$hora_fin = $hora_fin_dt->format('H:i:s');

// Sentencia SQL para actualizar los registros, incluyendo la hora de fin
$sentencia = $db->prepare("UPDATE reservas SET Nombre=?, Apellidos=?, Telefono=?, Servicio=?, Fecha=?, Hora=?, HoraFin=?, Peluquera=?, MensajeAdicional=?, Estado=? WHERE ID=?;");
$resultado = $sentencia->execute([$nombre, $apellidos, $telefono, $servicio, $fecha, $hora_inicio, $hora_fin, $peluquera, $mensaje, $estado, $id2]);

# Validar una redirección en caso de que se actualicen correctamente los datos
if ($resultado === true) {
    header("Location: ../inicio.php");
} else {
    echo "Error no se pueden actualizar los registros";
}
?>
