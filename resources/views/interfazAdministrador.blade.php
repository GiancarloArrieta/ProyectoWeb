<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>Panel de Jefe de Soporte</title>
    <style>
        /* ------------------------------------- */
        /* Variables de Color (Esquema del Usuario: Cálido/Oscuro) */
        /* ------------------------------------- */
        :root {
            /* Colores Base del Usuario */
            --color-dark-primary: #2d3436; /* Negro/Gris Oscuro (Header, Botones, Texto) */
            --color-warm-accent: #fdcb6e;  /* Amarillo-Naranja (Acento principal) */
            --color-light-bg: #fffaf0;    /* Fondo de contenido muy claro */
            --color-soft-bg: #fff5e6;     /* Fondo de tarjetas (similar a #ffeaa7) */

            /* Colores de Estado/Acción */
            --color-info-blue: #0984e3;    /* Azul (Asignado) */
            --color-danger-red: #d63031;   /* Rojo (Cerrar Sesión) */
            --color-success-green: #00b894; /* Verde (Finalizado/Botón Reporte) */
            --color-pending-orange: #e67e22; /* Naranja (Pendiente) */
            --color-process-yellow: #f39c12; /* Amarillo (En Proceso) */
        }

        /* ------------------------------------- */
        /* BASE Y TIPOGRAFÍA */
        /* ------------------------------------- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            /* Fondo solicitado por el usuario */
            background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
            min-height: 100vh;
            color: var(--color-dark-primary);
            padding: 20px; /* Se añade padding al body para que el header quede flotante */
        }

        /* Títulos de sección */
        h2 { 
            color: var(--color-dark-primary); 
            font-weight: 700;
            font-size: 1.6em;
            border-bottom: 3px solid var(--color-warm-accent); 
            padding-bottom: 10px; 
            margin-bottom: 25px;
        }
        
        /* ------------------------------------- */
        /* HEADER (Encabezado superior) */
        /* ------------------------------------- */
        header { 
            background-color: var(--color-dark-primary); /* Negro/Gris oscuro */
            color: white;
            padding: 25px 40px;
            border-radius: 15px;
            margin-bottom: 30px; /* Separación del resto del contenido */
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2); 
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }
        header h1 { 
            margin: 0; 
            font-size: 1.8em;
            font-weight: 700;
        }

        /* Botón de Cerrar Sesión */
        .btn-close { 
            background-color: var(--color-danger-red); 
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-close:hover {
            background-color: #e74c3c;
        }


        /* ------------------------------------- */
        /* LAYOUT PRINCIPAL (Contenedor de Sidebar y Main) */
        /* ------------------------------------- */
        .admin-layout {
            display: flex;
            max-width: 1400px;
            margin: 0 auto;
            border-radius: 15px;
            overflow: hidden; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        /* ------------------------------------- */
        /* SIDEBAR (ASIDE) */
        /* ------------------------------------- */
        aside {
            width: 250px; /* Un poco más compacto */
            padding: 30px 20px;
            background-color: var(--color-light-bg); /* Fondo muy claro */
            border-right: 5px solid var(--color-warm-accent); /* Acento visual cálido */
            flex-shrink: 0;
        }
        aside h3 {
            color: var(--color-dark-primary);
            font-size: 1.3em;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ddd;
        }
        aside nav a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--color-dark-primary);
            padding: 15px 10px;
            margin: 10px 0;
            border-radius: 8px;
            transition: background-color 0.2s, color 0.2s;
            font-weight: 500;
            gap: 10px;
        }
        aside nav a:hover {
            background-color: var(--color-warm-accent);
            color: var(--color-dark-primary);
            font-weight: 600;
        }

        /* ------------------------------------- */
        /* MAIN CONTENT (MAIN) */
        /* ------------------------------------- */
        main {
            flex-grow: 1;
            padding: 30px;
            background-color: white; /* Fondo blanco para el contenido */
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        /* Estilo de Tarjeta (Card) para secciones en el main */
        .card-panel {
            padding: 30px;
            border-radius: 10px;
            background-color: var(--color-soft-bg); /* Fondo suave de tarjeta */
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border: 1px solid #ffeaa7;
        }
        
        /* ------------------------------------- */
        /* DASHBOARD Y GRÁFICAS */
        /* ------------------------------------- */
        .charts-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }
        
        .chart-placeholder {
            background-color: white;
            border: 2px solid #ffeaa7;
            border-radius: 12px;
            padding: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 200px;
        }
        
        .chart-placeholder h4 {
            margin: 0;
            padding: 18px 20px;
            background-color: var(--color-dark-primary);
            color: white;
            font-size: 1.1em;
            font-weight: 600;
            border-bottom: 2px solid var(--color-warm-accent);
        }
        
        .chart-placeholder table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            flex: 1;
        }
        
        .chart-placeholder thead {
            background-color: #f8f9fa;
        }
        
        .chart-placeholder thead th {
            padding: 12px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9em;
            color: var(--color-dark-primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e9ecef;
        }
        
        .chart-placeholder thead th:last-child {
            text-align: right;
        }
        
        .chart-placeholder tbody td {
            padding: 12px 20px;
            color: #2d3436;
            font-size: 0.95em;
            border-bottom: 1px solid #f1f3f5;
        }
        
        .chart-placeholder tbody td:last-child {
            text-align: right;
            font-weight: 600;
            color: var(--color-dark-primary);
        }
        
        .chart-placeholder tbody tr:last-child td {
            border-bottom: none;
        }
        
        .chart-placeholder tbody tr:hover {
            background-color: #fffbf0;
        }
        
        .chart-placeholder tbody tr:nth-child(even) {
            background-color: #fafafa;
        }
        
        .chart-placeholder tbody tr:nth-child(even):hover {
            background-color: #fffbf0;
        }
        
        /* Responsive para Dashboard */
        @media (max-width: 1200px) {
            .charts-section {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 20px;
            }
        }
        
        @media (max-width: 768px) {
            .charts-section {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .chart-placeholder {
                min-height: 180px;
            }
            
            .chart-placeholder h4 {
                padding: 15px;
                font-size: 1em;
            }
            
            .chart-placeholder thead th,
            .chart-placeholder tbody td {
                padding: 10px 15px;
                font-size: 0.9em;
            }
        }

        /* ------------------------------------- */
        /* CONTROLES Y FILTROS */
        /* ------------------------------------- */
        .controls-panel {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background-color: white;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .controls-panel label {
            font-weight: 600;
            color: var(--color-dark-primary);
        }
        .controls-panel select {
            padding: 10px 15px;
            border-radius: 6px;
            border: 1px solid var(--color-warm-accent);
            font-size: 1em;
            min-width: 200px;
            background-color: #fcfcfc;
        }

        /* Botón de Generar Reporte */
        .btn-reporte {
            border: none; 
            padding: 10px 18px; 
            border-radius: 6px; 
            cursor: pointer; 
            font-weight: 600;
            transition: background-color 0.3s, box-shadow 0.3s;
            font-size: 0.95em;

            background-color: var(--color-success-green);
            color: white;
            box-shadow: 0 4px 10px rgba(0, 184, 148, 0.3);
            margin-left: auto;
        }
        .btn-reporte:hover {
            background-color: #008f71;
        }

        /* ------------------------------------- */
        /* TABLA DE TICKETS */
        /* ------------------------------------- */
        #tabla-tickets {
            width: 100%;
            border-collapse: separate; 
            border-spacing: 0;
            margin-top: 15px; 
            text-align: left; 
            font-size: 0.9em;
            overflow: hidden; 
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        #tabla-tickets th, #tabla-tickets td {
            padding: 12px 15px; 
            border-bottom: 1px solid #f4f4f4; 
        }
        #tabla-tickets thead tr {
            background-color: var(--color-dark-primary); 
            color: white;
        }
        #tabla-tickets tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        #tabla-tickets tbody tr:hover {
            background-color: #f1f1f1;
        }
        #tabla-tickets tbody tr[onclick]:hover {
            background-color: #ffe8c0; /* Resaltar filas Pendientes con color cálido */
            cursor: pointer;
        }

        /* Estilos del Badge de Estatus (más detallados) */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
            min-width: 90px;
            text-align: center;
            text-transform: uppercase;
        }

        /* Colores de Estatus */
        .status-Pendiente { background-color: var(--color-pending-orange); color: white; }
        .status-Asignado { background-color: var(--color-info-blue); color: white; }
        .status-En-Proceso { background-color: var(--color-process-yellow); color: var(--color-dark-primary); }
        .status-Finalizado { background-color: var(--color-success-green); color: white; }


        /* ------------------------------------- */
        /* ESTILOS DEL MODAL (Inyectado por JS) */
        /* ------------------------------------- */
        .modal-card {
            background-color: white; 
            padding: 30px; 
            border-radius: 10px; 
            max-width: 500px; 
            width: 90%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
            border: 3px solid var(--color-warm-accent);
        }
        .modal-card h3 {
            margin-top: 0;
            color: var(--color-dark-primary);
            border-bottom: 2px solid var(--color-warm-accent);
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-size: 1.5em;
        }
        .modal-card select {
            width: 100%; 
            padding: 12px; 
            margin: 15px 0; 
            border: 1px solid #ddd; 
            border-radius: 6px;
            font-size: 1em;
            background-color: #fcfcfc;
        }
        .btn-modal { 
            border: none; 
            padding: 10px 20px; 
            border-radius: 6px; 
            cursor: pointer; 
            font-weight: 600;
            transition: background-color 0.3s;
        }
        .btn-cancel {
            background-color: #95a5a6;
            color: white;
        }
        .btn-assign {
            background-color: var(--color-info-blue);
            color: white;
        }

    </style>
