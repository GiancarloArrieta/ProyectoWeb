<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Auxiliar de Soporte</title>
</head>
<body>

    <header>
        <h1>Panel de Soporte Técnico - Bienvenido, [Nombre del Auxiliar]</h1>
        <a href="/iniciosesion">
            <button type="button">Cerrar</button>
        </a>
    </header>

    <main>
        
        <section id="dashboard-resumen">
            <h2>Resumen Rápido</h2>
            <div>
                <p>Tickets Asignados Hoy: <strong>[X]</strong></p>
                <p>Tickets En Proceso: <strong>[Y]</strong></p>
                <p>Tickets Pendientes Críticos: <strong>[Z]</strong></p>
            </div>
        </section>

        <section id="tickets-asignados">
            <h2>🎫 Mis Tickets Asignados</h2>
            
            <div>
                <label for="filtro_estatus">Filtrar por Estatus:</label>
                <select id="filtro_estatus">
                    <option value="todos">Todos</option>
                    <option value="pendientes">Pendientes</option>
                    <option value="proceso">En Proceso</option>
                    <option value="finalizado">Finalizado</option>
                </select>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha Creación</th>
                        <th>Usuario que Reporta</th>
                        <th>Departamento</th>
                        <th>Título del Problema</th>
                        <th>Estatus Actual</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </section>

    </main>

</body>
</html>