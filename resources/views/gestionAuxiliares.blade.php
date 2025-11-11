<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <select id="periodo_reporte">
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
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>501</td>
                        <td>Juan Pérez</td>
                        <td>50</td>
                        <td>45</td>
                        <td>5</td>
                        <td>8.5 horas</td>
                        <td>
                            <button type="button" onclick="verPerfil(501)">Ver Perfil</button>
                            <button type="button" onclick="asignarTicket(501)">Asignar Ticket</button>
                        </td>
                    </tr>
                    <tr>
                        <td>502</td>
                        <td>María García</td>
                        <td>40</td>
                        <td>38</td>
                        <td>2</td>
                        <td>7.0 horas</td>
                        <td>
                            <button type="button" onclick="verPerfil(502)">Ver Perfil</button>
                            <button type="button" onclick="asignarTicket(502)">Asignar Ticket</button>
                        </td>
                    </tr>
                    </tbody>
            </table>
        </section>

        <section id="asignacion-manual">
            <h3>⚙️ Asignación Rápida de Ticket Pendiente</h3>

            <form method="POST" action="/admin/tickets/asignacion_manual">
                <div>
                    <label for="ticket_pendiente">Ticket ID Pendiente:</label>
                    <input type="number" id="ticket_pendiente" name="ticket_id" placeholder="Ej: 1005" required>
                </div>

                <div>
                    <label for="auxiliar_destino">Asignar a:</label>
                    <select id="auxiliar_destino" name="auxiliar_id" required>
                        <option value="">Seleccionar Auxiliar</option>
                        <option value="501">Juan Pérez</option>
                        <option value="502">María García</option>
                    </select>
                </div>

                <button type="submit">Asignar Ticket</button>
            </form>
        </section>

    </main>

    <script>
        // Funciones Placeholder
        function verPerfil(id) {
            alert('Navegando al perfil del auxiliar ID: ' + id);
        }

        function asignarTicket(id) {
            alert('Activando el modo de asignación de ticket para el auxiliar ID: ' + id);
        }
    </script>

</body>
</html>