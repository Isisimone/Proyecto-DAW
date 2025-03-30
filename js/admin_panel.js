
/* Listeners */
document.addEventListener('DOMContentLoaded', () => {
    //Variables
        //Bloques
        const panelDatosAdmin = document.getElementById('panelDatosAdmin');
        const panelIncidenciasPendientes = document.getElementById('panelIncidenciasPendientes');
        const panelIncidenciasResueltas = document.getElementById('panelIncidenciasResueltas');
        const panelFichaIncidencia = document.getElementById('panelFichaIncidencia');
        const panelFormularioResolucion = document.getElementById('panelFormularioResolucion');
        const panelEntrasSalidas = document.getElementById('panelEntrasSalidas');
        const panelDatosEmpleado = document.getElementById('panelDatosEmpleado');
        const panelEmpleados = document.getElementById('panelEmpleados');
        const panelConfirmarBaja = document.getElementById('panelConfirmarBaja');
        const panelExportarEmpleados = document.getElementById('panelExportarEmpleados');
        const panelUsuarios = document.getElementById('panelUsuarios');
        const panelDescriptores = document.getElementById('panelDescriptores');
        const panelEliminarDescriptor = document.getElementById('panelEliminarDescriptor');
        const panelExportarUsuarios = document.getElementById('panelExportarUsuarios');
        const panelListadoTransacciones = document.getElementById('panelListadoTransacciones');
        const panelListadoMarcajes = document.getElementById('panelListadoMarcajes');
        const panelRoles = document.getElementById('panelRoles');
        const panelUsuariosAsigandos = document.getElementById('panelUsuariosAsigandos');
        const panelAsignarRoles = document.getElementById('panelAsignarRoles');
        const panelAjustes = document.getElementById('panelAjustes');

    //Métodos
    function cerrar_bloques(){
        panelDatosAdmin.style.display = 'none';
        panelIncidenciasPendientes.style.display = 'none';
        panelIncidenciasResueltas.style.display = 'none';
        panelFichaIncidencia.style.display = 'none';
        panelFormularioResolucion.style.display = 'none';
        panelEntrasSalidas.style.display = 'none';
        panelDatosEmpleado.style.display = 'none';
        panelEmpleados.style.display = 'none';
        panelConfirmarBaja.style.display = 'none';
        panelExportarEmpleados.style.display = 'none';
        panelUsuarios.style.display = 'none';
        panelDescriptores.style.display = 'none';
        panelEliminarDescriptor.style.display = 'none';
        panelExportarUsuarios.style.display = 'none';
        panelListadoTransacciones.style.display = 'none';
        panelListadoMarcajes.style.display = 'none';
        panelRoles.style.display = 'none';
        panelUsuariosAsigandos.style.display = 'none';
        panelAsignarRoles.style.display = 'none';
        panelAjustes.style.display = 'none';
    }
    //Listeners
    //Listeners del menu
    document.getElementById('menuPrincipal').addEventListener('click', () => {
        cerrar_bloques();
        panelDatosAdmin.style.display = 'block';
        panelIncidenciasPendientes.style.display = 'block';
        panelEntrasSalidas.style.display = 'block';
    });

    document.getElementById('menuEmpleados').addEventListener('click', () => {
        cerrar_bloques();
        panelEmpleados.style.display = 'block';
    });

    document.getElementById('menuUsuarios').addEventListener('click', () => {
        cerrar_bloques();
        panelUsuarios.style.display = 'block';
    });

    document.getElementById('menuMarcajes').addEventListener('click', () => {
        cerrar_bloques();
        panelListadoMarcajes.style.display = 'block';
    });  

    document.getElementById('menuTransacciones').addEventListener('click', () => {
        cerrar_bloques();
        panelListadoTransacciones.style.display = 'block';
    });  

    document.getElementById('menuRoles').addEventListener('click', () => {
        cerrar_bloques();
        panelRoles.style.display = 'block';
    });  

    document.getElementById('menuUsuariosRoles').addEventListener('click', () => {
        cerrar_bloques();
        panelAsignarRoles.style.display = 'block';
    });

    document.getElementById('menuAjustes').addEventListener('click', () => {
        cerrar_bloques();
        panelAjustes.style.display = 'block';
    });  

    document.getElementById('menuCerrar').addEventListener('click', () => {
        cerrar_bloques();
        logout();
    }); 
    
    // Evento delegado para todos los elementos .cerrar
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('cerrar') || e.target.closest('.cerrar')) {
        document.querySelectorAll('.ventana').forEach(ventana => {
            ventana.style.display = 'none';
        });
        // También ocultamos el contenedor principal por si acaso
        document.getElementById('panelFichaIncidencia').style.display = 'none';
    }
});

    //Listeners de incidencias
    //CLICK en una incidencia pendiente
    document.querySelectorAll('.incidenciaP').forEach(incidenciaPendiente => {
        incidenciaPendiente.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const foto = this.getAttribute('data-foto');
            //Devuelvo del array incidenciasP la clickeada 
            const incidenciaSeleccionada = Object.values(incidenciasP).filter(incidencia => {
                return incidencia.ID.startsWith(id);
            })[0];
            const fecha=incidenciaSeleccionada.FECHA_INC;
            const empleado = incidenciaSeleccionada.COD_EMPLEADO;


            const marcajesFecha = Object.values(marcajesPorIncidencia)
                .flat() // Aplanamos el array de arrays
                .filter(marcaje => {
                    return marcaje.FEC_MARCAJE.startsWith(fecha) && 
                     marcaje.COD_EMPLEADO == empleado;
                });
            
            let html=`
            <div class="contenedor-empleado">
                    <!-- Cabecera con foto, nombre y fecha -->
                    <button class="cerrar" aria-label="Cerrar ventana">&times;</button>
                    <div class="cabecera-empleado">
                        <img id="fotoIncidenciaEmpleado" src="./logica/mostrar_imagen.php?perfil=perfil&archivo=${foto}" class="foto-empleado">
                        <div class="info-empleado">
                            <p class="nombre-empleado" id="nombreEmpleadoIncidencia">${nombre}</p>
                            <p class="fecha-empleado" id="fechaIncidencia">Sobre la fecha: ${fecha}</p>
                            <p id="incidenciaActiva" data-incidencia="${id}">${id}</p>
                        </div>
                    </div>

                    <!-- Queja del empleado -->
                    <div class="queja-empleado">
                        <p id="quejaEmpleado"> ${incidenciaSeleccionada.COMENTARIO}</p>
                    </div>
                    <!-- Lista de eventos -->
                    <h3>Registro de accesos:</h3>
                    <div class="lista-eventos">
                    `;
                    marcajesFecha.forEach(marcaje=>{
                        const tipoTexto = marcaje.COD_TIPO_MARCAJE == 1 ? "Entrada" : "Salida";
                        
                    html+=`<div class="fila-evento marcajeIncidenciaP" data-id="${marcaje.COD_MARCAJE}">
                            <span class="tipo-evento">${tipoTexto}</span>
                            <span class="fecha-evento">${marcaje.FEC_MARCAJE}</span>
                            <img class="foto_peque" src="./logica/mostrar_imagen.php?archivo=${encodeURIComponent(marcaje.DES_FOTO)}">
                        </div>`;
                    });
                    html+=`</div>
                </div>`;  
                document.getElementById('panelFichaIncidencia').innerHTML = html;
            // Mostrar la ventana
            document.getElementById('panelFichaIncidencia').style.display = 'block';
        });
    });
    //CLICK en un marcaje de la incidencia pendiente
    document.getElementById('panelFichaIncidencia').addEventListener('click', function(e) {
        // Verifica si el click fue en un elemento con clase marcajeIncidenciaP o en sus hijos
        const elementoMarcaje = e.target.closest('.marcajeIncidenciaP');
        
        if (elementoMarcaje) {
            var codMarcaje = elementoMarcaje.getAttribute('data-id');
            const marcajePorID = Object.values(marcajesPorIncidencia)
                .flat()
                .find(marcaje => marcaje.COD_MARCAJE == codMarcaje);
            
            if (marcajePorID) {
                document.getElementById('panelFormularioResolucion').style.display = 'block';
                document.getElementById('resolucionCod').value=marcajePorID.COD_MARCAJE;
                document.getElementById('resolucionEmpleado').value=marcajePorID.COD_EMPLEADO;
                document.getElementById('resolucionFecha').value=marcajePorID.FEC_MARCAJE;
            }
        }
    });

    //CLICK para Actualizar marcaje de incidencia
    document.getElementById('resolucionG').addEventListener('click', async () => {
        // Envío de datos para actualizar marcaje
        await crud({
            cod_marcaje: document.getElementById('resolucionCod').value,
            cod_empleado: document.getElementById('resolucionEmpleado').value,
            fec_marcaje: document.getElementById('resolucionFecha').value,
            cod_incidencia: Number(document.getElementById('incidenciaActiva').getAttribute("data-incidencia")),
            cod_usuario: usuarioSesion,
            accion: 'actualizar_marcaje_incidencia'
        });
        location.reload();
    });
});

