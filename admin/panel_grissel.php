<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indisponibilidad</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: #fff;
            padding: 2em;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 1.5em;
        }

        label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }

        select,
        input[type="date"],
        input[type="time"],
        input[type="text"],
        input[type="submit"],
        a.btn {
            width: 100%;
            padding: 12px;
            margin-bottom: 1em;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            transition: all 0.3s ease;
            font-size: 16px;
            text-align: center;
        }

        select:focus,
        input[type="date"]:focus,
        input[type="time"]:focus,
        input[type="text"]:focus {
            border-color: #5a9bf4;
            box-shadow: 0 0 5px rgba(90, 155, 244, 0.5);
            outline: none;
        }

        input[type="submit"] {
            background-color: #5a9bf4;
            color: #fff;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #4a8ae3;
        }

        input[type="submit"]:active {
            background-color: #3979d2;
        }

        select,
        input[type="text"],
        input[type="date"],
        input[type="time"] {
            background-color: #f9fafc;
        }

        a.btn {
            display: block;
            text-decoration: none;
            font-weight: bold;
        }

        a.btn-regresar {
            background-color: #ccc;
            color: #333;
        }

        a.btn-regresar:hover {
            background-color: #bbb;
        }

        a.btn-regresar:active {
            background-color: #aaa;
        }

        a.btn-lista {
            background-color: #28a745;
            color: #fff;
        }

        a.btn-lista:hover {
            background-color: #218838;
        }

        a.btn-lista:active {
            background-color: #1e7e34;
        }

        .container {
            max-width: 400px;
            margin: auto;
            padding: 2rem;
        }
    </style>
</head>
<body>

<div class="container">
    <form action="guardar_disponibilidad.php" method="post">
        <h2>Indisponibilidad</h2>

        <label for="peluquera">Seleccionar Peluquera:</label>
        <select id="peluquera" name="peluquera" required>
            <option value="grissel">Grissel</option>
            <option value="judith">Judith</option>
        </select>

        <label for="fecha">Fecha de indisponibilidad:</label>
        <input type="date" id="fecha" name="fecha" required><br>

        <label for="hora_inicio">Hora de inicio:</label>
        <input type="time" id="hora_inicio" name="hora_inicio" required><br>

        <label for="hora_fin">Hora de fin:</label>
        <input type="time" id="hora_fin" name="hora_fin" required><br>

        <label for="motivo">Motivo (opcional):</label>
        <input type="text" id="motivo" name="motivo"><br>

        <input type="submit" value="Guardar">

        <!-- Botón para ver lista de indisponibilidades -->
        <a href="listar_indisponibilidad.php" class="btn btn-lista">Lista Indisponibilidades</a>

        <!-- Botón de regreso a inicio.php -->
        <a href="inicio.php" class="btn btn-regresar">Regresar a Inicio</a>
    </form>
</div>

</body>
</html>
