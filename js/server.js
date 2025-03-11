const express = require('express');
const bodyParser = require('body-parser');
const { FaceMatcher, LabeledFaceDescriptors } = require('face-api.js');
const axios = require('axios'); // Para hacer solicitudes HTTP
const path = require('path');

const app = express();
const port = 3000;

app.use(bodyParser.json());

let faceMatcher = null;
const descriptoresConocidos = [];

// Función para cargar descriptores desde el archivo PHP
async function cargarDescriptores() {
    try {
        // Hacer una solicitud HTTP al archivo PHP
        const response = await axios.get('http://localhost/proyecto/Proyecto-DAW/listar_descriptores.php');
        const data = response.data;

        // Verificar que la respuesta sea un array
        if (!Array.isArray(data)) {
            throw new Error('La respuesta no es un array de descriptores.');
        }

        // Procesar los descriptores
        data.forEach((item) => {
            if (item.nombre && item.descriptor && Array.isArray(item.descriptor)) {
                descriptoresConocidos.push({
                    nombre: item.nombre,
                    descriptor: new Float32Array(item.descriptor) // Convertir a Float32Array
                });
            } else {
                console.warn('Descriptor inválido:', item);
            }
        });

        console.log('Descriptores cargados correctamente desde PHP.');
    } catch (error) {
        console.error('Error al cargar los descriptores:', error.message);
    }
}

// Ruta para reconocer una cara
app.post('/recognize', (req, res) => {
    if (!faceMatcher) {
        return res.status(500).json({ error: 'FaceMatcher no inicializado' });
    }

    const descriptor = new Float32Array(req.body.descriptor);
    const mejorMatch = faceMatcher.findBestMatch(descriptor);

    if (mejorMatch.distance < 0.6) { // Ajusta el umbral según sea necesario
        res.json({ match: true, name: mejorMatch.label, distance: mejorMatch.distance });
    } else {
        res.json({ match: false });
    }
});

// Iniciar el servidor
app.listen(port, async () => {
    console.log(`Servidor corriendo en http://localhost:${port}`);
    await cargarDescriptores(); // Cargar descriptores desde PHP

    // Verificar que hay descriptores cargados
    if (descriptoresConocidos.length === 0) {
        console.error('No se cargaron descriptores. FaceMatcher no se inicializará.');
        return;
    }

    // Crear LabeledFaceDescriptors
    const labeledDescriptors = descriptoresConocidos.map((item) => (
        new LabeledFaceDescriptors(item.nombre, [item.descriptor])
    ));

    // Inicializar FaceMatcher
    faceMatcher = new FaceMatcher(labeledDescriptors);
    console.log('FaceMatcher inicializado con descriptores conocidos.');
});