async function crud(datos){
    try {
        const respuesta = await fetch('./logica/administracion_crud.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(datos)
        });
        const resultado = await respuesta.json();
        
        if (resultado.success) {
            alert('¡Datos actualizados correctamente!');            
        } else {
            throw new Error(resultado.error || 'Error desconocido');
        }
    } catch (error) {
        console.error('Error:', error);
        alert(`Error al guardar: ${error.message}`);
    }
}

function openTab(tabId) {
    // Oculta todos los contenidos
    document.querySelectorAll('.tab-content').forEach(tab => {
      tab.classList.remove('active');
    });
    // Desactiva todos los tabs
    document.querySelectorAll('.tab').forEach(tab => {
      tab.classList.remove('active');
    });
    // Activa el tab seleccionado
    document.getElementById(tabId).classList.add('active');
    event.currentTarget.classList.add('active');
  }


function seleccionarEmpleado(elemento) {
    const codEmpleado = elemento.getAttribute('data-cod');
    document.getElementById('cod_empleado').value = codEmpleado;
    document.getElementById('dropdownEmpleados2').textContent = elemento.textContent.trim();
}


// Función para actualizar la hora en vivo
function updateTime() {
    const now = new Date();
    document.getElementById('current-time').innerText = now.toLocaleTimeString();
}
setInterval(updateTime, 1000);
updateTime();

// Función para cargar el gráfico de asistencia
function loadChart() {
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie'],
            datasets: [{
                label: 'Horas trabajadas',
                data: [8, 7.5, 8, 6, 7],
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}

// Función de logout
function logout() {
    alert("Has cerrado sesión.");
}
