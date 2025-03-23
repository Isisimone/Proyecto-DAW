const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
const { FaceMatcher, LabeledFaceDescriptors } = require('face-api.js');
const axios = require('axios'); // Para hacer solicitudes HTTP
const path = require('path');


const app = express();
const port = 3000;
const clavesTemporales = {}; // Objeto para almacenar claves temporales

// Habilitar CORS para todas las rutas
app.use(cors());

/*app.use((req, res, next) => {
    res.header('Access-Control-Allow-Origin', '*'); // Permitir todos los orígenes
    res.header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
    res.header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    next();
});*/

app.use(bodyParser.json());

let faceMatcher = null;
const descriptoresConocidos = [];

// Función para cargar descriptores desde el archivo PHP
async function cargarDescriptores() {
    try {
        // Limpiar los descriptores existentes
        descriptoresConocidos.length = 0;

        // Hacer una solicitud HTTP al archivo PHP
        const response = await axios.get('http://localhost/Proyecto-DAW/public/listar_descriptores.php');
        const data = response.data;

        // Verificar que la respuesta sea un array
        if (!Array.isArray(data)) {
            throw new Error('La respuesta no es un array de descriptores.');
        }

        // Procesar los descriptores
        data.forEach((item) => {
            if (item.nombre && item.descriptor && Array.isArray(item.descriptor)) {
                descriptoresConocidos.push({
                    empleado: item.cod_empleado,
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
        throw error; // Propagar el error para manejarlo en la ruta
    }
}

// Ruta para reconocer una cara
app.post('/recognize', (req, res) => {
    console.log('Solicitud recibida en /recognize');
    if (!faceMatcher) {
        return res.status(500).json({ error: 'FaceMatcher no inicializado' });
    }

    const descriptor = new Float32Array(req.body.descriptor);
    const mejorMatch = faceMatcher.findBestMatch(descriptor);
    if (mejorMatch.distance < 0.7) { // Ajusta el umbral según sea necesario
        const [id_empleado, nombre] = mejorMatch.label.split('-');
        // Generar una clave aleatoria
        const clave = Math.random().toString(36).substring(2, 15);

        // Asociar la clave con el ID del empleado
        clavesTemporales[clave] = id_empleado;

        res.json({ match: true, empleado: clave, nombre: nombre, distance: mejorMatch.distance });
    } else {
        res.json({ match: false });
    }
});
//Ruta para recargar descriptores cuando se ha añadido uno nuevo.
app.post('/reload-descriptors', async (req, res) => {
    try {
        // Limpiar los descriptores existentes
        descriptoresConocidos.length = 0;

        // Cargar los nuevos descriptores desde PHP
        await cargarDescriptores();

        // Verificar que hay descriptores cargados
        if (descriptoresConocidos.length === 0) {
            return res.status(500).json({ error: 'No se cargaron descriptores.' });
        }

        // Crear LabeledFaceDescriptors
        const labeledDescriptors = descriptoresConocidos.map((item) => (
            new LabeledFaceDescriptors(`${item.empleado}-${item.nombre}`, [item.descriptor])
        ));

        // Actualizar FaceMatcher
        faceMatcher = new FaceMatcher(labeledDescriptors);
        console.log('FaceMatcher actualizado con nuevos descriptores.');

        res.json({ message: 'Descriptores recargados correctamente.' });
    } catch (error) {
        console.error('Error al recargar los descriptores:', error.message);
        res.status(500).json({ error: 'Error al recargar los descriptores.' });
    }
});

//Confirmación de identidad
app.post('/fichar', async (req, res) => {
    try{
        const { id } = req.body; // Recoger el ID del empleado enviado por el cliente
        // Validar la clave
        if (!clavesTemporales[id]) {
            return res.status(400).json({ error: 'Clave inválida o expirada.' });
        }

        // Recuperar el ID del empleado asociado a la clave
        const id_empleado = clavesTemporales[id];

        // Eliminar la clave para que no pueda reutilizarse
        delete clavesTemporales[id];

        
        console.log(`Empleado que fichó: ${id_empleado} con Clave ${id}`); // Mostrar en consola

        res.json({ message: `Empleado ${id_empleado} fichado correctamente.` });
    }catch (error){
        console.error('Error al fichar:', error.message);
        res.status(500).json({ error: 'Error al fichar en el servidor.' });
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
        new LabeledFaceDescriptors(`${item.empleado}-${item.nombre}`, [item.descriptor])
    ));

    // Inicializar FaceMatcher
    faceMatcher = new FaceMatcher(labeledDescriptors);
    console.log('FaceMatcher inicializado con descriptores conocidos.');
});