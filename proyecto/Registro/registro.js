// script.js
document.getElementById("startRecognition").addEventListener("click", startRecognition);

function startRecognition() {
    const video = document.getElementById('videoElement');
    const status = document.getElementById('status');
    
    // Acceder a la cámara
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                // Mostrar el video en el elemento de video
                video.srcObject = stream;
                video.style.display = 'block';
                status.innerHTML = 'Cargando reconocimiento facial...';
                // Aquí agregaríamos el código de reconocimiento facial
            })
            .catch(function (error) {
                console.error("No se puede acceder a la cámara: ", error);
                status.innerHTML = 'Error al acceder a la cámara';
            });
    } else {
        status.innerHTML = 'La cámara no es compatible con tu navegador';
    }
}
// Función para actualizar la hora cada segundo
function updateClock() {
    let now = new Date();
    let hours = now.getHours().toString().padStart(2, "0");
    let minutes = now.getMinutes().toString().padStart(2, "0");
    let seconds = now.getSeconds().toString().padStart(2, "0");
    document.getElementById("clock").textContent = `${hours}:${minutes}:${seconds}`;
}

// Actualizar la hora cada segundo
setInterval(updateClock, 1000);
updateClock();