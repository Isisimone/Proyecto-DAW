
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
    // 
});


function seleccionarEmpleado(elemento) {
    const codEmpleado = elemento.getAttribute('data-cod');
    document.getElementById('cod_empleado').value = codEmpleado;
    document.getElementById('dropdownEmpleados').textContent = elemento.textContent.trim();
}






/* Métodos previos */
/*
// Función para actualizar dinámicamente el contenido
function updateContent(section) {
    const dynamicContent = document.getElementById('dynamicContent');
    const welcomeMessage = document.getElementById('welcome-message');

  

    // Selección de contenido según la sección
    switch (section) {
        case 'principal':
            renderPrincipalContent();
            break;
        case 'empleados':
            renderEmpleadosContent();
            break;
        case 'usuarios':
            renderUsuariosContent();
            break;
        case 'registro':
            renderRegistroContent();
            break;
        case 'roles':
            renderRolesContent();
            break;
        case 'permisos_roles':
            renderPermisosRolesContent();
            break;
        default:
            dynamicContent.innerHTML = `<h2>Sección no encontrada</h2>`;
    }
}

// Función para renderizar contenido de la sección "Principal"
function renderPrincipalContent() {
    const dynamicContent = document.getElementById('dynamicContent');
    dynamicContent.innerHTML = `
        <h2>Hora Actual</h2>
        <p id="current-time">Cargando...</p>

        <h2>Última Entrada/Salida</h2>
        <p>Empleado: Juan Pérez</p>
        <p>Hora: 08:45 AM</p>

        <h2>Foto del Empleado</h2>
        <img src="empleado.jpg" alt="Foto del Empleado" class="employee-photo">

        <h2>Tiempo Trabajado</h2>
        <p>Horas trabajadas hoy: 6h 30m</p>

        <h2>Gráfico de Asistencia</h2>
        <canvas id="attendanceChart"></canvas>
    `;
    updateTime();  // Actualizamos la hora
    loadChart();  // Cargamos el gráfico
}

// Función para renderizar contenido de la sección "Empleados"
function renderEmpleadosContent() {
    const dynamicContent = document.getElementById('dynamicContent');
    dynamicContent.innerHTML = `
        <h2>Gestión de Empleados</h2>
        <p>Aquí podrás ver y gestionar los empleados registrados en el sistema.</p>
        <ul>
            <li>Empleado 1: Juan Pérez</li>
            <li>Empleado 2: María López</li>
            <li>Empleado 3: Carlos García</li>
        </ul>
    `;
}

// Función para renderizar contenido de la sección "Usuarios"
function renderUsuariosContent() {
    const dynamicContent = document.getElementById('dynamicContent');
    dynamicContent.innerHTML = `
        <h2>Gestión de Usuarios</h2>
        <p>Aquí podrás agregar o eliminar usuarios del sistema.</p>
        ${renderAddUserForm()}
        ${renderDeleteUserForm()}
    `;
}

// Función para renderizar el formulario de agregar usuario
function renderAddUserForm() {
    return `
        <h3>Agregar Usuario</h3>
        <form id="add-user-form" method="POST" enctype="multipart/form-data">
            <label for="user-name">Nombre:</label>
            <input type="text" id="user-name" name="user-name" required>
            <label for="user-photo">Foto (Escaneo Facial):</label>
            <input type="file" id="user-photo" name="user-photo" accept="image/*" required>
            <button type="submit" name="add-user">Agregar Usuario</button>
        </form>
    `;
}

// Función para renderizar el formulario de eliminar usuario
function renderDeleteUserForm() {
    return `
        <h3>Eliminar Usuario</h3>
        <form id="delete-user-form" method="POST">
            <label for="user-id">Seleccionar Usuario:</label>
            <select id="user-id" name="user-id" required>
                <option value="1">Juan Pérez</option>
                <option value="2">María López</option>
                <option value="3">Carlos García</option>
            </select>
            <button type="submit" name="delete-user">Eliminar Usuario</button>
        </form>
    `;
}

// Función para renderizar contenido de la sección "Registro"
function renderRegistroContent() {
    const dynamicContent = document.getElementById('dynamicContent');
    dynamicContent.innerHTML = `
        <h2>Registro de Actividades</h2>
        <p>Aquí podrás ver un historial de las actividades registradas en el sistema.</p>
        <ul>
            <li>Actividad 1: Registro de entrada de Juan Pérez - 08:00 AM</li>
            <li>Actividad 2: Registro de salida de María López - 05:30 PM</li>
            <li>Actividad 3: Registro de entrada de Carlos García - 09:00 AM</li>
        </ul>
    `;
}

// Función para renderizar contenido de la sección "Roles"
function renderRolesContent() {
    const dynamicContent = document.getElementById('dynamicContent');
    dynamicContent.innerHTML = `
        <h2>Gestión de Roles</h2>
        <p>Aquí podrás ver y gestionar los roles de los usuarios.</p>
        <ul>
            <li><strong>Administrador</strong> - Acceso total al sistema.</li>
            <li><strong>Empleado</strong> - Acceso limitado a tareas y registros.</li>
            <li><strong>Supervisor</strong> - Acceso para supervisar a los empleados.</li>
        </ul>
    `;
}

// Función para renderizar contenido de la sección "Permisos y Roles"
function renderPermisosRolesContent() {
    const dynamicContent = document.getElementById('dynamicContent');
    dynamicContent.innerHTML = `
        <h2>Asignación de Roles a Usuarios</h2>
        <p>Aquí podrás buscar usuarios y asignarles roles.</p>

        <div>
            <label for="search-user">Buscar Usuario:</label>
            <input type="text" id="search-user" placeholder="Buscar por nombre..." oninput="searchUser()">
        </div>

        <div id="search-results">
            <p>No hay resultados.</p>
        </div>

        <h3>Asignar Rol</h3>
        <form id="assign-role-form" method="POST">
            <label for="user-select">Seleccionar Usuario:</label>
            <select id="user-select" name="user-select" required></select>

            <label for="role-select"> Seleccionar Rol:</label>
            <select id="role-select" name="role-select" required>
                <option value="admin">Administrador</option>
                <option value="empleado">Empleado</option>
                <option value="supervisor">Supervisor</option>
            </select>

            <button type="submit" name="assign-role">Asignar Rol</button>
        </form>
    `;
}*/

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