</head>
<body>
    
    <header>
        <h1><span style="color: var(--color-warm-accent); font-size: 1.2em;">👑</span> Panel de Jefe de Soporte</h1>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn-close">
                Cerrar Sesión
            </button>
        </form>
    </header>

    <div class="admin-layout">
        
        <aside>
            <h3>Gestión del Sistema</h3>
            <nav>
                <a href="/gestionarusuarios">👥 Crear Usuarios y Roles</a>
                <a href="/administrardepartamentos">🏢 Administrar Departamentos</a>
                <a href="/gestionauxiliares">🛠️ Gestión de Auxiliares</a>
                <a href="/reportesestadisticas">📈 Reportes y Estadísticas</a>
            </nav>
        </aside>

        <main>
            
            <section id="reportes-graficas" class="card-panel">
                <h2>📈 Dashboard de Indicadores</h2>
                
                <div class="charts-section">
                    <div id="chart-pendientes-finalizados" class="chart-placeholder">
                        <h4>Tickets Pendientes vs. Finalizados</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>Estado</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-pendientes-finalizados">
                                <tr>
                                    <td colspan="2" style="text-align: center; padding: 20px; color: #7f8c8d;">
                                        Cargando...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div id="chart-por-departamento" class="chart-placeholder">
                        <h4>Tickets por Departamento</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>Departamento</th>
                                    <th>Tickets</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-por-departamento">
                                <tr>
                                    <td colspan="2" style="text-align: center; padding: 20px; color: #7f8c8d;">
                                        Cargando...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div id="chart-productividad" class="chart-placeholder">
                        <h4>Productividad por Auxiliar</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>Auxiliar</th>
                                    <th>Finalizados</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-productividad">
                                <tr>
                                    <td colspan="2" style="text-align: center; padding: 20px; color: #7f8c8d;">
                                        Cargando...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            
            <section id="todos-los-tickets" class="card-panel">
                <h2>🎫 Todos los Tickets del Sistema</h2>
                
                <div class="controls-panel">
                    <label for="filtro-estatus">Filtrar por Estatus:</label>
                    <select id="filtro-estatus" onchange="filtrarTickets()">
                        <option value="todos">Todos</option>
                        <option value="Pendiente">Pendientes</option>
                        <option value="En Proceso">En Proceso</option>
                        <option value="Finalizado">Finalizados</option>
                    </select>

                    <button type="button" onclick="generarReporte()" class="btn-reporte">
                        📄 Generar Reporte de Finalizados
                    </button>
                </div>
                
                <table id="tabla-tickets">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha Creación</th>
                            <th>Usuario</th>
                            <th>Título</th>
                            <th>Departamento</th>
                            <th>Estatus</th>
                            <th>Auxiliar Asignado</th>
                        </tr>
                    </thead>
                    <tbody id="tickets-tbody">
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px; color: #7f8c8d;">
                                Cargando tickets...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <script>
        let todosLosTickets = [];
        let auxiliaresDisponibles = [];

        // Cargar tickets y auxiliares al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Asegúrate de que el token CSRF está presente para las llamadas de asignación
            if (!document.querySelector('meta[name="csrf-token"]')) {
                console.warn('Advertencia: Falta la etiqueta <meta name="csrf-token">. Las llamadas POST podrían fallar.');
            }
            cargarTickets();
            cargarAuxiliares();
            cargarIndicadoresDashboard();
            // Actualizar indicadores cada 30 segundos
            setInterval(cargarIndicadoresDashboard, 30000);
        });

        // Cargar todos los tickets
        async function cargarTickets() {
            try {
                const response = await fetch('/api/tickets/todos');
                if (!response.ok) throw new Error('Error al cargar tickets');
                
                todosLosTickets = await response.json();
                mostrarTickets(todosLosTickets);
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('tickets-tbody').innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: var(--color-danger-red);">
                            Error al cargar los tickets
                        </td>
                    </tr>
                `;
            }
        }

        // Cargar auxiliares disponibles
        async function cargarAuxiliares() {
            try {
                const response = await fetch('/api/auxiliares/disponibles');
                if (!response.ok) throw new Error('Error al cargar auxiliares');
                
                auxiliaresDisponibles = await response.json();
            } catch (error) {
                console.error('Error al cargar auxiliares:', error);
            }
        }

        // Mostrar tickets en la tabla
        function mostrarTickets(tickets) {
            const tbody = document.getElementById('tickets-tbody');
            
            if (tickets.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: #7f8c8d;">
                            No hay tickets registrados
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = tickets.map(ticket => {
                const fechaCreacion = new Date(ticket.created_at).toLocaleDateString('es-ES');
                const auxiliar = ticket.auxiliar_asignado ? ticket.auxiliar_asignado.nombre : 'Sin asignar';
                
                // Mapear el estado a una clase CSS
                const statusClass = `status-${ticket.status.replace(/\s/g, '-')}`;
                
                // Hacer la fila clickeable para asignar solo si está pendiente
                const isPending = ticket.status === 'Pendiente';
                const rowStyle = isPending ? 'cursor: pointer;' : '';
                const rowClick = isPending ? `onclick="mostrarModalAsignar(${ticket.id})"` : '';

                return `
                    <tr ${rowClick} style="${rowStyle}">
                        <td>${ticket.id}</td>
                        <td>${fechaCreacion}</td>
                        <td>${ticket.usuario.nombre}</td>
                        <td>${ticket.título}</td>
                        <td>${ticket.departamento_asignado ? ticket.departamento_asignado.nombre : 'N/A'}</td>
                        <td><span class="status-badge ${statusClass}">${ticket.status}</span></td>
                        <td>${auxiliar}</td>
                    </tr>
                `;
            }).join('');
        }

        // Filtrar tickets por estado
        function filtrarTickets() {
            const filtroEstatus = document.getElementById('filtro-estatus').value;
            
            if (filtroEstatus === 'todos') {
                mostrarTickets(todosLosTickets);
            } else {
                const ticketsFiltrados = todosLosTickets.filter(ticket => ticket.status === filtroEstatus);
                mostrarTickets(ticketsFiltrados);
            }
        }

        // Mostrar modal para asignar ticket
        async function mostrarModalAsignar(ticketId) {
            await cargarAuxiliares();
            
            if (auxiliaresDisponibles.length === 0) {
                alert('No hay auxiliares registrados en el sistema.');
                return;
            }

            const opcionesAuxiliares = auxiliaresDisponibles.map(aux => {
                const ticketsInfo = aux.tickets_activos > 0 ? ` - ${aux.tickets_activos} ticket(s) activo(s)` : '';
                return `<option value="${aux.id}">${aux.nombre}${ticketsInfo}</option>`;
            }).join('');

            const html = `
                <div id="modal-asignar" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(45, 52, 54, 0.7); display: flex; justify-content: center; align-items: center; z-index: 1000;">
                    <div class="modal-card">
                        <h3>Asignar Ticket #${ticketId}</h3>
                        <p style="color: #555;">Seleccione un auxiliar disponible para asignar este ticket:</p>
                        <select id="select-auxiliar">
                            <option value="">Seleccione un auxiliar...</option>
                            ${opcionesAuxiliares}
                        </select>
                        <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                            <button onclick="cerrarModal()" class="btn-modal btn-cancel">Cancelar</button>
                            <button onclick="asignarTicket(${ticketId})" class="btn-modal btn-assign">Asignar</button>
                        </div>
                    </div>
                </div>
            `;

            document.body.insertAdjacentHTML('beforeend', html);
        }

        // Cerrar modal
        function cerrarModal() {
            const modal = document.getElementById('modal-asignar');
            if (modal) modal.remove();
        }

        // Asignar ticket a auxiliar
        async function asignarTicket(ticketId) {
            const auxiliarId = document.getElementById('select-auxiliar').value;
            
            if (!auxiliarId) {
                alert('Por favor seleccione un auxiliar');
                return;
            }

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch(`/api/tickets/${ticketId}/asignar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ id_auxiliar: auxiliarId })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    alert('Ticket asignado exitosamente');
                    cerrarModal();
                    // Recargar tickets para actualizar la tabla
                    cargarTickets();
                    // Actualizar indicadores
                    cargarIndicadoresDashboard();
                } else {
                    alert('Error: ' + (data.message || 'Error desconocido al asignar.'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al asignar el ticket');
            }
        }

        // Cargar indicadores del dashboard
        async function cargarIndicadoresDashboard() {
            try {
                const response = await fetch('/api/dashboard/indicadores');
                if (!response.ok) throw new Error('Error al cargar indicadores');
                
                const data = await response.json();
                
                // Actualizar tabla de Pendientes vs Finalizados
                const tbodyPendientes = document.getElementById('tabla-pendientes-finalizados');
                if (tbodyPendientes) {
                    if (data.pendientes !== undefined && data.finalizados !== undefined) {
                        tbodyPendientes.innerHTML = `
                            <tr>
                                <td>Pendientes</td>
                                <td>${data.pendientes || 0}</td>
                            </tr>
                            <tr>
                                <td>Finalizados</td>
                                <td>${data.finalizados || 0}</td>
                            </tr>
                        `;
                    } else {
                        tbodyPendientes.innerHTML = `
                            <tr>
                                <td colspan="2" style="text-align: center; padding: 20px; color: #7f8c8d;">
                                    No hay datos disponibles
                                </td>
                            </tr>
                        `;
                    }
                }
                
                // Actualizar tabla por Departamento
                const tbodyDepartamentos = document.getElementById('tabla-por-departamento');
                if (tbodyDepartamentos) {
                    if (data.por_departamento && data.por_departamento.length > 0) {
                        tbodyDepartamentos.innerHTML = data.por_departamento.map((dept, index) => `
                            <tr>
                                <td>${dept.nombre || 'Sin departamento'}</td>
                                <td>${dept.total || 0}</td>
                            </tr>
                        `).join('');
                    } else {
                        tbodyDepartamentos.innerHTML = `
                            <tr>
                                <td colspan="2" style="text-align: center; padding: 20px; color: #7f8c8d;">
                                    No hay departamentos con tickets
                                </td>
                            </tr>
                        `;
                    }
                }
                
                // Actualizar tabla de Productividad
                const tbodyProductividad = document.getElementById('tabla-productividad');
                if (tbodyProductividad) {
                    if (data.productividad && data.productividad.length > 0) {
                        tbodyProductividad.innerHTML = data.productividad.map((aux, index) => `
                            <tr>
                                <td>${aux.nombre || 'Sin nombre'}</td>
                                <td>${aux.finalizados || 0}</td>
                            </tr>
                        `).join('');
                    } else {
                        tbodyProductividad.innerHTML = `
                            <tr>
                                <td colspan="2" style="text-align: center; padding: 20px; color: #7f8c8d;">
                                    No hay auxiliares registrados
                                </td>
                            </tr>
                        `;
                    }
                }
            } catch (error) {
                console.error('Error al cargar indicadores:', error);
            }
        }

        // Generar reporte de tickets finalizados
        async function generarReporte() {
            try {
                const response = await fetch('/api/tickets/reporte/finalizados');
                if (!response.ok) throw new Error('Error al generar reporte');
                
                const data = await response.json();
                
                if (data.total === 0) {
                    alert('No hay tickets finalizados para generar reporte');
                    return;
                }

                // Generación de la tabla HTML para impresión
                let reporteHtml = `
                    <html>
                    <head>
                        <title>Reporte de Tickets Finalizados</title>
                        <style>
                            /* Estilos de impresión */
                            body { font-family: Arial, sans-serif; padding: 20px; }
                            h1 { color: var(--color-dark-primary); }
                            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                            th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                            th { background-color: var(--color-dark-primary); color: white; }
                            tr:nth-child(even) { background-color: #f2f2f2; }
                        </style>
                    </head>
                    <body>
                        <h1>📊 Reporte de Tickets Finalizados</h1>
                        <p><strong>Total de tickets finalizados:</strong> ${data.total}</p>
                        <p><strong>Fecha de generación:</strong> ${new Date().toLocaleString('es-ES')}</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Usuario</th>
                                    <th>Auxiliar</th>
                                    <th>Fecha Creación</th>
                                    <th>Fecha Finalización</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                data.tickets.forEach(ticket => {
                    const fechaCreacion = new Date(ticket.created_at).toLocaleDateString('es-ES');
                    const fechaFin = ticket.fecha_finalizacion ? new Date(ticket.fecha_finalizacion).toLocaleDateString('es-ES') : 'N/A';
                    reporteHtml += `
                        <tr>
                            <td>${ticket.id}</td>
                            <td>${ticket.título}</td>
                            <td>${ticket.usuario.nombre}</td>
                            <td>${ticket.auxiliar_asignado ? ticket.auxiliar_asignado.nombre : 'N/A'}</td>
                            <td>${fechaCreacion}</td>
                            <td>${fechaFin}</td>
                        </tr>
                    `;
                });

                reporteHtml += `
                            </tbody>
                        </table>
                    </body>
                    </html>
                `;

                // Abrir en nueva ventana para imprimir
                const ventana = window.open('', '_blank');
                ventana.document.write(reporteHtml);
                ventana.document.close();
                ventana.print();
            } catch (error) {
                console.error('Error:', error);
                alert('Error al generar el reporte');
            }
        }
    </script>

</body>
</html>