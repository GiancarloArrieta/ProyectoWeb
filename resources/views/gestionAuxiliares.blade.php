<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Auxiliares - Admin</title>
    <style>
        /* ------------------------------------- */
        /* Variables de Color (Esquema del Usuario: Cálido/Oscuro) */
        /* ------------------------------------- */
        :root {
            /* Colores Base del Usuario */
            --color-dark-primary: #2d3436; /* Negro/Gris Oscuro (Header, Botones, Texto) */
            --color-warm-accent: #fdcb6e;  /* Amarillo-Naranja (Acento principal) */
            --color-soft-bg: #fff5e6;     /* Fondo de tarjetas */

            /* Colores de Estado/Acción */
            --color-info-blue: #0984e3;    /* Azul (Botón Principal) */
            --color-danger-red: #d63031;   /* Rojo (Botón Eliminar) */
            --color-success-green: #00b894; /* Verde (Éxito) */
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
            /* Fondo degradado cálido */
            background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
            min-height: 100vh;
            color: var(--color-dark-primary);
            padding: 20px;
        }

        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            color: var(--color-dark-primary);
            font-weight: 700;
            font-size: 2.2em;
            margin-bottom: 20px;
        }

        h3 {
            color: var(--color-dark-primary);
            font-size: 1.5em;
            padding-bottom: 10px;
            margin-bottom: 25px;
            border-bottom: 3px solid var(--color-warm-accent);
        }

        /* ------------------------------------- */
        /* HEADER (Encabezado superior) */
        /* ------------------------------------- */
        header {
            background-color: var(--color-dark-primary);
            color: white;
            padding: 25px 40px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        header h1 {
            margin: 0;
            font-size: 1.8em;
            font-weight: 700;
        }
        header h1 span {
            color: var(--color-warm-accent);
        }
        header nav a {
            color: var(--color-warm-accent);
            text-decoration: none;
            font-weight: 600;
            padding: 10px 15px;
            border: 2px solid var(--color-warm-accent);
            border-radius: 8px;
            transition: background-color 0.3s, color 0.3s;
        }
        header nav a:hover {
            background-color: var(--color-warm-accent);
            color: var(--color-dark-primary);
        }

        /* ------------------------------------- */
        /* SECCIONES (CARDS) */
        /* ------------------------------------- */
        section {
            background-color: var(--color-soft-bg); /* Fondo suave de tarjeta */
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: 2px solid #ffeaa7; /* Borde suave */
        }

        #content-header p {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 0;
        }

        /* ------------------------------------- */
        /* FORMULARIOS y FILTROS */
        /* ------------------------------------- */
        .filter-group {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        #rendimiento-auxiliares > div {
             /* Estilo para el grupo de filtro */
             display: flex;
             align-items: center;
             gap: 15px;
             margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--color-dark-primary);
            font-size: 0.95em;
        }
        
        input[type="number"],
        select {
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s, box-shadow 0.3s;
            background-color: white;
            min-width: 200px;
        }
        input:focus,
        select:focus {
            border-color: var(--color-warm-accent);
            box-shadow: 0 0 5px rgba(253, 203, 110, 0.5);
            outline: none;
        }

        /* Formulario de Asignación Rápida (Grid Layout) */
        #asignacion-manual form {
            display: grid;
            grid-template-columns: 1fr 1fr 200px; /* Columna para input, Columna para select, Columna para botón */
            gap: 20px;
            align-items: flex-end; /* Alinea los elementos al final (botón a la misma altura del input) */
        }
        #asignacion-manual form > div {
            display: flex;
            flex-direction: column;
        }

        /* Botón de Asignar (Acción Principal) */
        form button[type="submit"] {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 700;
            transition: background-color 0.3s;
            background-color: var(--color-info-blue); /* Azul para acción principal */
            color: white;
            width: 100%;
        }
        form button[type="submit"]:hover {
            background-color: #0c6ccf;
        }

        /* ------------------------------------- */
        /* TABLA DE RENDIMIENTO */
        /* ------------------------------------- */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        thead {
            background-color: var(--color-dark-primary);
            color: white;
        }
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9em;
            text-transform: uppercase;
        }
        tbody tr {
            background-color: white;
            transition: background-color 0.2s;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9; /* Alternar colores de fila */
        }
        tbody tr:hover {
            background-color: #ffe8c0; /* Resaltar con color cálido al pasar el ratón */
        }
        td {
            padding: 12px 15px;
            color: #2d3436;
            font-size: 0.95em;
            vertical-align: middle;
        }

        /* Botones de Acción en la Tabla */
        td button {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9em;
            transition: background-color 0.3s;
            white-space: nowrap; /* Evita que el texto se rompa */
        }

        td button:first-of-type { /* Ver Perfil (Acción Secundaria/Info) */
            background-color: var(--color-warm-accent);
            color: var(--color-dark-primary);
        }
        td button:first-of-type:hover {
            background-color: #f0a747;
        }

        td button:last-of-type { /* Asignar Ticket (Acción de Proceso) */
            background-color: var(--color-success-green); /* Usamos verde para acciones de ticket */
            color: white;
            margin-left: 5px;
        }
        td button:last-of-type:hover {
            background-color: #008f75;
        }
        
        /* Responsive Básico */
        @media (max-width: 900px) {
            #asignacion-manual form {
                grid-template-columns: 1fr;
            }
            #asignacion-manual form button[type="submit"] {
                width: 100%;
            }
        }
        @media (max-width: 600px) {
             header {
                flex-direction: column;
                gap: 15px;
            }
        }

    </style>
