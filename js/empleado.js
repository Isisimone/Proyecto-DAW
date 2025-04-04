// Habilitar/deshabilitar los campos de fecha según el filtro seleccionado
function toggleDateInputs() {
    const filterMode = document.getElementById('filter-mode').value;
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');

    if (filterMode === 'range') {
        startDate.disabled = false;
        endDate.disabled = false;
    } else {
        startDate.disabled = true;
        endDate.disabled = true;
    }
}

// Agregar un listener al DOM para el evento change del filtro
document.addEventListener('DOMContentLoaded', () => {
    const filterModeSelect = document.getElementById('filter-mode');
    
    if (filterModeSelect) {
        filterModeSelect.addEventListener('change', toggleDateInputs);
    }

    const contextMenu = document.getElementById('context-menu');
    const registroContainer = document.querySelector('.registro ul'); // Contenedor de los registros
    const bloqueRevision = document.getElementById('bloque-revision');
    const bloqueMostrarDatos = document.getElementById('bloque-mostrardatos');

    // Función para centrar elementos en la ventana
    function centrarElemento(elemento) {
        elemento.style.position = 'fixed';
        elemento.style.top = '50%';
        elemento.style.left = '50%';
        elemento.style.transform = 'translate(-50%, -50%)';
        elemento.style.zIndex = '1000';
    }

    // Configurar bloques flotantes
    [bloqueRevision, bloqueMostrarDatos].forEach(bloque => {
        centrarElemento(bloque);
        bloque.style.display = 'none';
        bloque.style.backgroundColor = 'white';
        bloque.style.padding = '20px';
        bloque.style.border = '1px solid #ccc';
        bloque.style.boxShadow = '0 0 10px rgba(0,0,0,0.1)';
    });

    // Eventos para cerrar los bloques
    document.getElementById('cerrar-revision').addEventListener('click', () => {
        bloqueRevision.style.display = 'none';
    });

    document.getElementById('cerrar-mostrardatos').addEventListener('click', () => {
        bloqueMostrarDatos.style.display = 'none';
    });

    
    // Ocultar menú y bloques al hacer clic fuera
    document.addEventListener('click', (event) => {
        const elementosInteractivos = [
            contextMenu, 
            bloqueRevision, 
            bloqueMostrarDatos,
            ...document.querySelectorAll('#context-menu *, #bloque-revision *, #bloque-mostrardatos *')
        ];
        
        const clickEnElementoInteractivo = elementosInteractivos.some(el => el.contains(event.target));
        const clickEnListItem = event.target.closest('.registro li') !== null;

        if (!clickEnElementoInteractivo && !clickEnListItem) {
            if (contextMenu.style.display === 'block') contextMenu.style.display = 'none';
            if (bloqueRevision.style.display === 'block') bloqueRevision.style.display = 'none';
            if (bloqueMostrarDatos.style.display === 'block') bloqueMostrarDatos.style.display = 'none';
        }
    });

    // Delegación de eventos: Escucha los clics en el contenedor
    registroContainer.addEventListener('click', (event) => {
        const target = event.target.closest('li'); // Busca el <li> más cercano al clic
        if (target) {
            event.preventDefault(); // Evita el comportamiento predeterminado

            // Obtén las coordenadas del clic
            const x = event.clientX;
            const y = event.clientY;

            // Posiciona el menú contextual
            contextMenu.style.left = `${x}px`;
            contextMenu.style.top = `${y}px`;
            contextMenu.style.display = 'block';

            // Guarda el registro seleccionado en un atributo de datos
            contextMenu.dataset.selectedRegistro = target.dataset.id;
            contextMenu.dataset.selectedRegistroFecha = target.dataset.fecha;
            
        }
    });
        

    // Manejar opciones del menú contextual
    document.getElementById('solicitar-revision').addEventListener('click', () => {
        const registroFecha = contextMenu.dataset.selectedRegistroFecha;
        const registroId = contextMenu.dataset.selectedRegistro;
        contextMenu.style.display = 'none';
        
        // Configurar el formulario de revisión con el ID del registro
        document.getElementById('registro-id-revision').value = registroId;
        document.getElementById('comentario-fecha').value = registroFecha;
        bloqueRevision.style.display = 'block';
    });

    document.getElementById('mostrar-datos').addEventListener('click', () => {
        const registroFecha = contextMenu.dataset.selectedRegistroFecha;
        contextMenu.style.display = 'none';
        
        // Buscar los marcajes para esta fecha
        const marcajesFecha = Object.values(todosMarcajes).filter(marcaje => {
            return marcaje.FEC_MARCAJE.startsWith(registroFecha);
        });
        const fechaHoy = new Date().toISOString().split('T')[0];
        
        // Generar el HTML
        let html = `
            <div class="section" id="recent-accesses">
                <h3>Marcajes del ${registroFecha}</h3>
                <ul>`;
        
        marcajesFecha.forEach(marcaje => {
            const fechaMarcaje = marcaje.FEC_MARCAJE.split(' ')[0]; // Obtener solo la fecha
            const esHoy = (fechaMarcaje === fechaHoy);
            const tipoClase = marcaje.COD_TIPO_MARCAJE == 1 ? "tipoA" : "tipoB";
            const tipoTexto = marcaje.COD_TIPO_MARCAJE == 1 ? "Entrada" : "Salida";
            const color = !esHoy ? 'darkgrey' : 'inherit';
            
            html += `
                <li class="acceso-item" style="color: ${color};">
                    <span class="${tipoClase}">${tipoTexto}</span>
                    <span class="fecha">${marcaje.FEC_MARCAJE}</span>
                    <span class="imagen">
                        <img class="foto_peque" src="./logica/mostrar_imagen.php?archivo=${encodeURIComponent(marcaje.DES_FOTO)}" alt="Foto de fichaje">
                    </span>
                </li>`;
        });
        
        html += `</ul></div>`;
        
        document.getElementById('registro-id-datos').innerHTML = html;
        bloqueMostrarDatos.style.display = 'block';
    });

    document.getElementById('foto_empleado').addEventListener('click', () => {
        document.getElementById('fileinput').click();
    });

    document.getElementById('fileinput').addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            const maxSize = 2 * 1024 * 1024;
            if (file.type !== 'image/jpeg') {
                alert('Por favor, selecciona una imagen en formato JPEG.');
                event.target.value = '';
            } else if (file.size > maxSize) {
                alert('El tamaño de la imagen no debe exceder 2 MB.');
                event.target.value = '';
            } else {
                // Crear FormData y añadir la imagen
                const formData = new FormData();
                const cod_empleado = document.getElementById('employee-name').getAttribute('data-id');
                formData.append('imagen', file); 
                formData.append('cod_empleado', cod_empleado);
                
                // Enviar la imagen al servidor
                fetch('logica/subir_foto.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la subida');
                    }
                    return response.text(); // o response.json() si tu PHP devuelve JSON
                })
                .then(data => {
                    console.log('Imagen subida con éxito:', data);
                        location.reload();                    
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al subir la imagen');
                });
            }
        }
    });

    document.getElementById('exp-reg-csv').addEventListener('click', () => {
        console.log(registros); // Asegúrate de que esta variable esté definida en tu PHP  
        exportar('csv', registros); // Llama a la función de exportación  
    });
    document.getElementById('exp-reg-xls').addEventListener('click', () => {
        console.log(registros); // Asegúrate de que esta variable esté definida en tu PHP  
        exportar('xls', registros); // Llama a la función de exportación  
    });
    document.getElementById('exp-reg-pdf').addEventListener('click', () => {
        console.log(registros); // Asegúrate de que esta variable esté definida en tu PHP 
        const elemento = document.getElementById('registrosExportables');
    
        if (!elemento) {
            console.error('No se encontró el elemento con ID "registrosExportables"');
            return null;
        }
    
        // Clonar el elemento para no afectar el original
        const clon = elemento.cloneNode(true);
    
        
        exportar('pdf', clon.outerHTML); // Llama a la función de exportación  
    });

});

