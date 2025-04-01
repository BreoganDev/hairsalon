// Obtenemos los elementos HTML que usaremos
const chatBox = document.getElementById('chat-box');
const userInput = document.getElementById('user-input');
const chatForm = document.getElementById('chat-form');

// Guardamos los datos del usuario
let userData = {
    nombre: '',
    apellidos: '',
    telefono: '',
    conociste: '',
    tratamiento: [],
    redSocial: '',
    reaccionTinte: '',
    alergias: '',
    dermatitis: '',
    tipoDermatitis: '',
    alisado: '',
    tiempoAlisado: '',
    champu: ''
};

// Paso actual del formulario
let currentStep = 0;

// Preguntas del chatbot
const questions = [
    "¡Hola! Bienvenido/a, ¿puedo saber tu nombre?",
    "Gracias, ¿cuales son tus apellidos?",
    "¿Podrías facilitarme tu número de teléfono?",
    "¿Cómo nos has conocido? (Elige una opción: Amiga, Redes sociales, Google)",
    "Si nos conociste en Redes Sociales, ¿podrías indicar cuál? (Instagram, Facebook, TikTok, Google, Ninguna, No recuerdo)",
    "¿En qué tipo de tratamiento estás interesada? (Elige una o varias opciones)",
    "¿Has tenido alguna vez alguna reacción a un tinte o tratamiento capilar?",
    "Si has tenido reacciones alérgicas, ¿podrías describirlas?",
    "¿Tienes alguna clase de dermatitis?",
    "En caso de dermatitis, indica cuál es.",
    "¿Te has realizado algún tratamiento de alisado o keratina?",
    "¿Cuánto tiempo ha pasado desde tu último tratamiento de alisado o keratina?",
    "Indica el o los champús que utilizas en casa."
];

// Opciones para respuestas cerradas
const options = {
    conociste: ['Amiga', 'Redes sociales', 'Google'],
    redSocial: ['Instagram', 'Facebook', 'TikTok', 'Google', 'Ninguna', 'No recuerdo'],
    tratamiento: ['Mechas', 'Baby Light', 'Balayage', 'Alisado o Keratina', 'Tratamiento Capilar', 'Mix de anteriores', 'Color por primera vez', 'Aclarado', 'Otro'],
    reaccionTinte: ['Sí', 'No'],
    dermatitis: ['Sí', 'No', 'No lo sé'],
    alisado: ['Sí', 'No'],
    tiempoAlisado: ['menos de 1 mes', 'entre 1-3 meses', 'entre 3-6 meses', '+ de 6 meses']
};

// Función para mostrar los mensajes en el chat
function showMessage(message, sender = 'bot') {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add(sender === 'bot' ? 'bot-message' : 'user-message');
    messageDiv.textContent = message;
    chatBox.appendChild(messageDiv);
    chatBox.scrollTop = chatBox.scrollHeight;  // Desplazamiento automático hacia abajo
}

// Función para mostrar opciones seleccionables en el chat
function showOptions(options, step) {
    const optionsContainer = document.createElement('div');
    optionsContainer.classList.add('options-container');
    userInput.disabled = true; // Desactivar el campo de entrada

    options.forEach(option => {
        const optionButton = document.createElement('button');
        optionButton.textContent = option;
        optionButton.classList.add('option-button');
        optionButton.onclick = function () {
            handleUserInput(option, step);  // Envía el paso actual
        };
        optionsContainer.appendChild(optionButton);
    });
    chatBox.appendChild(optionsContainer);
    chatBox.scrollTop = chatBox.scrollHeight;
}

