//Declaración de variables
const video = document.getElementById('video');
const estado = document.getElementById('status');
const botonera = document.getElementById('botonera');
const fileInput = document.getElementById('fileInput');
let faceMatcher = null;
const descriptoresConocidos = []; // Almacena los descriptores conocidos
const UMBRAL_SIMILITUD = 0.6; // Umbral de similitud (ajusta según sea necesario)
let intervaloAnalisis; // Intervalo de análisis del video

//Promesa de carga de modelos, hasta que no lo estén no se ejecuta el código
//Necesario para dar tiempo a cargar los modelos de reconocimiento
Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('js/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('js/models'),
    faceapi.nets.faceRecognitionNet.loadFromUri('js/models'),
    faceapi.nets.faceExpressionNet.loadFromUri('js/models')
]).then(() => {
    iniciarVideo(); 
    cargarRostrosAlmacenados();
});

//Inicia la webcam si está disponible o muestra error en estado
function iniciarVideo() {
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
           .then(function (stream) {
                video.srcObject = stream;
                video.style.display = 'block';
                estado.innerHTML = 'Cargando reconocimiento facial...';
            })
            .catch(function (error) {
                console.error("No se puede acceder a la cámara: ", error);
                estado.innerHTML = 'Error al acceder a la cámara';
            });
    } else {
        estado.innerHTML = 'La cámara no es compatible con tu navegador';
    }
}

//Actualiza el reloj en la página
function updateClock() {
    let now = new Date();
    let hours = now.getHours().toString().padStart(2, "0");
    let minutes = now.getMinutes().toString().padStart(2, "0");
    let seconds = now.getSeconds().toString().padStart(2, "0");
    document.getElementById("clock").textContent = `${hours}:${minutes}:${seconds}`;
}

//Guarda el rostro detectado en la base de datos (Por ahora en ficheros)
async function guardarRostro() {
    const rostro = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor();
    if (rostro) {
        const descriptor = rostro.descriptor;
        const nombre = prompt("Introduce un nombre para este rostro:");
        if (nombre) {
            descriptoresConocidos.push({ nombre, descriptor });
            await guardarDescriptorEnServidor(nombre, descriptor);
            actualizarFaceMatcher();
        }
    }
}

//Llama al PHP que realiza los cambios en el servidor
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

//Carga un descriptor desde un fichero(Actualizar a BBDD)
function cargarDescriptor(file) {
    const reader = new FileReader();
    reader.onload = (event) => {
        const descriptorArray = JSON.parse(event.target.result);
        if (descriptorArray.length === 128) {  
            const descriptor = new Float32Array(descriptorArray);
            const nombre = prompt("Introduce un nombre para este rostro:");
            if (nombre) {
                descriptoresConocidos.push({ nombre, descriptor });
                actualizarFaceMatcher();
            }
        } else {
            console.error('Descriptor con longitud incorrecta.');
        }
    };
    reader.readAsText(file);
}

//si cambian los ficheros en el input se carga el descriptor
fileInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (file) {
        cargarDescriptor(file);
    }
});

//evento del botón para inicializar el reconocimiento facial
//document.getElementById("startRecognition").addEventListener("click", analizaVideo());
//document.getElementById("reconocido").addEventListener("click", detenerAnalisis());
//document.getElementById("noReconocido").addEventListener("click", detenerAnalisis());


// Agregar un event listener al div con id "botonera"
botonera.addEventListener("click", function(event) {
    if (event.target && event.target.id === "reconocido") {
        detenerAnalisis();
    } else if (event.target && event.target.id === "noReconocido") {
        analizaVideo();
    } else if (event.target && event.target.id === "startRecognition") {
        analizaVideo();
    }
});

