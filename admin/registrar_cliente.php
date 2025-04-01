<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cliente</title>
    <style>
        /* Estilos generales del cuerpo */
        body {
            font-family: 'Krub', sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Estilos del contenedor principal */
        .form-container {
            background-color: #fff;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 100%;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        textarea:focus {
            border-color: #5a9bf4;
            box-shadow: 0 0 8px rgba(90, 155, 244, 0.5);
            outline: none;
        }

        /* Estilos del botón */
        input[type="submit"] {
            background-color: #ff69b4;
            color: #fff;
            border: none;
            font-weight: bold;
            padding: 0.8rem 0;
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #ff4881;
        }

        input[type="submit"]:active {
            background-color: #ff3063;
        }

        /* Efecto de sombra en hover para el contenedor */
        .form-container:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        /* Responsividad para móviles */
        @media (max-width: 480px) {
            .form-container {
                padding: 1.5rem;
                width: 100%;
            }

            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Registrar Nueva Clienta</h2>

    <form action="guardar_cliente.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">

        <label for="notas">Notas o Comentarios:</label>
        <textarea id="notas" name="notas" rows="4" placeholder="Añadir notas sobre la clienta"></textarea>

        <input type="submit" value="Guardar Cliente">
    </form>
</div>

</body>
</html>
