<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Jefe de Soporte - Dulces Ricos</title>
</head>
<body>
    
    <header>
        <h1>Panel de Jefe de Soporte</h1>
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
                
                <a href="#gestionar-departamentos">🏢 Administrar Departamentos</a>
                
                <a href="#gestionar-auxiliares">🛠️ Gestión de Auxiliares</a>
                
                <a href="#reportes-graficas">📈 Reportes y Estadísticas</a>
            </nav>
        </aside>

        <main>
            
            <section id="reportes-graficas">
                <h2>📈 Dashboard de Indicadores</h2>
                
                <div class="charts-section">
                    <div class="chart-placeholder">Gráfica 1: Tickets Pendientes vs. Finalizados</div>
                    <div class="chart-placeholder">Gráfica 2: Tickets por Departamento</div>
                    <div class="chart-placeholder">Gráfica 3: Productividad por Auxiliar</div>
                </div>
            </section>
            
            <section id="todos-los-tickets">
                <h2>🎫 Todos los Tickets del Sistema</h2>
                
                <div class="controls-panel">
                    <label>Filtrar por Estatus:</label>
                    <select id="filtro-estatus">
                        <option value="todos">Todos</option>
                        [cite_start]<option value="pendientes">Pendientes [cite: 57]</option>
                        [cite_start]<option value="proceso">En Proceso [cite: 57]</option>
                        [cite_start]<option value="finalizados">Finalizados [cite: 57]</option>
                    </select>
                    
                    <label style="margin-left: 20px;">Filtrar por Auxiliar:</label>
                    <select id="filtro-auxiliar">
                        [cite_start]<option value="todos">Todos los Auxiliares [cite: 57]</option>
                        </select>

                    <label style="margin-left: 20px;">Filtrar por Departamento:</label>
                    <select id="filtro-departamento">
                        [cite_start]<option value="todos">Todos los Departamentos [cite: 57]</option>
                        </select>

                    <button type="button" class="btn-login btn-report">
                        Generar Reporte PDF 📄
                    </button>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha Creación</th>
                            <th>Usuario</th>
                            <th>Título / Resumen</th>
                            <th>Estatus</th>
                            [cite_start]<th>Auxiliar Asignado [cite: 56]</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </section>
        </main>
    </div>

</body>
</html>