<?php
// Incluir archivo de configuración de la base de datos
include("model/conexion.php");

try {
    // Consulta para obtener los días festivos desde la tabla holidays
    $sql_festivos = "SELECT 
        holiday_date AS start, 
        CONCAT(holiday_date, 'T10:00:00') AS start, 
        CONCAT(holiday_date, 'T20:00:00') AS end, 
        description AS title, 
        'holiday' AS event_type, 
        '#FF0000' AS color,
        true AS allDay 
    FROM holidays";
    $stmt_festivos = $db->prepare($sql_festivos);
    $stmt_festivos->execute();
    $festivos = $stmt_festivos->fetchAll(PDO::FETCH_ASSOC);

    // Consulta la disponibilidad de Grissel (sin alias duplicado)
    $sql_indisponibilidad_grissel = "SELECT 
        CONCAT(fecha, 'T', hora_inicio) AS start, 
        CONCAT(fecha, 'T', hora_fin) AS end, 
        'NO DISPONIBLE' AS title, 
        'indisponibilidad' AS event_type, 
        '#FF0000' AS color 
    FROM disponibilidad_grissel";
    $stmt_indisponibilidad_grissel = $db->prepare($sql_indisponibilidad_grissel);
    $stmt_indisponibilidad_grissel->execute();
    $indisponibilidad_grissel = $stmt_indisponibilidad_grissel->fetchAll(PDO::FETCH_ASSOC);
    
    // Consulta la disponibilidad de Judith
    $sql_indisponibilidad_judith = "SELECT 
        CONCAT(fecha, 'T', hora_inicio) AS start, 
        CONCAT(fecha, 'T', hora_fin) AS end, 
        'NO DISPONIBLE' AS title, 
        'indisponibilidad' AS event_type, 
        '#FF0000' AS color 
    FROM disponibilidad_judith";
    $stmt_indisponibilidad_judith = $db->prepare($sql_indisponibilidad_judith);
    $stmt_indisponibilidad_judith->execute();
    $indisponibilidad_judith = $stmt_indisponibilidad_judith->fetchAll(PDO::FETCH_ASSOC);

    // Consulta SQL para obtener las citas de la tabla "reservas" para Judith
    $sql_judith = "SELECT 
        ID AS id, 
        CONCAT(Nombre, ' ', Apellidos, ' - ', Servicio) AS title,  
        CONCAT(Fecha, 'T', Hora) AS start, 
        CONCAT(Fecha, 'T', HoraFin) AS end, 
        CASE 
            WHEN Servicio = 'Mechas' THEN '#FF5CA8' 
            WHEN Servicio = 'Alisado' THEN '#B6CCD7' 
            WHEN Servicio = 'Color' THEN '#FC4368' 
            WHEN Servicio = 'Color+Peinar' THEN '#FC4368' 
            WHEN Servicio = 'Color+Peinar+Cortar' THEN '#FC4368'
            WHEN Servicio = 'Matizar' THEN '#FF914D' 
            WHEN Servicio = 'Matizar+Peinar' THEN '#FF914D' 
            WHEN Servicio = 'Matizar+Peinar+Cortar' THEN '#FF914D' 
            WHEN Servicio = 'Cortar' THEN '#43B14B'
            WHEN Servicio = 'Peinar' THEN '#43B14B' 
            WHEN Servicio = 'Contouring' THEN '#5271FF' 
            WHEN Servicio = 'Tratamiento' THEN '#E0B0FF'
            WHEN Servicio = 'Botulinica' THEN '#A020F0'
            WHEN Servicio = 'Botulinica Extra' THEN '#A020F0'
            WHEN Servicio = 'Cejas' THEN '#572364'
            ELSE '#CCCCCC' 
        END AS color,
        MensajeAdicional AS mensaje
    FROM reservas 
    WHERE Peluquera = 'Judith'";
    $stmt_judith = $db->prepare($sql_judith);
    $stmt_judith->execute();
    $citas_judith = $stmt_judith->fetchAll(PDO::FETCH_ASSOC);

    // Consulta SQL para obtener las citas de la tabla "reservas" para Grissel
    $sql_grissel = "SELECT 
        ID AS id, 
        CONCAT(Nombre, ' ', Apellidos, ' - ', Servicio) AS title,  
        CONCAT(Fecha, 'T', Hora) AS start, 
        CONCAT(Fecha, 'T', HoraFin) AS end, 
        CASE 
            WHEN Servicio = 'Mechas' THEN '#FF5CA8' 
            WHEN Servicio = 'Alisado' THEN '#B6CCD7' 
            WHEN Servicio = 'Color' THEN '#FC4368' 
            WHEN Servicio = 'Color+Peinar' THEN '#FC4368' 
            WHEN Servicio = 'Color+Peinar+Cortar' THEN '#FC4368'
            WHEN Servicio = 'Matizar' THEN '#FF914D' 
            WHEN Servicio = 'Matizar+Peinar' THEN '#FF914D' 
            WHEN Servicio = 'Matizar+Peinar+Cortar' THEN '#FF914D' 
            WHEN Servicio = 'Cortar' THEN '#43B14B'
            WHEN Servicio = 'Peinar' THEN '#43B14B' 
            WHEN Servicio = 'Contouring' THEN '#5271FF' 
            WHEN Servicio = 'Tratamiento' THEN '#E0B0FF'
            WHEN Servicio = 'Botulinica' THEN '#A020F0'
            WHEN Servicio = 'Botulinica Extra' THEN '#A020F0'
            WHEN Servicio = 'Cejas' THEN '#572364'
            ELSE '#CCCCCC' 
        END AS color,
        MensajeAdicional AS mensaje
    FROM reservas 
    WHERE Peluquera = 'Grissel'";
    $stmt_grissel = $db->prepare($sql_grissel);
    $stmt_grissel->execute();
    $citas_grissel = $stmt_grissel->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
}
$db = null;

