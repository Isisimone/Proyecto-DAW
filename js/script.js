const video = document.getElementById('video');
const fileInput = document.getElementById('fileInput');
let faceMatcher = null;
const knownDescriptors = [];

Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('js/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('js/models'),
    faceapi.nets.faceRecognitionNet.loadFromUri('js/models'),
    faceapi.nets.faceExpressionNet.loadFromUri('js/models')
]).then(() => {
    iniciarVideo();
    cargarRostrosAlmacenados();
});

function iniciarVideo() {
    navigator.getUserMedia({
            video: {}
        },
        stream => video.srcObject = stream,
        err => console.error(err)
    );
}

video.addEventListener('play', () => {
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

        /*rostros.forEach(rostro => {
            console.log("-------------------- Rostro Detectado (" + rostro.detection.score + ") --------------------");
            console.log("Neutro: " + rostro.expressions.neutral);
            console.log("Feliz: " + rostro.expressions.happy);
            console.log("Triste: " + rostro.expressions.sad);
            console.log("Enojado: " + rostro.expressions.angry);
            console.log("Temeroso: " + rostro.expressions.fearful);
            console.log("Disgustado: " + rostro.expressions.disgusted);
            console.log("Sorprendido: " + rostro.expressions.surprised);
        });*/

    }, 100);
});

async function guardarRostro() {
    const rostro = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor();
    if (rostro) {
        const descriptor = rostro.descriptor;
        knownDescriptors.push(descriptor);
        await guardarDescriptorEnServidor(descriptor);
        actualizarFaceMatcher();
    }
}

async function guardarDescriptorEnServidor(descriptor) {
    const data = { descriptor: Array.from(descriptor) };

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
            knownDescriptors.push(descriptor);
            actualizarFaceMatcher();
        } else {
            console.error('Descriptor con longitud incorrecta.');
        }
    };
    reader.readAsText(file);
}

fileInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (file) {
        cargarDescriptor(file);
    }
});

function actualizarFaceMatcher() {
    if (knownDescriptors.length === 0) {
        console.error('No hay descriptores conocidos.');
        faceMatcher = null;
        return;
    }
    const labeledDescriptors = knownDescriptors.map((descriptor, index) => new faceapi.LabeledFaceDescriptors(`Rostro ${index}`, [descriptor]));
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

        for (const file of data) {
            const response = await fetch(`rostros/${file}`);
            const descriptorArray = await response.json();
            if (descriptorArray.length === 128) {  // Verifica la longitud del descriptor
                const descriptor = new Float32Array(descriptorArray);
                knownDescriptors.push(descriptor);
            } else {
                console.error(`Descriptor con longitud incorrecta en el archivo ${file}.`);
            }
        }

        actualizarFaceMatcher();
    } catch (error) {
        console.error('Error al cargar los descriptores:', error);
    }
}

function iniciarComparacion() {
    if (!faceMatcher) {
        console.error('FaceMatcher no está inicializado.');
        return;
    }

    setInterval(async () => {
        const rostro = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor();
        if (rostro) {
            const descriptor = rostro.descriptor;
            if (descriptor.length === 128) {  // Verifica la longitud del descriptor
                const mejorMatch = faceMatcher.findBestMatch(descriptor);
                console.log(`Rostro comparado con el más cercano: ${mejorMatch.toString()}`);
                if (mejorMatch.label === 'unknown') {
                    console.log('No se encontró un rostro coincidente.');
                } else {
                    console.log(`Se encontró un match: ${mejorMatch.toString()}`);
                }
            } else {
                console.error('Descriptor detectado con longitud incorrecta.');
            }
        } else {
            console.log('No se detectó ningún rostro para comparar.');
        }
    }, 1000);
}
