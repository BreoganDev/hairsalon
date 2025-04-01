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
    $mensajeAdicional = $_POST['mensaje'] ?? '';

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
    $hora_inicio_dt = new DateTime($hora);
    $hora_fin_dt = clone $hora_inicio_dt;
    $hora_fin_dt->add(new DateInterval('PT' . $duracion . 'M')); // Sumar la duración en minutos
    $hora_fin = $hora_fin_dt->format('H:i:s');

    // Verificar si el cliente ya existe
    try {
        $sqlCliente = "SELECT id FROM clientes WHERE telefono = ?";
        $stmtCliente = $db->prepare($sqlCliente);
        $stmtCliente->execute([$telefono]);
        $clienteExistente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

        if (!$clienteExistente) {
            // Si no existe, registrar el nuevo cliente
            $sqlNuevoCliente = "INSERT INTO clientes (nombre, apellidos, telefono) VALUES (?, ?, ?)";
            $stmtNuevoCliente = $db->prepare($sqlNuevoCliente);
            $stmtNuevoCliente->execute([$nombre, $apellidos, $telefono]);

            // Obtener el ID del cliente recién creado
            $clienteId = $db->lastInsertId();
        } else {
            // Si ya existe, usar su ID
            $clienteId = $clienteExistente['id'];
        }

        // Ahora registrar la cita con la hora de fin
        $sqlCita = "INSERT INTO reservas (cliente_id, Nombre, apellidos, telefono, servicio, fecha, hora, HoraFin, peluquera, estado, MensajeAdicional) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtCita = $db->prepare($sqlCita);
        $stmtCita->execute([$clienteId, $nombre, $apellidos, $telefono, $servicio, $fecha, $hora, $hora_fin, $peluquera, $estado, $mensajeAdicional]);

        echo "<div class='alert alert-success'>Cita registrada correctamente.</div>";
        // Redirigir después de unos segundos
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Cita</title>
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Incluir jQuery UI para el autocompletado -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        body {
            font-family: 'Krub', sans-serif;
            background-color: #f7f9fc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            margin: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            font-weight: bold;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        label {
            font-weight: bold;
            color: #666;
        }

        .form-control {
            border-radius: 8px;
            font-size: 1rem;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #ff69b4;
            box-shadow: 0 0 8px rgba(255, 105, 180, 0.5);
        }

        select.custom-select {
            border-radius: 8px;
        }

        .btn {
            border-radius: 8px;
            padding: 10px;
            font-size: 1.1rem;
        }

        .btn-warning {
            background-color: #ffb84d;
            border: none;
        }

        .btn-warning:hover {
            background-color: #ff9f33;
        }

        .btn-primary {
            background-color: #ff69b4;
            border: none;
        }

        .btn-primary:hover {
            background-color: #ff4881;
        }

        .text-muted {
            font-size: 0.85rem;
            color: #777;
        }

        .card {
            border: none;
        }

        /* Sombra al contenedor en hover */
        .container:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        /* Responsivo */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            h2 {
                font-size: 1.5rem;
            }

            .form-control {
                font-size: 0.95rem;
            }

            .btn {
                font-size: 1rem;
            }
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
                <small class="form-text text-muted">Si tienes dos nombres, colócalos aquí.</small>
            </div>

            <!-- Campo de apellidos -->
            <div class="form-group">
                <label for="apellidos">Apellidos *</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Escribe tu apellido paterno y materno" required>
                <small class="form-text text-muted">Coloca tus apellidos.</small>
            </div>

            <!-- Campo de teléfono -->
            <div class="form-group">
                <label for="telefono">Teléfono *</label>
                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="El número de teléfono" require>
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
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
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
                    <option value="Judith">Judith</option>
                    <option value="Grissel">Grissel</option>
                </select>
            </div>

            <!-- Campo para mensaje adicional -->
            <div class="form-group">
                <label for="mensaje">Mensaje adicional</label>
                <textarea class="form-control" id="mensaje" name="mensaje" rows="3"></textarea>
            </div>
            
            <!-- Botones de limpiar y enviar -->
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
                var fechaSeleccionada = new Date(partesFecha[0], partesFecha[1] - 1, partesFecha[2]);
                var mensajeError = document.getElementById("mensaje-error");

                if (!esFechaValida(fechaSeleccionada)) {
                    mensajeError.textContent = "Por favor, introduce una fecha válida.";
                    fechaInput.value = "";
                    return;
                }

                var diaSemana = fechaSeleccionada.getDay(); 

                // Bloquear domingos
                if (diaSemana === 0) {
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
    // Autocompletado para el campo de nombre
    $("#nombre").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "buscar_clientes.php",  // Archivo PHP que devuelve los resultados
                dataType: "json",
                data: {
                    term: request.term  // Enviar el término de búsqueda
                },
                success: function(data) {
                    // Formatear los resultados para el autocompletado
                    response($.map(data, function(item) {
                        return {
                            label: item.nombre + " " + item.apellidos,  // Mostrar nombre y apellidos
                            value: item.nombre,  // Establecer solo el nombre en el campo de entrada
                            apellidos: item.apellidos,  // Añadir los apellidos para autocompletar
                            telefono: item.telefono  // Añadir el teléfono para autocompletar
                        };
                    }));
                }
            });
        },
        minLength: 2,  // Comenzar la búsqueda después de 2 caracteres
        select: function(event, ui) {
            // Establecer el valor seleccionado en los campos correspondientes
            $("#nombre").val(ui.item.value);  // Solo el nombre
            $("#apellidos").val(ui.item.apellidos);  // Completar el campo de apellidos
            $("#telefono").val(ui.item.telefono);  // Completar el campo de teléfono
        }
    });
});

</script>
</body>
</html>
