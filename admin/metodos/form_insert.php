
<form action="metodos/insert.php" method="post">
    <p class="text-danger"><b>Los datos con (*) son obligatorios.</b></p>

    <div class="form-group">
        <label for="nombre">Nombre *</label>
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe tus nombres" required>
        <small class="form-text text-muted">Si tienes dos nombres, colócalos aquí.</small>
    </div>

    <div class="form-group">
        <label for="apellidos">Apellidos *</label>
        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Escribe tu apellido paterno y materno" required>
        <small class="form-text text-muted">Coloca tus apellidos.</small>
    </div>

    <div class="form-group">
        <label for="telefono">Teléfono *</label>
        <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="El número de telefono" required>
    </div>

    <div class="form-group">
        <label for="servicio">Selecciona un servicio *</label>
        <select class="custom-select" id="servicio" name="servicio" required>
            <option value="" selected>Elige...</option>
            <option <option value="mechas">Mechas</option>
    <option value="alisado">Alisado</option>
    <option value="color">Color</option>
    <option value="color+peinar">Color + Peinar</option>
    <option value="color+peinar+cortar">Color + Peinar + Cortar</option>
    <option value="matizar">Matizar</option>
    <option value="matizar+peinar">Matizar + Peinar</option>
    <option value="matizar+peinar+cortar">Matizar + Peinar + Cortar</option>
    <option value="cortar">Cortar</option>
    <option value="contouring">Contouring</option>
        </select>
    </div>

    <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
                <div id="mensaje-error" style="color: red;"></div>
    </div>

    <div class="form-group">
        <label for="hora">Hora:</label>
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

    <div class="form-group">
    <label for="color">Color *</label>
    <select class="form-control" id="color" name="color" required>
        <option value="" selected>Elige un color</option>
        <option value="red">Rojo</option>
        <option value="green">Verde</option>
        <option value="blue">Azul</option>
        <option value="yellow">Amarillo</option>
        <!-- Agrega más opciones de color aquí -->
    </select>
</div>

    <div class="form-group">
        <label for="mensaje">Mensaje adicional:</label>
        <textarea class="form-control" id="mensaje" name="mensaje" rows="3"></textarea>
    </div>
    <input type="hidden" name="estado" value="Pendiente">
    <input type="hidden" name="oculto" value="1">
    <button type="reset" class="btn btn-warning">Limpiar</button>
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>


<script>
document.addEventListener("DOMContentLoaded", function() {
    // Función para validar si la fecha es válida
    function esFechaValida(fecha) {
        return fecha instanceof Date && !isNaN(fecha);
    }

    // Función para validar la fecha
    function validarFecha() {
        var fechaInput = document.getElementById("fecha");
        // Dividimos la entrada para evitar conversiones de zona horaria
        var partesFecha = fechaInput.value.split('-');
        // Creamos la fecha en UTC
        var fechaSeleccionada = new Date(Date.UTC(partesFecha[0], partesFecha[1] - 1, partesFecha[2]));
        var mensajeError = document.getElementById("mensaje-error");

        if (!esFechaValida(fechaSeleccionada)) {
            mensajeError.textContent = "Por favor, introduce una fecha válida.";
            fechaInput.value = "";
            return;
        }

        var diaSemana = fechaSeleccionada.getUTCDay(); // Usamos getUTCDay para obtener el día en UTC

        /*
            0: Domingo
            1: Lunes
            2: Martes
            3: Miércoles
            4: Jueves
            5: Viernes
            6: Sábado
        */

        // Coloca únicamente los dias que deseas habilitar
        if (diaSemana !== 1 && diaSemana !== 2 && diaSemana !== 3 && diaSemana !== 4 && diaSemana !== 5 && diaSemana !==6) {
            fechaInput.value = ""; // Borrar la fecha seleccionada
            mensajeError.textContent = "Este día no se cuenta con servicio, selecciona uno distinto.";
        } else {
            mensajeError.textContent = "";
        }
    }

    // Agregar un evento onchange al campo de fecha
    document.getElementById("fecha").addEventListener("change", validarFecha);
});

</script>