// Función para manejar las respuestas del usuario
function handleUserInput(input, step = null) {
    if (step !== null) {
        currentStep = step;  // Actualizar el paso actual al seleccionarse una opción
    }

    // Eliminar opciones anteriores al seleccionar una
    const oldOptions = document.querySelector('.options-container');
    if (oldOptions) oldOptions.remove();
    userInput.disabled = false;

    if (currentStep === 0) {
        userData.nombre = input;
        showMessage(`Encantado/a de conocerte, ${input}!`, 'user');
        setTimeout(() => showMessage(questions[1]), 1000);
    } else if (currentStep === 1) {
        userData.apellidos = input;
        showMessage(`Gracias, ${userData.nombre} ${input}.`, 'user');
        setTimeout(() => showMessage(questions[2]), 1000);
    } else if (currentStep === 2) {
        userData.telefono = input;
        showMessage(`Tu teléfono es ${input}.`, 'user');
        setTimeout(() => {
            showMessage(questions[3]);
            showOptions(options.conociste, 3);
        }, 1000);
        return;  // Detener para esperar selección
    } else if (currentStep === 3) {
        userData.conociste = input;
        showMessage(`Nos conociste a través de ${input}.`, 'user');
        if (input === 'Redes sociales') {
            setTimeout(() => {
                showMessage(questions[4]);
                showOptions(options.redSocial, 4);
            }, 1000);
            return;
        } else {
            setTimeout(() => {
                showMessage(questions[5]);
                showOptions(options.tratamiento, 5);
            }, 1000);
            return;
        }
    } else if (currentStep === 4) {
        userData.redSocial = input;
        showMessage(`Gracias por indicar ${input}.`, 'user');
        setTimeout(() => {
            showMessage(questions[5]);
            showOptions(options.tratamiento, 5);
        }, 1000);
        return;
    } else if (currentStep === 5) {
        userData.tratamiento.push(input);
        showMessage(`Gracias, estás interesada en ${input}.`, 'user');
        setTimeout(() => {
            showMessage(questions[6]);
            showOptions(options.reaccionTinte, 6);
        }, 1000);
        return;
    } else if (currentStep === 6) {
        userData.reaccionTinte = input;
        showMessage(`¿Reacción a tintes?: ${input}.`, 'user');
        if (input === 'Sí') {
            setTimeout(() => showMessage(questions[7]), 1000);
        } else {
            setTimeout(() => {
                showMessage(questions[8]);
                showOptions(options.dermatitis, 8);
            }, 1000);
        }
        return;
    } else if (currentStep === 7) {
        userData.alergias = input;
        showMessage(`Alergias descritas: ${input}.`, 'user');
        setTimeout(() => {
            showMessage(questions[8]);
            showOptions(options.dermatitis, 8);
        }, 1000);
        return;
    } else if (currentStep === 8) {
        userData.dermatitis = input;
        showMessage(`¿Tienes dermatitis?: ${input}.`, 'user');
        if (input === 'Sí') {
            setTimeout(() => showMessage(questions[9]), 1000);
        } else {
            setTimeout(() => {
                showMessage(questions[10]);
                showOptions(options.alisado, 10);
            }, 1000);
        }
        return;
    } else if (currentStep === 9) {
        userData.tipoDermatitis = input;
        showMessage(`Tipo de dermatitis: ${input}.`, 'user');
        setTimeout(() => {
            showMessage(questions[10]);
            showOptions(options.alisado, 10);
        }, 1000);
        return;
    } else if (currentStep === 10) {
        userData.alisado = input;
        showMessage(`¿Te has realizado alisado?: ${input}.`, 'user');
        if (input === 'Sí') {
            setTimeout(() => {
                showMessage(questions[11]);
                showOptions(options.tiempoAlisado, 11);
            }, 1000);
        } else {
            // Si responde "No", pasa directamente a los champús
            setTimeout(() => {
                currentStep = 12;  // Asegura que la próxima sea la pregunta de champús
                showMessage(questions[12]);
            }, 1000);
        }
        return;
    } else if (currentStep === 11) {
        userData.tiempoAlisado = input;
        showMessage(`El último alisado fue hace ${input}.`, 'user');
        setTimeout(() => showMessage(questions[12]), 1000);
      } else if (currentStep === 12) {
        userData.champu = input;
        showMessage(`Gracias por indicarnos los champús que usas: ${input}.`, 'user');
        showMessage("¡Gracias por responder las preguntas! Nos pondremos en contacto para agendar tu cita.", 'bot');
        
        // Llamada a la función para enviar los datos
        sendDataToServer(); 

        // Redirigir a la página de la peluquería después de 5 segundos
        setTimeout(() => {
            window.location.href = "https://www.grisselsantanahairsalon.com";
        }, 5000); // Espera de 5 segundos antes de redirigir
    }

    currentStep++;
}

// Evento para enviar la respuesta del usuario
chatForm.addEventListener('submit', (e) => {
    e.preventDefault();  // Evitar recarga de página
    const input = userInput.value.trim();
    if (input !== '' && currentStep !== 3 && currentStep !== 4) {
        handleUserInput(input);
        userInput.value = '';  // Limpiar el campo de entrada
    }
});

// Enviar los datos al servidor después de completar el cuestionario
function sendDataToServer() {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "guardar_datos.php", true); // Archivo PHP que procesará los datos
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Datos enviados y guardados con éxito.");
        }
    };
    xhr.send(JSON.stringify(userData)); // Enviar datos en formato JSON
}

// Iniciar con la primera pregunta
showMessage(questions[0]);
