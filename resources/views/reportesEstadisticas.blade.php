<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes y Estadísticas - Admin</title>
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
            <h2>📈 Reportes y Estadísticas del Sistema</h2>
            <p>Visualice los indicadores clave y genere informes de rendimiento.</p>
        </section>

        <section id="seccion-graficas">
            <h3>Gráficas de Rendimiento</h3>
            
            <div>
                <label for="tipo_grafica">Seleccionar Gráfica:</label>
                <select id="tipo_grafica">
                    <option value="estatus">Tickets por Estatus</option>
                    <option value="departamento">Tickets por Departamento</option>
                    <option value="auxiliar">Productividad por Auxiliar</option>
                    <option value="tiempo">Tiempo promedio de respuesta</option>
                </select>
                
                <button type="button" onclick="cargarGrafica()">Ver Gráfica</button>
            </div>

            <div id="contenedor-grafica">
                <p>Aquí se visualizaría la gráfica seleccionada.</p>
                <p>(Simulación de gráfico de barras/pastel)</p>
            </div>
        </section>

        <section id="seccion-reportes">
            <h3>Generación de Reportes PDF</h3>
            
            <form method="GET" action="/admin/reportes/generar">
                
                <div>
                    <label for="reporte_fecha_inicio">Fecha de Inicio:</label>
                    <input type="date" id="reporte_fecha_inicio" name="start_date" required>
                </div>
                
                <div>
                    <label for="reporte_fecha_fin">Fecha de Fin:</label>
                    <input type="date" id="reporte_fecha_fin" name="end_date" required>
                </div>
                
                <div>
                    <label for="reporte_estatus">Filtrar por Estatus:</label>
                    <select id="reporte_estatus" name="status">
                        <option value="todos">Todos</option>
                        <option value="finalizado">Finalizados (Atendidos)</option>
                        <option value="cancelado">Cancelados/Rechazados</option>
                        <option value="pendiente">Pendientes</option>
                        <option value="proceso">En Proceso</option>
                    </select>
                </div>
                
                <div>
                    <label for="reporte_departamento">Filtrar por Departamento:</label>
                    <select id="reporte_departamento" name="department">
                        <option value="todos">Todos los Departamentos</option>
                        <option value="ventas">Ventas</option>
                    </select>
                </div>

                <button type="submit">Generar y Descargar Reporte PDF 📄</button>
            </form>
        </section>

    </main>

</body>
</html>