
/* Listeners */
document.addEventListener('DOMContentLoaded', () => {
    //Variables
        //Bloques
        const panelDatosAdmin = document.getElementById('panelDatosAdmin');
        const panelIncidencias = document.getElementById('panelIncidencias');
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
        const panelUsuariosAsignados = document.getElementById('panelUsuariosAsignados');
        const panelAsignarRoles = document.getElementById('panelAsignarRoles');
        const panelAjustes = document.getElementById('panelAjustes');

    //Métodos
    function cerrar_bloques() {
        const paneles = [
            'panelDatosAdmin', 'panelIncidencias', 'panelFichaIncidencia',
            'panelFormularioResolucion', 'panelEntrasSalidas', 'panelDatosEmpleado',
            'panelEmpleados', 'panelConfirmarBaja', 'panelExportarEmpleados',
            'panelUsuarios', 'panelDescriptores', 'panelEliminarDescriptor',
            'panelExportarUsuarios', 'panelListadoTransacciones', 'panelListadoMarcajes',
            'panelRoles', 'panelUsuariosAsignados', 'panelAsignarRoles', 'panelAjustes'
        ];
    
        paneles.forEach(id => {
            const panel = document.getElementById(id);
            if (panel) { // Solo si el elemento existe
                panel.style.display = 'none';
            }
        });
    }
    //Listeners
    //Listeners del menu
    document.getElementById('menuPrincipal').addEventListener('click', () => {
        cerrar_bloques();
        panelDatosAdmin.style.display = 'block';
        panelIncidencias.style.display = 'block';
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
                return String(incidencia.ID).startsWith(id);
            })[0];
            const fecha=incidenciaSeleccionada.FECHA_INC;
            const empleado = incidenciaSeleccionada.COD_EMPLEADO;

            const comentario = incidenciaSeleccionada.COMENTARIO;
            const formulario = document.getElementById("panelFichaIncidencia");
            const datos = {
                accion: 'mostrar_incidencia',
                cod_empleado: empleado,
                fecha: fecha,
                nombre: nombre,
                comentario: comentario,
                id: id 
            };
    
            // Limpiar formulario
            formulario.innerHTML = "";
                // Cargar el HTML
                cargarHTML(datos)
                .then(html =>{
                formulario.innerHTML = html;
            });
            
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

    //CHANGE en el select del formularioEmpleados
    document.getElementById("seleccionPanelEmpleado").addEventListener("change", function() {
        const formulario = document.getElementById("formularioEmpleado");
        const valorSeleccionado = this.value; // Obtiene el valor del select
        const data = {
            accion: 'mostrar_empleado',
            cod_empleado: valorSeleccionado  // Parámetro adicional opcional
        };
    
        // Limpiar formulario
        formulario.innerHTML = "";
        // Cargar el HTML
        cargarHTML(data)
        .then(html =>{
            formulario.innerHTML = html;
        });
    });

    //CHANGE en el select del formularioUsuarios
    document.getElementById("seleccionPanelUsuario").addEventListener("change", function() {
        const formulario = document.getElementById("formularioUsuario");
        const valorSeleccionado = this.value; // Obtiene el valor del select
        const data = {
            accion: 'mostrar_usuario',
            cod_usuario: valorSeleccionado  // Parámetro adicional opcional
        };
    
        // Limpiar formulario
        formulario.innerHTML = "";
        // Cargar el HTML
        cargarHTML(data)
        .then(html =>{
            formulario.innerHTML = html;
        });
    });

    //CLICK en filtrar Transacciones
    document.getElementById("filtrarTransacciones").addEventListener("click", function() {
        //Elementos de la página
        const listado = document.getElementById("listaTransacciones");
        const desdeFecha = document.getElementById("fechaInicioTrans");
        const hastaFecha = document.getElementById("fechaFinTrans");
        const desdeUsuario = document.getElementById("usuarioInicioTrans");
        const hastaUsuario = document.getElementById("usuarioFinTrans");
        const desdeActividad = document.getElementById("actividadInicioTrans");
        const hastaActividad = document.getElementById("actividadFinTrans");
        const data = {
            accion: 'mostrar_transacciones',
            desdeFecha: desdeFecha.value.toString(),
            hastaFecha: hastaFecha.value.toString(),
            desdeUsuario: desdeUsuario.value,
            hastaUsuario: hastaUsuario.value,
            desdeActividad: desdeActividad.value,
            hastaActividad: hastaActividad.value,
        };
        
        // Limpiar formulario
        listado.innerHTML = "";
        // Cargar el HTML
        cargarHTML(data)
        .then(html =>{
            listado.innerHTML = html;
        });
    });

    //CLICK en filtrar Marcajes
    document.getElementById("filtrarMarcajes").addEventListener("click", function() {
        //Elementos de la página
        const listado = document.getElementById("listaMarcajes");
        const desdeFecha = document.getElementById("fechaInicioMarcaje");
        const hastaFecha = document.getElementById("fechaFinMarcaje");
        const desdeEmpleado = document.getElementById("empleadoInicioMarcaje");
        const hastaEmpleado = document.getElementById("empleadoFinMarcaje");
        const desdeTipo = document.getElementById("tipoInicioMarcaje");
        const hastaTipo = document.getElementById("tipoFinMarcaje");
        const data = {
            accion: 'mostrar_marcajes',
            desdeFecha: desdeFecha.value.toString(),
            hastaFecha: hastaFecha.value.toString(),
            desdeEmpleado: desdeEmpleado.value,
            hastaEmpleado: hastaEmpleado.value,
            desdeTipo: desdeTipo.value,
            hastaTipo: hastaTipo.value,
        };
        
        // Limpiar formulario
        listado.innerHTML = "";
        // Cargar el HTML
        cargarHTML(data)
        .then(html =>{
            listado.innerHTML = html;
        });
    });

    //CHANGE en el select de Roles
    document.getElementById("seleccionRol").addEventListener("change", function() {
        const formulario = document.getElementById("datosRol");
        const valorSeleccionado = this.value; // Obtiene el valor del select
        const data = {
            accion: 'mostrar_rol',
            cod_rol: valorSeleccionado 
        };
    
        // Limpiar formulario
        formulario.innerHTML = "";
        // Cargar el HTML
        cargarHTML(data)
        .then(html =>{
            formulario.innerHTML = html;
        });
    });

    //CHANGE en el select de usuarioRoles
    document.getElementById("seleccionUsuarioRol").addEventListener("change", function() {
        const formulario = document.getElementById("datosUsuarioRol");
        const valorSeleccionado = this.value; // Obtiene el valor del select
        const data = {
            accion: 'mostrar_usuariorol',
            cod_usuario: valorSeleccionado 
        };
    
        // Limpiar formulario
        formulario.innerHTML = "";
        // Cargar el HTML
        cargarHTML(data)
        .then(html =>{
            formulario.innerHTML = html;
        });
    });

    //CLICK en menú ajustes
    document.getElementById("menuAjustes").addEventListener("click", function() {
        const formulario = document.getElementById("panelAjustes");
        const data = {
            accion: 'mostrar_ajustes'
        };
    
        // Limpiar formulario
        formulario.innerHTML = "";
        // Cargar el HTML
        cargarHTML(data)
        .then(html =>{
            formulario.innerHTML = html;
        });
    });
});

async function cargarHTML(data){
    try {
        const response = await fetch('./logica/administracion_crud.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });
        
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        
        return await response.text();
    } catch (error) {
        console.error("Error:", error);
        return `<p class="error-message">Error al cargar los datos: ${error.message}</p>`;
    }
}

async function crud(datos){
    console.error(datos);
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
