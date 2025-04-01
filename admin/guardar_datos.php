<?php
// Incluir archivo de conexión a la base de datos
include 'conex_bot.php';

// Obtener los datos enviados por Ajax
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si los datos existen
if ($data) {
    // Insertar los datos en la base de datos
    $sql = "INSERT INTO cuestionario_respuestas (nombre, apellidos, telefono, conociste, tratamiento, red_social, reaccion_tinte, alergias, dermatitis, tipo_dermatitis, alisado, tiempo_alisado, champu) 
            VALUES (:nombre, :apellidos, :telefono, :conociste, :tratamiento, :red_social, :reaccion_tinte, :alergias, :dermatitis, :tipo_dermatitis, :alisado, :tiempo_alisado, :champu)";
    
    $stmt = $db->prepare($sql);
    
    $stmt->bindParam(':nombre', $data['nombre']);
    $stmt->bindParam(':apellidos', $data['apellidos']);
    $stmt->bindParam(':telefono', $data['telefono']);
    $stmt->bindParam(':conociste', $data['conociste']);
    $stmt->bindParam(':tratamiento', implode(", ", $data['tratamiento'])); // Guardar como string separado por comas
    $stmt->bindParam(':red_social', $data['redSocial']);
    $stmt->bindParam(':reaccion_tinte', $data['reaccionTinte']);
    $stmt->bindParam(':alergias', $data['alergias']);
    $stmt->bindParam(':dermatitis', $data['dermatitis']);
    $stmt->bindParam(':tipo_dermatitis', $data['tipoDermatitis']);
    $stmt->bindParam(':alisado', $data['alisado']);
    $stmt->bindParam(':tiempo_alisado', $data['tiempoAlisado']);
    $stmt->bindParam(':champu', $data['champu']);

    if ($stmt->execute()) {
        echo "Datos guardados exitosamente.";
    } else {
        echo "Error al guardar los datos.";
    }
} else {
    echo "No se recibieron datos.";
}
?>