</head>
<body>

    <header>
        <h1><span>🛠️</span> Panel de Administración</h1>
        <nav>
            <a href="/interfazadministrador">← Volver al Dashboard</a>
        </nav>
    </header>

    <main>

        <section id="content-header">
            <h2>🛠️ Gestión de Auxiliares Técnicos</h2>
            <p>Monitoreo del desempeño y administración de tickets del equipo de soporte.</p>
        </section>

        <section id="rendimiento-auxiliares">
            <h3>📊 Rendimiento del Equipo de Soporte</h3>

            <div>
                <label for="periodo_reporte">Filtrar Periodo:</label>
                <select id="periodo_reporte" onchange="cargarRendimiento()">
                    <option value="mes_actual">Mes Actual</option>
                    <option value="trimestre">Último Trimestre</option>
                    <option value="anual">Año Actual</option>
                </select>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Auxiliar</th>
                        <th>Tickets Asignados (Total)</th>
                        <th>Tickets Finalizados</th>
                        <th>Tickets Pendientes</th>
                        <th>Promedio de Cierre (Horas/Días)</th>
                    </tr>
                </thead>
                <tbody id="rendimiento-tbody">
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px; color: #7f8c8d;">
                            Cargando datos...
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section id="asignacion-manual">
            <h3>⚙️ Asignación Rápida de Ticket Pendiente</h3>

            <form id="form-asignacion-manual">
                @csrf
                <div>
                    <label for="ticket_pendiente">Ticket Pendiente:</label>
                    <select id="ticket_pendiente" name="ticket_id" required>
                        <option value="">Cargando tickets...</option>
                    </select>
                </div>

                <div>
                    <label for="auxiliar_destino">Asignar a:</label>
                    <select id="auxiliar_destino" name="auxiliar_id" required>
                        <option value="">Cargando auxiliares...</option>
                    </select>
                </div>

                <button type="submit">Asignar Ticket</button>
            </form>
        </section>

    </main>

    <script>
        // Cargar datos al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            cargarRendimiento();
            cargarTicketsPendientes();
            cargarAuxiliares();
            // Actualizar cada 30 segundos
            setInterval(cargarRendimiento, 30000);
            setInterval(cargarTicketsPendientes, 30000);
        });

        // Cargar rendimiento de auxiliares
        async function cargarRendimiento() {
            try {
                const periodo = document.getElementById('periodo_reporte').value;
                const response = await fetch(`/api/auxiliares/rendimiento?periodo=${periodo}`);
                if (!response.ok) throw new Error('Error al cargar rendimiento');
                
                const data = await response.json();
                const tbody = document.getElementById('rendimiento-tbody');
                
                if (!data || data.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px; color: #7f8c8d;">
                                No hay auxiliares registrados
                            </td>
                        </tr>
                    `;
                    return;
                }

                tbody.innerHTML = data.map(aux => {
                    const promedio = aux.promedio_cierre && aux.promedio_cierre > 0 
                        ? `${aux.promedio_cierre.toFixed(1)} horas` 
                        : 'N/A';
                    return `
                        <tr>
                            <td>${aux.id}</td>
                            <td>${aux.nombre}</td>
                            <td>${aux.total_asignados || 0}</td>
                            <td>${aux.finalizados || 0}</td>
                            <td>${aux.pendientes || 0}</td>
                            <td>${promedio}</td>
                        </tr>
                    `;
                }).join('');
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('rendimiento-tbody').innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px; color: var(--color-danger-red);">
                            Error al cargar los datos
                        </td>
                    </tr>
                `;
            }
        }

        // Cargar tickets pendientes
        async function cargarTicketsPendientes() {
            try {
                const response = await fetch('/api/tickets/todos');
                if (!response.ok) throw new Error('Error al cargar tickets');
                
                const tickets = await response.json();
                const pendientes = tickets.filter(t => t.status === 'Pendiente');
                const select = document.getElementById('ticket_pendiente');
                
                if (pendientes.length === 0) {
                    select.innerHTML = '<option value="">No hay tickets pendientes</option>';
                    return;
                }

                select.innerHTML = '<option value="">Seleccionar Ticket</option>' + 
                    pendientes.map(ticket => 
                        `<option value="${ticket.id}">#${ticket.id} - ${ticket.título} (${ticket.usuario ? ticket.usuario.nombre : 'N/A'})</option>`
                    ).join('');
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Cargar auxiliares
        async function cargarAuxiliares() {
            try {
                const response = await fetch('/api/auxiliares/disponibles');
                if (!response.ok) throw new Error('Error al cargar auxiliares');
                
                const auxiliares = await response.json();
                const select = document.getElementById('auxiliar_destino');
                
                if (auxiliares.length === 0) {
                    select.innerHTML = '<option value="">No hay auxiliares disponibles</option>';
                    return;
                }

                select.innerHTML = '<option value="">Seleccionar Auxiliar</option>' + 
                    auxiliares.map(aux => 
                        `<option value="${aux.id}">${aux.nombre}${aux.tickets_activos > 0 ? ` - ${aux.tickets_activos} ticket(s) activo(s)` : ''}</option>`
                    ).join('');
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Manejar envío del formulario de asignación
        document.getElementById('form-asignacion-manual').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const ticketId = document.getElementById('ticket_pendiente').value;
            const auxiliarId = document.getElementById('auxiliar_destino').value;
            
            if (!ticketId || !auxiliarId) {
                alert('Por favor seleccione un ticket y un auxiliar');
                return;
            }

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                const response = await fetch(`/api/tickets/${ticketId}/asignar`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id_auxiliar: auxiliarId }),
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    alert('Ticket asignado exitosamente');
                    document.getElementById('form-asignacion-manual').reset();
                    cargarTicketsPendientes();
                    cargarAuxiliares();
                    cargarRendimiento();
                } else {
                    alert('Error: ' + (data.message || 'Error desconocido al asignar'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al asignar el ticket');
            }
        });
    </script>

</body>
</html>