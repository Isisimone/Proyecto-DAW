// script.js
document.getElementById("startRecognition").addEventListener("click", analizaVideo);
fileInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (file) {
        cargarDescriptor(file);
    }
});

//video.addEventListener('play', analizaVideo());

const video = document.getElementById('video');
const estado = document.getElementById('status');
const fileInput = document.getElementById('fileInput');
let faceMatcher = null;
const knownDescriptors = []; // Almacena los descriptores conocidos
const UMBRAL_SIMILITUD = 0.6; // Umbral de similitud (ajusta según sea necesario)

Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('js/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('js/models'),
    faceapi.nets.faceRecognitionNet.loadFromUri('js/models'),
    faceapi.nets.faceExpressionNet.loadFromUri('js/models')
]).then(() => {
    iniciarVideo(); //Cambio a la función con control de errores startRecognition()
    cargarRostrosAlmacenados();
});

function analizaVideo() {
    return () => {
        const canvas = faceapi.createCanvasFromMedia(video);
        canvas.id = 'overlay';
        document.body.append(canvas);

        const dimensiones = {
            width: video.width,
            height: video.height
        };
        faceapi.matchDimensions(canvas, dimensiones);

        setInterval(async () => {
            const rostros = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptors().withFaceExpressions();
            const area = faceapi.resizeResults(rostros, dimensiones);
            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
            faceapi.draw.drawDetections(canvas, area);
            faceapi.draw.drawFaceLandmarks(canvas, area);
            faceapi.draw.drawFaceExpressions(canvas, area);

            // Comparar rostros con descriptores conocidos
            rostros.forEach((rostro) => {
                const descriptor = rostro.descriptor;
                const mejorMatch = encontrarMejorCoincidencia(descriptor);
                if (mejorMatch && mejorMatch.distancia < UMBRAL_SIMILITUD) {
                    alert(`¡Persona reconocida! Coincidencia: ${mejorMatch.nombre}, Distancia: ${mejorMatch.distancia}`);
                }
            });

        }, 100);
    };
}

//deprecated
//function iniciarVideo() {
//    navigator.getUserMedia({
 //           video: {}
 //       },
 //       stream => video.srcObject = stream,
 //       err => console.error(err)
//    );
//}

function iniciarVideo() {
    // Acceder a la cámara
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                // Mostrar el video en el elemento de video
                video.srcObject = stream;
                video.style.display = 'block';
                estado.innerHTML = 'Cargando reconocimiento facial...';
                // Aquí agregaríamos el código de reconocimiento facial
            })
            .catch(function (error) {
                console.error("No se puede acceder a la cámara: ", error);
                estado.innerHTML = 'Error al acceder a la cámara';
            });
    } else {
        estado.innerHTML = 'La cámara no es compatible con tu navegador';
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



async function guardarRostro() {
    const rostro = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor();
    if (rostro) {
        const descriptor = rostro.descriptor;
        const nombre = prompt("Introduce un nombre para este rostro:");
        if (nombre) {
            knownDescriptors.push({ nombre, descriptor });
            await guardarDescriptorEnServidor(nombre, descriptor);
            actualizarFaceMatcher();
        }
    }
}

async function guardarDescriptorEnServidor(nombre, descriptor) {
    const data = {nombre, descriptor: Array.from(descriptor) };

    try {
        const response = await fetch('guardar_descriptor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        console.log(result.message);
    } catch (error) {
        console.error('Error al guardar el descriptor:', error);
    }
}

function cargarDescriptor(file) {
    const reader = new FileReader();
    reader.onload = (event) => {
        const descriptorArray = JSON.parse(event.target.result);
        if (descriptorArray.length === 128) {  // Verifica la longitud del descriptor
            const descriptor = new Float32Array(descriptorArray);
            const nombre = prompt("Introduce un nombre para este rostro:");
            if (nombre) {
                knownDescriptors.push({ nombre, descriptor });
                actualizarFaceMatcher();
            }
        } else {
            console.error('Descriptor con longitud incorrecta.');
        }
    };
    reader.readAsText(file);
}



function actualizarFaceMatcher() {
    if (knownDescriptors.length === 0) {
        console.error('No hay descriptores conocidos.');
        faceMatcher = null;
        return;
    }
    const labeledDescriptors = knownDescriptors.map((item) => new faceapi.LabeledFaceDescriptors(item.nombre, [item.descriptor]));
    faceMatcher = new faceapi.FaceMatcher(labeledDescriptors);
    console.log("FaceMatcher inicializado con descriptores conocidos.");
}

async function cargarRostrosAlmacenados() {
    try {
        const response = await fetch('listar_descriptores.php');
        const data = await response.json();
        if (data.length === 0) {
            console.error('No hay descriptores almacenados.');
            return;
        }

        for (const item of data) {
            const descriptor = new Float32Array(item.descriptor);
            knownDescriptors.push({ nombre: item.nombre, descriptor });
        }

        actualizarFaceMatcher();
    } catch (error) {
        console.error('Error al cargar los descriptores:', error);
    }
}

function encontrarMejorCoincidencia(descriptor) {
    let mejorMatch = null;
    for (const item of knownDescriptors) {
        const distancia = faceapi.euclideanDistance(descriptor, item.descriptor);
        if (!mejorMatch || distancia < mejorMatch.distancia) {
            mejorMatch = { nombre: item.nombre, distancia };
        }
    }
    return mejorMatch;
}

// Actualizar la hora cada segundo
setInterval(updateClock, 1000);
updateClock();