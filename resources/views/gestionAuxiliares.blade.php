<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Auxiliares - Admin</title>
</head>
<body>

    <header>
        <h1>Panel de Administración</h1>
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

</body>
</html>