// Convertir arrays a JSON
$citas_json_judith = json_encode($citas_judith);
$citas_json_grissel = json_encode($citas_grissel);
$festivos_json = json_encode($festivos);
$indisponibilidad_json_grissel = json_encode($indisponibilidad_grissel);
$indisponibilidad_json_judith = json_encode($indisponibilidad_judith);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agenda de Citas</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        /* Estilos para centrar los calendarios */
        #calendar-judith, #calendar-grissel {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="row">
    <div class="col-md-6">
        <h3>Judith</h3>
        <div id='calendar-judith'></div>
    </div>
    <div class="col-md-6">
        <h3>Grissel</h3>
        <div id='calendar-grissel'></div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var holidays = <?php echo $festivos_json; ?>;
    var indisponibilidadJudith = <?php echo $indisponibilidad_json_judith; ?>;
    
    // Función para resaltar domingos y festivos
    function highlightDay(info) {
        var diaSemana = info.date.getDay();
        var fecha = info.dateStr;
        if (diaSemana === 0 || holidays.some(holiday => holiday.start.includes(fecha))) {
            info.el.style.backgroundColor = '#ff9f89';
        }
    }
    
    // Calendario para Judith
    var calendarElJudith = document.getElementById('calendar-judith');
    var calendarJudith = new FullCalendar.Calendar(calendarElJudith, {
        timeZone: 'local',
        initialView: 'dayGridMonth',
        firstDay: 1,
        // Incluir citas, festivos e indisponibilidades de Judith
        events: <?php echo json_encode(array_merge($citas_judith, $festivos, $indisponibilidad_judith)); ?>,
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        editable: true,
        slotMinTime: '10:00:00',
        slotMaxTime: '20:00:00',
        dayCellDidMount: function(info) {
            highlightDay(info);
        },
        select: function(info) {
            var fechaSeleccionada = info.startStr.split('T')[0];
            // En la vista de mes no se selecciona hora, por lo que se asume una hora por defecto (ejemplo: 10:00:00)
            var defaultDateTime = new Date(fechaSeleccionada + "T10:00:00");
            var esIndisponible = indisponibilidadJudith.some(function(event) {
                var start = new Date(event.start);
                var end = new Date(event.end);
                return defaultDateTime >= start && defaultDateTime < end;
            });
            if (holidays.some(holiday => holiday.start.includes(fechaSeleccionada)) ||
                info.start.getDay() === 0 || esIndisponible) {
                alert('No puedes reservar en días festivos, domingos o cuando Judith no está disponible.');
                calendarJudith.unselect();
            } else {
                window.location.href = "/admin/form_inserto.php?fecha=" + fechaSeleccionada + "&peluquera=Judith";
            }
        },
        dateClick: function(info) {
            var fechaSeleccionada = info.dateStr;
            // Asumir hora por defecto para verificar indisponibilidad
            var defaultDateTime = new Date(fechaSeleccionada + "T10:00:00");
            var esIndisponible = indisponibilidadJudith.some(function(event) {
                var start = new Date(event.start);
                var end = new Date(event.end);
                return defaultDateTime >= start && defaultDateTime < end;
            });
            if (holidays.some(holiday => holiday.start.includes(fechaSeleccionada)) ||
                info.date.getDay() === 0 || esIndisponible) {
                alert('No puedes reservar en días festivos, domingos o cuando Judith no está disponible.');
            } else {
                window.location.href = "/admin/form_inserto.php?fecha=" + fechaSeleccionada + "&peluquera=Judith";
            }
        },
        eventClick: function(info) {
            if (info.event.extendedProps.event_type === 'holiday') return;
            window.location.href = "/admin/update/form_update.php?id=" + info.event.id;
        },
        eventDrop: function(info) {
            var id = info.event.id;
            var nuevaFechaInicio = info.event.start.toISOString().slice(0, 19).replace('T', ' ');
            var nuevaFechaFin = info.event.end ? info.event.end.toISOString().slice(0, 19).replace('T', ' ') : null;
            $.ajax({
                url: 'update/update_event.php',
                method: 'POST',
                data: { id: id, start: nuevaFechaInicio, end: nuevaFechaFin },
                success: function(response) {
                    if (response === 'success') {
                        alert('Evento actualizado correctamente.');
                    } else {
                        alert('Error al actualizar el evento.');
                    }
                },
                error: function() {
                    alert('Error en la conexión al servidor.');
                }
            });
        },
        eventDidMount: function(info) {
            var mensajeAdicional = info.event.extendedProps.mensaje;
            if (mensajeAdicional) {
                info.el.querySelector('.fc-event-title').innerHTML += '<br>' + mensajeAdicional;
            }
        }
    });
    // Calendario para Grissel
    var indisponibilidadGrissel = <?php echo $indisponibilidad_json_grissel; ?>;
    var eventosGrissel = <?php echo $citas_json_grissel; ?>.concat(holidays, indisponibilidadGrissel);
    var calendarElGrissel = document.getElementById('calendar-grissel');
    var calendarGrissel = new FullCalendar.Calendar(calendarElGrissel, {
        timeZone: 'local',
        initialView: 'dayGridMonth',
        firstDay: 1,
        events: eventosGrissel,
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        editable: true,
        slotMinTime: '10:00:00',
        slotMaxTime: '20:00:00',
        dayCellDidMount: function(info) {
            highlightDay(info);
        },
        select: function(info) {
            var fechaSeleccionada = info.startStr.split('T')[0];
            var esDomingo = info.start.getDay() === 0;
            var esFestivo = holidays.some(holiday => holiday.start.includes(fechaSeleccionada));
            // Convertir los valores de indisponibilidad a objetos Date para comparar correctamente
            var esIndisponible = indisponibilidadGrissel.some(function(event) {
                var indisponibilidadStart = new Date(event.start);
                var indisponibilidadEnd = new Date(event.end);
                return (info.start >= indisponibilidadStart && info.end <= indisponibilidadEnd);
            });
            if (esDomingo || esFestivo || esIndisponible) {
                alert('No puedes reservar en domingos, festivos o durante la indisponibilidad de Grissel.');
                calendarGrissel.unselect();
            } else {
                window.location.href = "/admin/form_inserto.php?fecha=" + fechaSeleccionada + "&peluquera=Grissel";
            }
        },
        dateClick: function(info) {
            var fechaSeleccionada = info.dateStr;
            var esDomingo = info.date.getDay() === 0;
            var esFestivo = holidays.some(holiday => holiday.start.includes(fechaSeleccionada));
            var esIndisponible = indisponibilidadGrissel.some(function(event) {
                var indisponibilidadStart = new Date(event.start);
                var indisponibilidadEnd = new Date(event.end);
                return (info.date >= indisponibilidadStart && info.date <= indisponibilidadEnd);
            });
            if (esDomingo || esFestivo || esIndisponible) {
                alert('No puedes reservar en días festivos, domingos o cuando Grissel no está disponible.');
            } else {
                window.location.href = "/admin/form_inserto.php?fecha=" + fechaSeleccionada + "&peluquera=Grissel";
            }
        },
        eventClick: function(info) {
            if (info.event.extendedProps.event_type === 'indisponibilidad' || info.event.extendedProps.event_type === 'holiday') {
                alert('Este día no está disponible para reservas.');
                return;
            }
            window.location.href = "/admin/update/form_update.php?id=" + info.event.id;
        },
        eventDrop: function(info) {
            var id = info.event.id;
            var nuevaFechaInicio = info.event.start.toISOString().slice(0, 19).replace('T', ' ');
            var nuevaFechaFin = info.event.end ? info.event.end.toISOString().slice(0, 19).replace('T', ' ') : null;
            $.ajax({
                url: 'update/update_event.php',
                method: 'POST',
                data: { id: id, start: nuevaFechaInicio, end: nuevaFechaFin },
                success: function(response) {
                    if (response === 'success') {
                        alert('Evento actualizado correctamente.');
                    } else {
                        alert('Error al actualizar el evento.');
                    }
                },
                error: function() {
                    alert('Error en la conexión al servidor.');
                }
            });
        },
        eventDidMount: function(info) {
            var mensajeAdicional = info.event.extendedProps.mensaje;
            if (mensajeAdicional) {
                info.el.querySelector('.fc-event-title').innerHTML += '<br>' + mensajeAdicional;
            }
            if (info.event.extendedProps.event_type === 'indisponibilidad' || info.event.extendedProps.event_type === 'holiday') {
                info.el.style.backgroundColor = '#FF0000';
                info.el.style.borderColor = '#FF0000';
            }
        },
        eventRender: function(info) {
            if (info.event.extendedProps.event_type === 'indisponibilidad' || info.event.extendedProps.event_type === 'holiday') {
                info.event.setProp('display', 'background');
            }
        }
    });
    calendarJudith.render();
    calendarGrissel.render();
});
</script>
</body>
</html>
