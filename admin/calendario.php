<?php
// Incluir archivo de configuración de la base de datos
include("model/conexion.php");

try {
    
    // Consulta para obtener los días festivos desde la tabla holidays
    // Obtener los días festivos de la tabla holidays
$sql_festivos = "SELECT holiday_date AS start, 
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


    // Consulta la disponibilidad de Grissel

    $sql_indisponibilidad_grissel = "SELECT 
    fecha AS start, 
    CONCAT(fecha, 'T', hora_inicio) AS start, 
    CONCAT(fecha, 'T', hora_fin) AS end, 
    'NO DISPONIBLE' AS title, 
    'indisponibilidad' AS event_type, 
    '#FF0000' AS color 
FROM disponibilidad_grissel";

$stmt_indisponibilidad_grissel = $db->prepare($sql_indisponibilidad_grissel);
$stmt_indisponibilidad_grissel->execute();
$indisponibilidad_grissel = $stmt_indisponibilidad_grissel->fetchAll(PDO::FETCH_ASSOC);

// Obtener indisponibilidades de Judith
$sql_indisponibilidad_judith = "SELECT 
    fecha AS start, 
    CONCAT(fecha, 'T', hora_inicio) AS start, 
    CONCAT(fecha, 'T', hora_fin) AS end, 
    'NO DISPONIBLE' AS title, 
    'indisponibilidad' AS event_type, 
    '#FF69B4' AS color
FROM disponibilidad_judith";

$stmt_indisponibilidad_judith = $db->prepare($sql_indisponibilidad_judith);
$stmt_indisponibilidad_judith->execute();
$indisponibilidad_judith = $stmt_indisponibilidad_judith->fetchAll(PDO::FETCH_ASSOC);


    // Consulta SQL para obtener las citas de la tabla "Reservas" para Judith
    $sql_judith =  "SELECT ID AS id, CONCAT(Nombre, ' ', Apellidos, ' - ', Servicio) AS title,  
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


    // Obtener los días festivos de la tabla holidays
   // Consulta para obtener los días festivos desde la tabla holidays

   
    // Consulta SQL para obtener las citas de la tabla "Reservas" para Grissel
    $sql_grissel =  "SELECT ID AS id, CONCAT(Nombre, ' ', Apellidos, ' - ', Servicio) AS title,  
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
    // Manejo de errores de la base de datos
    echo "Error en la base de datos: " . $e->getMessage();
}

// Cierra la conexión a la base de datos
$db = null;

// Convierte las citas a formato JSON para que JavaScript las pueda utilizar
$citas_json_judith = json_encode($citas_judith);
$citas_json_grissel = json_encode($citas_grissel);
$festivos_json = json_encode($festivos);  // Festivos obtenidos de la base de datos
$indisponibilidad_json_grissel = json_encode($indisponibilidad_grissel);
$indisponibilidad_json_judith = json_encode($indisponibilidad_judith);

?>

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

<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>

<!-- Incluir jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Días festivos (YYYY-MM-DD)
    var holidays = <?php echo $festivos_json; ?>;

    


    function sombrearDiasFestivos(info) {
        // Usamos directamente info.dateStr que ya está en el formato correcto YYYY-MM-DD
        var diaSemana = info.date.getDay();

        // Sombrear domingos y días festivos
        if (diaSemana === 0) {
            info.el.style.backgroundColor = '#ff9f89'; // Sombreado domingos
        }
    }


    // Función para Judith
   var indisponibilidadJudith = <?php echo $indisponibilidad_json_judith; ?>;  // Indisponibilidad de Judith

// Validar si hay indisponibilidades antes de agregarlas
if (Array.isArray(indisponibilidadJudith) && indisponibilidadJudith.length > 0) {
    console.log("Eventos de indisponibilidad de Judith cargados correctamente:", indisponibilidadJudith);
} else {
    console.warn("No hay eventos de indisponibilidad para Judith en la base de datos.");
}

