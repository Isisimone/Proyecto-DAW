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
});

// Configuración de la gráfica
function renderChart(labels, data, average, maxHorasDia) {
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
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Horas normales',
                data: horasNormales,
                backgroundColor: backgroundColors,
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Horas extras',
                data: horasExtras,
                backgroundColor: 'rgba(255, 99, 132, 0.5)', // Color para horas extras
                borderColor: 'rgba(255, 99, 132, 1)',
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