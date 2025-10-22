<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ticket - ID [2001]</title>
</head>
<body>

    <header>
        <h1>Panel de Soporte Técnico</h1>
        <a href="/interfazsoporte">
            <button type="button">← Volver a Mis Tickets</button>
        </a>
    </header>

    <main>
        
        <section id="detalle-ticket">
            <h2>🛠️ Gestión del Ticket ID: 2001</h2>
            
            <div>
                <h3>Información del Reporte</h3>
                <p><strong>Reportado por:</strong> Usuario A</p>
                <p><strong>Departamento:</strong> Ventas</p>
                <p><strong>Fecha de Creación:</strong> 2025-10-25</p>
                <p><strong>Estatus Actual:</strong> Pendiente</p>
            </div>

            <div>
                <h3>Descripción Detallada del Usuario</h3>
                <textarea rows="5" readonly>Describo que al intentar acceder al sistema de inventario me sale un mensaje de error 404. Sucede desde las 8 am y ya reinicié la computadora.</textarea>
            </div>
            
            <form method="POST" action="/auxiliar/tickets/update/2001">
                
                <h3>Actualización y Solución</h3>

                <div>
                    <label for="estatus">Cambiar Estatus:</label>
                    <select id="estatus" name="status" required>
                        <option value="pendiente">Pendiente</option>
                        <option value="proceso">En Proceso</option>
                        <option value="finalizado">Finalizado</option>
                    </select>
                </div>
                
                <div>
                    <label for="notas_auxiliar">Notas y Solución Aplicada (Uso Interno):</label>
                    <textarea id="notas_auxiliar" name="notes" rows="4"></textarea>
                </div>

                <div>
                    <label for="fecha_finalizacion">Fecha de Finalización:</label>
                    <input type="date" id="fecha_finalizacion" name="finalization_date">
                </div>
                
                <button type="submit">Guardar Cambios y Actualizar Ticket</button>
            </form>

        </section>

    </main>

</body>
</html>