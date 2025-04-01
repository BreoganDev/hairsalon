<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/chatbot.css"> <!-- CSS personalizado -->

    <title>Cuestionario Diagnóstico</title>
</head>
<body>
<a class="logotipo" href="#"><img src="../img/lgs.png" alt="Grissel Santana"></a>
    <div class="container-fluid chat-container">
    
        <div class="chat-box">
            <!-- Aquí se mostrarán los mensajes -->
            <div class="chat-content" id="chat-box"></div> <!-- Añadimos el id correcto -->

            <!-- Formulario para enviar los mensajes -->
            <form id="chat-form">
                <div class="input-box">
                    <input type="text" id="user-input" class="form-control" placeholder="Escribe tu mensaje...">
                    <button type="submit" id="send-btn" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../js/chatbot.js"></script> <!-- Archivo JavaScript para manejar el chatbot -->
</body>
</html>