// Combinar eventos de citas, festivos y disponibilidad
 var holidays = <?php echo $festivos_json; ?>;  // Festivos desde la base de datos
    var indisponibilidadJudith = <?php 
    echo $indisponibilidad_json_judith; ?>;  // Indisponibilidad de Grissel

    var eventosCombinados = <?php echo $citas_json_judith; ?>.concat(holidays, indisponibilidadJudith);  // Combina las citas, festivos y la indisponibilidad

    var calendarElJudith = document.getElementById('calendar-judith');
    var calendarJudith = new FullCalendar.Calendar(calendarElJudith, {
        timeZone: 'local',  // Configurar la zona horaria local
        initialView: 'dayGridMonth',
        firstDay: 1,  // El lunes como primer día de la semana
        events: eventosCombinados,  // Usar la lista de eventos combinados
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        editable: true,
        slotMinTime: '10:00:00',  // Hora mínima para agendar
        slotMaxTime: '20:00:00',  // Hora máxima para agendar

        // Sombreado de domingos y festivos
        dayCellDidMount: function(info) {
            var diaSemana = info.date.getDay();
            var fecha = info.dateStr;

            // Sombrear domingos y festivos
            if (diaSemana === 0 || holidays.some(holiday => holiday.start === fecha)) {
                info.el.style.backgroundColor = '#ff9f89';  // Color de fondo para domingos y festivos
            }
        },

      select: function(info) {
    var fechaSeleccionada = info.startStr.split('T')[0];  // Obtener solo la fecha
    var horaSeleccionada = info.startStr.split('T')[1];  // Obtener solo la hora HH:MM:SS
    var esDomingo = info.start.getDay() === 0;
    var esFestivo = holidays.some(holiday => holiday.start.includes(fechaSeleccionada));

    // Verificar si está dentro del rango de indisponibilidad
    var esIndisponible = indisponibilidadJudith.some(function(event) {
        var eventFecha = event.start.split('T')[0];  // Extraer solo la fecha
        var eventHoraInicio = event.start.split('T')[1];  // Extraer solo la hora de inicio
        var eventHoraFin = event.end.split('T')[1];  // Extraer solo la hora de fin

        return (fechaSeleccionada === eventFecha && horaSeleccionada >= eventHoraInicio && horaSeleccionada < eventHoraFin);
    });

    if (esDomingo || esFestivo || esIndisponible) {
        alert('No puedes reservar en domingos, festivos o durante la indisponibilidad.');
        calendarJudith.unselect();  // Deseleccionar si es domingo, festivo o indisponibilidad
    } else {
        var peluquera = 'Judith';
        window.location.href = "/admin/form_inserto.php?fecha=" + fechaSeleccionada + "&hora=" + horaSeleccionada + "&peluquera=" + peluquera;
    }
},

dateClick: function(info) {
    var fechaSeleccionada = info.dateStr;
    var horaSeleccionada = info.date.getHours().toString().padStart(2, '0') + ":00:00";  // Formato HH:MM:SS
    var esDomingo = info.date.getDay() === 0;
    var esFestivo = holidays.some(holiday => holiday.start.includes(fechaSeleccionada));

    // Verificar si está dentro de la indisponibilidad
    var esIndisponible = indisponibilidadJudith.some(function(event) {
        var eventFecha = event.start.split('T')[0];  // Extraer la fecha del evento
        var eventHoraInicio = event.start.split('T')[1];  // Extraer la hora de inicio
        var eventHoraFin = event.end.split('T')[1];  // Extraer la hora de fin

        return (fechaSeleccionada === eventFecha && horaSeleccionada >= eventHoraInicio && horaSeleccionada < eventHoraFin);
    });

    if (esDomingo || esFestivo || esIndisponible) {
        alert('No puedes reservar en días festivos, domingos o cuando Judith no está disponible.');
    } else {
        var peluquera = 'Judith';
        window.location.href = "/admin/form_inserto.php?fecha=" + fechaSeleccionada + "&hora=" + horaSeleccionada + "&peluquera=" + peluquera;
    }
},


        // Previene acciones en eventos de tipo "holiday" (festivos)
        eventClick: function(info) {
            // Si es un evento de indisponibilidad o holiday, no hacer nada
            if (info.event.extendedProps.event_type === 'indisponibilidad' || info.event.extendedProps.event_type === 'holiday') {
                alert('Este día no está disponible para reservas.');
                return;  // Prevenir cualquier acción para estos eventos
            }

            // Para eventos normales, redirigir a form_update
            var eventId = info.event.id;
            window.location.href = "/admin/update/form_update.php?id=" + eventId;
        },

        eventDrop: function(info) {
            var id = info.event.id;
            var nuevaFechaInicio = info.event.start.toISOString().slice(0, 19).replace('T', ' ');
            var nuevaFechaFin = info.event.end ? info.event.end.toISOString().slice(0, 19).replace('T', ' ') : null;

            // Enviar actualización mediante AJAX
            $.ajax({
                url: 'update/update_event.php',
                method: 'POST',
                data: {
                    id: id,
                    start: nuevaFechaInicio,
                    end: nuevaFechaFin
                },
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
            if (info.event.extendedProps.event_type === 'indisponibilidad') {
                info.el.style.backgroundColor = '#FF69B4';  // Rojo para indisponibilidad
                info.el.style.borderColor = '#FF69B4';  // Asegura que el borde también sea rojo
            }
            if (info.event.extendedProps.event_type === 'holiday') {
                info.el.style.backgroundColor = '#FF0000';  // Rojo para holidays
                info.el.style.borderColor = '#FF0000';  // Asegura que el borde también sea rojo
            }
        },
        eventRender: function(info) {
            if (info.event.extendedProps.event_type === 'indisponibilidad' || info.event.extendedProps.event_type === 'holiday') {
                info.event.setProp('display', 'background');
            }
        }
    });


    // Función para Grissel
    var holidays = <?php echo $festivos_json; ?>;  // Festivos desde la base de datos
    var indisponibilidadGrissel = <?php 
    echo $indisponibilidad_json_grissel; ?>;  // Indisponibilidad de Grissel

    var eventosCombinados = <?php echo $citas_json_grissel; ?>.concat(holidays, indisponibilidadGrissel);  // Combina las citas, festivos y la indisponibilidad

    var calendarElGrissel = document.getElementById('calendar-grissel');
    var calendarGrissel = new FullCalendar.Calendar(calendarElGrissel, {
        timeZone: 'local',  // Configurar la zona horaria local
        initialView: 'dayGridMonth',
        firstDay: 1,  // El lunes como primer día de la semana
        events: eventosCombinados,  // Usar la lista de eventos combinados
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        editable: true,
        slotMinTime: '10:00:00',  // Hora mínima para agendar
        slotMaxTime: '20:00:00',  // Hora máxima para agendar

        // Sombreado de domingos y festivos
        dayCellDidMount: function(info) {
            var diaSemana = info.date.getDay();
            var fecha = info.dateStr;

            // Sombrear domingos y festivos
            if (diaSemana === 0 || holidays.some(holiday => holiday.start === fecha)) {
                info.el.style.backgroundColor = '#ff9f89';  // Color de fondo para domingos y festivos
            }
        },

       select: function(info) {
    var fechaSeleccionada = info.startStr.split('T')[0];  // Obtener solo la fecha
    var horaSeleccionada = info.startStr.split('T')[1];  // Obtener solo la hora HH:MM:SS
    var esDomingo = info.start.getDay() === 0;
    var esFestivo = holidays.some(holiday => holiday.start.includes(fechaSeleccionada));

    // Verificar si está dentro del rango de indisponibilidad
    var esIndisponible = indisponibilidadJudith.some(function(event) {
        var eventFecha = event.start.split('T')[0];  // Extraer solo la fecha
        var eventHoraInicio = event.start.split('T')[1];  // Extraer solo la hora de inicio
        var eventHoraFin = event.end.split('T')[1];  // Extraer solo la hora de fin

        return (fechaSeleccionada === eventFecha && horaSeleccionada >= eventHoraInicio && horaSeleccionada < eventHoraFin);
    });

    if (esDomingo || esFestivo || esIndisponible) {
        alert('No puedes reservar en domingos, festivos o durante la indisponibilidad.');
        calendarJudith.unselect();  // Deseleccionar si es domingo, festivo o indisponibilidad
    } else {
        var peluquera = 'Judith';
        window.location.href = "/admin/form_inserto.php?fecha=" + fechaSeleccionada + "&hora=" + horaSeleccionada + "&peluquera=" + peluquera;
    }
},

dateClick: function(info) {
    var fechaSeleccionada = info.dateStr;
    var horaSeleccionada = info.date.getHours().toString().padStart(2, '0') + ":00:00";  // Formato HH:MM:SS
    var esDomingo = info.date.getDay() === 0;
    var esFestivo = holidays.some(holiday => holiday.start.includes(fechaSeleccionada));

    // Verificar si está dentro de la indisponibilidad
    var esIndisponible = indisponibilidadJudith.some(function(event) {
        var eventFecha = event.start.split('T')[0];  // Extraer la fecha del evento
        var eventHoraInicio = event.start.split('T')[1];  // Extraer la hora de inicio
        var eventHoraFin = event.end.split('T')[1];  // Extraer la hora de fin

        return (fechaSeleccionada === eventFecha && horaSeleccionada >= eventHoraInicio && horaSeleccionada < eventHoraFin);
    });

    if (esDomingo || esFestivo || esIndisponible) {
        alert('No puedes reservar en días festivos, domingos o cuando Judith no está disponible.');
    } else {
        var peluquera = 'Judith';
        window.location.href = "/admin/form_inserto.php?fecha=" + fechaSeleccionada + "&hora=" + horaSeleccionada + "&peluquera=" + peluquera;
    }
},


        // Previene acciones en eventos de tipo "holiday" (festivos)
        eventClick: function(info) {
            // Si es un evento de indisponibilidad o holiday, no hacer nada
            if (info.event.extendedProps.event_type === 'indisponibilidad' || info.event.extendedProps.event_type === 'holiday') {
                alert('Este día no está disponible para reservas.');
                return;  // Prevenir cualquier acción para estos eventos
            }

            // Para eventos normales, redirigir a form_update
            var eventId = info.event.id;
            window.location.href = "/admin/update/form_update.php?id=" + eventId;
        },

        eventDrop: function(info) {
            var id = info.event.id;
            var nuevaFechaInicio = info.event.start.toISOString().slice(0, 19).replace('T', ' ');
            var nuevaFechaFin = info.event.end ? info.event.end.toISOString().slice(0, 19).replace('T', ' ') : null;

            // Enviar actualización mediante AJAX
            $.ajax({
                url: 'update/update_event.php',
                method: 'POST',
                data: {
                    id: id,
                    start: nuevaFechaInicio,
                    end: nuevaFechaFin
                },
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
            if (info.event.extendedProps.event_type === 'indisponibilidad') {
                info.el.style.backgroundColor = '#FF0000';  // Rojo para indisponibilidad
                info.el.style.borderColor = '#FF0000';  // Asegura que el borde también sea rojo
            }
            if (info.event.extendedProps.event_type === 'holiday') {
                info.el.style.backgroundColor = '#FF0000';  // Rojo para holidays
                info.el.style.borderColor = '#FF0000';  // Asegura que el borde también sea rojo
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
