<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Jefe de Soporte - Dulces Ricos</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f9; margin: 0; display: flex; min-height: 100vh; }
        header { background-color: #34495e; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        header h1 { margin: 0; font-size: 1.5em; }
        .logout-btn { padding: 8px 15px; background-color: #e74c3c; color: white; border: none; border-radius: 4px; cursor: pointer; }

        /* Estructura principal */
        .admin-layout { display: flex; width: 100%; }
        
        /* Menú Lateral (ASIDE) - Gestión de Entidades */
        aside { width: 250px; background-color: #2c3e50; color: white; padding: 20px 0; }
        aside h3 { margin: 0 20px 20px 20px; color: #95a5a6; border-bottom: 1px solid #34495e; padding-bottom: 10px; }
        aside nav a { 
            display: block; 
            padding: 12px 20px; 
            text-decoration: none; 
            color: white; 
            transition: background-color 0.3s;
        }
        aside nav a:hover { background-color: #3498db; }

        /* Contenido Principal (MAIN) */
        main { flex-grow: 1; padding: 20px; }
        main h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; margin-bottom: 25px; }
        
        /* Controles y Filtrado */
        .controls-panel { background: white; padding: 15px; border-radius: 6px; margin-bottom: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .controls-panel label { font-weight: bold; margin-right: 10px; }
        .controls-panel select, .controls-panel button { padding: 8px; border-radius: 4px; border: 1px solid #ccc; }
        
        /* Tablas */
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: white; border-radius: 6px; overflow: hidden; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #ecf0f1; color: #2c3e50; font-weight: bold; }
        
        /* Sección de Gráficas */
        .charts-section { display: flex; gap: 20px; margin-bottom: 25px; }
        .chart-placeholder { flex: 1; min-height: 250px; background-color: #eaf2f8; border: 1px dashed #3498db; display: flex; justify-content: center; align-items: center; border-radius: 6px; }

        /* Botones de acción */
        .btn-action { background-color: #3498db; color: white; padding: 6px 10px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-report { background-color: #c0392b; color: white; margin-left: 20px; }
    </style>
</head>
<body>
    
    <header>
        <h1>Panel de Jefe de Soporte</h1>
        <button type="button" onclick="window.history.back()" class="btn-close">
                        Cerrar
            </button>
    </header>

    <div class="admin-layout">
        
        <aside>
            <h3>Gestión del Sistema</h3>
            <nav>
                <a href="#gestionar-usuarios">👥 Crear Usuarios y Roles</a>
                
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
                        <tr>
                            <td>1004</td>
                            <td>2025-10-22</td>
                            <td>Usuario X</td>
                            <td>Fallo de conexión en almacén</td>
                            <td><span style="color: orange;">Pendiente</span></td>
                            <td>-- Sin Asignar --</td>
                            <td>
                                <button type="button" class="btn-action">Asignar Auxiliar</button>
                            </td>
                        </tr>
                        <tr>
                            <td>1003</td>
                            <td>2025-10-10</td>
                            <td>Usuario Z</td>
                            <td>Problema de red</td>
                            <td><span style="color: green;">Finalizado</span></td>
                            <td>María García</td>
                            <td><button type="button" class="btn-action" style="background-color: #34495e;">Ver Detalle</button></td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

</body>
</html>