//Función exportar registros
async function exportar(tipo,data){
    try {
        // Resto de tu lógica de exportación
        const formData = new FormData();
        formData.append('datos', JSON.stringify(data));
        formData.append('tipo', tipo);

        const response = await fetch(`./logica/exportar_registros.php`, {
          method: 'POST',
          body: formData
        });
        
        // Manejar la descarga
        const blob = await response.blob();
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `registros_${new Date().toISOString().slice(0,10)}.${tipo}`;
        document.body.appendChild(a);
        a.click();
        a.remove();
      } catch (error) {
        console.error('Error al exportar:', error);
    }
}

// Configuración de la gráfica
function renderChart(labels, data, ausencias, average, maxHorasDia) {
    const ctx = document.getElementById('hours-chart').getContext('2d');
    
    // Divide las horas en normales y extras
    const horasNormales = data.map(horas => Math.min(horas, maxHorasDia)); // Máximo permitido por día
    const horasExtras = data.map(horas => Math.max(0, horas - maxHorasDia)); // Horas que exceden el máximo

    // Define los colores para las barras
    const backgroundColors = labels.map(label => {
        const date = new Date(label); // Convierte la etiqueta en una fecha
        return date.getDay() === 0 // 0 corresponde a domingo
            ? 'rgba(255, 99, 132, 0.5)' // Color para domingos
            : 'rgba(54, 162, 235, 0.5)'; // Color para otros días
    });

    // Renderiza la gráfica
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Horas normales',
                    data: horasNormales,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', // Color para horas normales
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Horas extras',
                    data: horasExtras,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)', // Color para horas extras
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Ausencias',
                    data: ausencias,
                    backgroundColor: 'rgba(255, 206, 86, 0.5)', // Color para ausencias
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    stacked: true // Habilita el apilado en el eje X
                },
                y: {
                    stacked: true // Habilita el apilado en el eje Y
                }
            },
            plugins: {
                annotation: {
                    annotations: {
                        line1: {
                            type: 'line',
                            yMin: average,
                            yMax: average,
                            borderColor: 'red',
                            borderWidth: 2,
                            label: {
                                content: 'Media',
                                enabled: true,
                                position: 'end'
                            }
                        }
                    }
                }
            }
        }
    });
}

function openTab(evt, tabName) {
    // Oculta todos los contenidos de pestañas
    const tabContents = document.getElementsByClassName("tab-content");
    for (let i = 0; i < tabContents.length; i++) {
        tabContents[i].style.display = "none";
    }
    
    // Elimina la clase active de todos los botones
    const tabButtons = document.getElementsByClassName("tab-button");
    for (let i = 0; i < tabButtons.length; i++) {
        tabButtons[i].classList.remove("active");
    }
    
    // Muestra la pestaña actual y marca el botón como activo
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.classList.add("active");
}

// Función para renderizar contenido de la sección
function updateContent(seccion) {
    cerrarSecciones();
    document.getElementById(seccion).style.display = "block";
}

function cerrarSecciones(){
    document.getElementById('principal').style.display = "none";
    document.getElementById('perfil').style.display = "none";
    document.getElementById('actividades').style.display = "none";
    document.getElementById('ultimos').style.display = "none";
    document.getElementById('filtrar').style.display = "none";
}
// Función de logout
function logout() {
    alert("Has cerrado sesión.");
}