//Función que analiza el video en busca de rostros
function analizaVideo() {
    //return () => { //Devuelve el resultado de la función flecha no definida
        //Definición del canvas que se superpondrá a la imagen de la webcam
        const canvas = faceapi.createCanvasFromMedia(video);
        canvas.id = 'overlay';
        document.querySelector('.camera-container').append(canvas);
        const dimensiones = {
            width: video.width,
            height: video.height
        };
        //Creación del Canvas
        faceapi.matchDimensions(canvas, dimensiones);
        botonera.innerHTML=`<BR>`;
        
        //  setInterval para analizar el video cada 100ms
        intervaloAnalisis = setInterval(async () => {
            //rostros es un array con los rostros detectados en el video
            const rostros = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptors().withFaceExpressions();
            //Dimensiona el rostro detectado
            const area = faceapi.resizeResults(rostros, dimensiones);
            canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
            //Dibuja el rostro detectado en el canvas
            faceapi.draw.drawDetections(canvas, area);
            faceapi.draw.drawFaceLandmarks(canvas, area);
            faceapi.draw.drawFaceExpressions(canvas, area);
            //Bucle que recorre los rostros detectados
            rostros.forEach((rostro) => {
                //Genera el descriptor del rostro detectado(Biometría)
                const descriptor = rostro.descriptor;
                //Compara con los rostros conocidos
                const mejorMatch = encontrarMejorCoincidencia(descriptor);
                //Si la similitud es mayor que el umbral se muestra el botón de reconocimiento
                if (mejorMatch && mejorMatch.distancia < UMBRAL_SIMILITUD) {
                    estado.innerHTML = `¡Persona reconocida! Coincidencia: ${mejorMatch.nombre}, Distancia: ${mejorMatch.distancia}`;                    
                    botonera.innerHTML = `<button class="btnVerde" id="reconocido">Soy ${mejorMatch.nombre}</button>
                                        <button class="btnRojo" id="noReconocido">Soy otra persona</button>`;
                    clearInterval(intervaloAnalisis);
                }
            });

        }, 100); // Definir aquí el tiempo de análisis
    //};
}

//Función para detener el análisis del video
function detenerAnalisis() {
    clearInterval(intervaloAnalisis);
    console.log('Identidad reconocida.');
    console.log('Análisis de rostros detenido.');
     // Limpia el canvas
     const canvas = document.getElementById('overlay');
     if (canvas) {
         canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
         canvas.remove(); // Opcional: Elimina el canvas del DOM
     }
    //Actualiza el contenido de botonera
     botonera.innerHTML= `<button class="btnAzul" id="startRecognition">Iniciar Reconocimiento Facial</button>`;
     estado.innerHTML = `Que tengas un buen día.`;
}

//Función para consultar si hay rostros guardados con los que comparar
function actualizarFaceMatcher() {
    if (descriptoresConocidos.length === 0) {
        console.error('No hay descriptores conocidos.');
        faceMatcher = null;
        return;
    }
    //en caso contrario los carga en el faceMatcher
    const labeledDescriptors = descriptoresConocidos.map((item) => new faceapi.LabeledFaceDescriptors(item.nombre, [item.descriptor]));
    faceMatcher = new faceapi.FaceMatcher(labeledDescriptors);
    console.log("FaceMatcher inicializado con descriptores conocidos.");
}

//Carga los rostros almacenados en la base de datos
async function cargarRostrosAlmacenados() {
    try {
        const response = await fetch('listar_descriptores.php');
        const data = await response.json();
        //Control de que haya datos
        if (data.length === 0) {
            console.error('No hay descriptores almacenados.');
            return;
        }
        //Recorre los datos y los almacena en descriptores
        for (const item of data) {
            const descriptor = new Float32Array(item.descriptor);
            descriptoresConocidos.push({ nombre: item.nombre, descriptor });
        }
        //Actualiza el faceMatcher para usarlo despues en las comparaciones
        actualizarFaceMatcher();
    } catch (error) {
        //control de errores
        console.error('Error al cargar los descriptores:', error);
    }
}

//Función que recorre los descriptores conocidos y devuelve el mejor match
function encontrarMejorCoincidencia(descriptor) {
    let mejorMatch = null;
    for (const item of descriptoresConocidos) {
        const distancia = faceapi.euclideanDistance(descriptor, item.descriptor);
        if (!mejorMatch || distancia < mejorMatch.distancia) {
            mejorMatch = { nombre: item.nombre, distancia };
        }
    }
    return mejorMatch;
}

//Actualiza el reloj cada segundo
setInterval(updateClock, 1000);
updateClock();
