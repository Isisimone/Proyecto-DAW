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
function renderChart(labels, data, average) {
    const ctx = document.getElementById('hours-chart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Horas trabajadas',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
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