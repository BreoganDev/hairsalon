<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';
$peluquera = isset($_GET['peluquera']) ? $_GET['peluquera'] : '';

// Incluir conexión a la base de datos
include('model/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $servicio = $_POST['servicio'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $estado = $_POST['estado'];
    $peluquera = $_POST['peluquera'];
    $mensajeAdicional = isset($_POST['mensaje']) ? $_POST['mensaje'] : '';

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
    
    if (!array_key_exists($servicio, $duraciones_servicios)) {
        die("Error: Servicio no válido.");
    }
    $duracion = $duraciones_servicios[$servicio];
    
    // Convertir la hora recibida a formato H:i:s
    $hora_formatted = (new DateTime($hora))->format('H:i:s');
    
    // Calcular la hora de fin sumando la duración del servicio
    $hora_inicio_dt = new DateTime($hora);
    $hora_fin_dt = clone $hora_inicio_dt;
    $hora_fin_dt->add(new DateInterval('PT' . $duracion . 'M'));
    $hora_fin = $hora_fin_dt->format('H:i:s');
    
    // Validación de indisponibilidad para cada peluquera
    if (strtolower($peluquera) === 'grissel') {
        $sqlIndisponibilidad = "SELECT COUNT(*) FROM disponibilidad_grissel 
                                WHERE fecha = ? 
                                  AND ? < hora_fin 
                                  AND ? > hora_inicio";
        $stmtIndisponibilidad = $db->prepare($sqlIndisponibilidad);
        $stmtIndisponibilidad->execute([$fecha, $hora_formatted, $hora_fin]);
        $overlap = $stmtIndisponibilidad->fetchColumn();
        
        if ($overlap > 0) {
            die("<div class='alert alert-danger'>Error: El horario seleccionado se encuentra en un periodo de indisponibilidad para Grissel.</div>");
        }
    } elseif (strtolower($peluquera) === 'judith') {
        $sqlIndisponibilidad = "SELECT COUNT(*) FROM disponibilidad_judith 
                                WHERE fecha = ? 
                                  AND ? < hora_fin 
                                  AND ? > hora_inicio";
        $stmtIndisponibilidad = $db->prepare($sqlIndisponibilidad);
        $stmtIndisponibilidad->execute([$fecha, $hora_formatted, $hora_fin]);
        $overlap = $stmtIndisponibilidad->fetchColumn();
        
        if ($overlap > 0) {
            die("<div class='alert alert-danger'>Error: El horario seleccionado se encuentra en un periodo de indisponibilidad para Judith.</div>");
        }
    }
    
    try {
        // Verificar si el cliente ya existe
        $sqlCliente = "SELECT id FROM clientes WHERE telefono = ?";
        $stmtCliente = $db->prepare($sqlCliente);
        $stmtCliente->execute([$telefono]);
        $clienteExistente = $stmtCliente->fetch(PDO::FETCH_ASSOC);
        
        if (!$clienteExistente) {
            $sqlNuevoCliente = "INSERT INTO clientes (nombre, apellidos, telefono) VALUES (?, ?, ?)";
            $stmtNuevoCliente = $db->prepare($sqlNuevoCliente);
            $stmtNuevoCliente->execute([$nombre, $apellidos, $telefono]);
            $clienteId = $db->lastInsertId();
        } else {
            $clienteId = $clienteExistente['id'];
        }
        
        // Insertar la cita en la tabla reservas
        $sqlCita = "INSERT INTO reservas (cliente_id, Nombre, apellidos, telefono, servicio, fecha, hora, HoraFin, peluquera, estado, MensajeAdicional) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtCita = $db->prepare($sqlCita);
        $stmtCita->execute([$clienteId, $nombre, $apellidos, $telefono, $servicio, $fecha, $hora_formatted, $hora_fin, $peluquera, $estado, $mensajeAdicional]);
        
        echo "<div class='alert alert-success'>Cita registrada correctamente.</div>";
        header("refresh:3;url=inicio.php");
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error al registrar la cita: " . $e->getMessage() . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nueva Cita</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Incluir jQuery UI para autocompletar -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        body {
            font-family: 'Krub', sans-serif;
            background-color: #f7f9fc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            margin: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card p-4">
        <h2>Crear Nueva Cita</h2>
        <p class="text-danger text-center"><b>Los datos con (*) son obligatorios.</b></p>
        <form action="form_inserto.php" method="POST">
            <!-- Campo de nombre -->
            <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe tus nombres" required>
            </div>
            <!-- Campo de apellidos -->
            <div class="form-group">
                <label for="apellidos">Apellidos *</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Escribe tus apellidos" required>
            </div>
            <!-- Campo de teléfono -->
            <div class="form-group">
                <label for="telefono">Teléfono *</label>
                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Número de teléfono" required>
            </div>
            <!-- Selección del servicio -->
            <div class="form-group">
                <label for="servicio">Selecciona un servicio *</label>
                <select class="custom-select" id="servicio" name="servicio" required>
                    <option value="" selected>Elige...</option>
                    <option value="mechas">Mechas</option>
                    <option value="alisado">Alisado</option>
                    <option value="color">Color</option>
                    <option value="color+peinar">Color + Peinar</option>
                    <option value="color+peinar+cortar">Color + Peinar + Cortar</option>
                    <option value="matizar">Matizar</option>
                    <option value="matizar+peinar">Matizar + Peinar</option>
                    <option value="matizar+peinar+cortar">Matizar + Peinar + Cortar</option>
                    <option value="contouring">Contouring</option>
                    <option value="cortar">Cortar</option>
                    <option value="peinar">Peinar</option>
                    <option value="tratamiento">Tratamiento</option>
                    <option value="botulinica">Botulinica</option>
                    <option value="botulinica extra">Botulinica Extra</option>
                    <option value="cejas">Cejas</option>
                </select>
            </div>
            <!-- Campo de fecha -->
            <div class="form-group">
                <label for="fecha">Fecha de la cita:</label>
                <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>" required>
                <div id="mensaje-error" style="color: red;"></div>
            </div>
            <!-- Campo de hora -->
            <div class="form-group">
                <label for="hora">Hora *</label>
                <select class="form-control" id="hora" name="hora" required>
                    <option value="" selected>Elige la hora</option>
                    <option value="10:00">10:00</option>
                    <option value="10:30">10:30</option>
                    <option value="11:00">11:00</option>
                    <option value="11:30">11:30</option>
                    <option value="12:00">12:00</option>
                    <option value="12:30">12:30</option>
                    <option value="13:00">13:00</option>
                    <option value="13:30">13:30</option>
                    <option value="14:00">14:00</option>
                    <option value="14:30">14:30</option>
                    <option value="15:00">15:00</option>
                    <option value="15:30">15:30</option>
                    <option value="16:00">16:00</option>
                    <option value="16:30">16:30</option>
                    <option value="17:00">17:00</option>
                    <option value="17:30">17:30</option>
                    <option value="18:00">18:00</option>
                    <option value="18:30">18:30</option>
                    <option value="19:00">19:00</option>
                </select>
            </div>
            <!-- Campo de estado -->
            <div class="form-group">
                <label for="estado">Estado *</label>
                <select class="form-control" id="estado" name="estado" required>
                    <option value="" selected>Selecciona un estado</option>
                    <option value="Confirmada fianza">Confirmada fianza</option>
                    <option value="Pendiente de fianza">Pendiente de fianza</option>
                    <option value="No necesita fianza">No necesita fianza</option>
                    <option value="Promo">Promo</option>
                </select>
            </div>
            <!-- Selección de peluquera -->
            <div class="form-group">
                <label for="peluquera">Profesional *</label>
                <select class="form-control" id="peluquera" name="peluquera" required>
                    <option value="">Selecciona una peluquera</option>
                    <option value="Judith" <?php echo ($peluquera == 'Judith') ? 'selected' : ''; ?>>Judith</option>
                    <option value="Grissel" <?php echo ($peluquera == 'Grissel') ? 'selected' : ''; ?>>Grissel</option>
                </select>
            </div>
            <!-- Campo para mensaje adicional -->
            <div class="form-group">
                <label for="mensaje">Mensaje adicional</label>
                <textarea class="form-control" id="mensaje" name="mensaje" rows="3"></textarea>
            </div>
            <!-- Botones -->
            <button type="reset" class="btn btn-warning">Limpiar</button>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
        <!-- Validación de la fecha -->
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            function esFechaValida(fecha) {
                return fecha instanceof Date && !isNaN(fecha);
            }
            function validarFecha() {
                var fechaInput = document.getElementById("fecha");
                var partesFecha = fechaInput.value.split('-');
                var fechaSeleccionada = new Date(partesFecha[0], partesFecha[1]-1, partesFecha[2]);
                var mensajeError = document.getElementById("mensaje-error");
                if (!esFechaValida(fechaSeleccionada)) {
                    mensajeError.textContent = "Por favor, introduce una fecha válida.";
                    fechaInput.value = "";
                    return;
                }
                if (fechaSeleccionada.getDay() === 0) {
                    mensajeError.textContent = "No puedes seleccionar domingos.";
                    fechaInput.value = "";
                } else {
                    mensajeError.textContent = "";
                }
            }
            document.getElementById("fecha").addEventListener("change", validarFecha);
        });
        </script>
        <!-- Incluir jQuery y Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>
</div>
<!-- Autocompletado para el nombre -->
<script>
$(document).ready(function() {
    $("#nombre").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "buscar_clientes.php",
                dataType: "json",
                data: { term: request.term },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.nombre + " " + item.apellidos,
                            value: item.nombre,
                            apellidos: item.apellidos,
                            telefono: item.telefono
                        };
                    }));
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $("#nombre").val(ui.item.value);
            $("#apellidos").val(ui.item.apellidos);
            $("#telefono").val(ui.item.telefono);
        }
    });
});
</script>
</body>
</html>
