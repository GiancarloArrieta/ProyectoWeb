<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reportes y Estadísticas - Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            --color-success-green: #00b894; /* Verde (Gráficas / Éxito) */
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
            max-width: 1000px;
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
            max-width: 1000px;
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
        /* GRÁFICAS */
        /* ------------------------------------- */
        #seccion-graficas > div:first-of-type {
            display: flex;
            align-items: flex-end;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        #seccion-graficas label {
             font-weight: 600;
             margin-bottom: 5px;
        }
        
        #seccion-graficas select {
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1em;
            min-width: 200px;
            background-color: white;
        }

        #seccion-graficas button {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 700;
            transition: background-color 0.3s;
            background-color: var(--color-success-green); /* Verde para ver/procesar info */
            color: white;
        }
        #seccion-graficas button:hover {
            background-color: #008f75;
        }

        #contenedor-grafica {
            min-height: 400px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            position: relative;
        }
        
        #contenedor-grafica canvas {
            max-height: 350px;
        }

        /* ------------------------------------- */
        /* GENERACIÓN DE REPORTES */
        /* ------------------------------------- */
        #seccion-reportes form {
            /* Grid de 2 columnas para campos de filtro */
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        #seccion-reportes form > div {
             display: flex;
             flex-direction: column;
        }
        
        #seccion-reportes label {
             font-weight: 600;
             margin-bottom: 5px;
        }

        #seccion-reportes input[type="date"],
        #seccion-reportes select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1em;
            background-color: white;
        }

        #seccion-reportes button[type="submit"] {
            /* Ocupa las dos columnas */
            grid-column: span 2;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: 700;
            transition: background-color 0.3s;
            background-color: var(--color-info-blue); /* Azul para acción principal */
            color: white;
            margin-top: 10px;
        }
        #seccion-reportes button[type="submit"]:hover {
            background-color: #0c6ccf;
        }
        
        /* Responsive Básico */
        @media (max-width: 768px) {
            #seccion-graficas > div:first-of-type {
                flex-direction: column;
                align-items: stretch;
            }
            #seccion-graficas select, #seccion-graficas button {
                width: 100%;
            }
            #seccion-reportes form {
                grid-template-columns: 1fr;
            }
            #seccion-reportes button[type="submit"] {
                grid-column: span 1;
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
        <h1><span>📈</span> Panel de Administración</h1>
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
                <div>
                    <label for="tipo_grafica">Seleccionar Gráfica:</label>
                    <select id="tipo_grafica">
                        <option value="estatus">Tickets por Estatus</option>
                        <option value="departamento">Tickets por Departamento</option>
                        <option value="auxiliar">Productividad por Auxiliar</option>
                        <option value="tiempo">Tiempo promedio de respuesta</option>
                    </select>
                </div>
                <button type="button" onclick="cargarGrafica()">Ver Gráfica</button>
            </div>

            <div id="contenedor-grafica">
                <canvas id="grafica-chart"></canvas>
            </div>
        </section>

        <section id="seccion-reportes">
            <h3>Generación de Reportes PDF</h3>

            <form id="form-generar-reporte" method="POST" action="/admin/reportes/generar-pdf">
                @csrf

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
                    </select>
                </div>

                <button type="submit">Generar y Descargar Reporte PDF 📄</button>
            </form>
            
            <div id="mensaje-reporte" style="margin-top: 15px; display: none;"></div>
        </section>

    </main>
    
    <script>
        let chartInstance = null;

        // Cargar gráfica al cambiar el tipo
        async function cargarGrafica() {
            const tipo = document.getElementById('tipo_grafica').value;
            
            try {
                const response = await fetch(`/api/reportes/grafica?tipo=${tipo}`);
                if (!response.ok) throw new Error('Error al cargar datos de la gráfica');
                
                const data = await response.json();
                const ctx = document.getElementById('grafica-chart').getContext('2d');
                
                // Destruir gráfica anterior si existe
                if (chartInstance) {
                    chartInstance.destroy();
                }
                
                // Crear nueva gráfica según el tipo
                switch (tipo) {
                    case 'estatus':
                        chartInstance = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: data.labels || [],
                                datasets: [{
                                    data: data.values || [],
                                    backgroundColor: ['#e67e22', '#0984e3', '#f39c12', '#00b894'],
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Tickets por Estatus'
                                    }
                                }
                            }
                        });
                        break;
                    case 'departamento':
                        chartInstance = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.labels || [],
                                datasets: [{
                                    label: 'Tickets',
                                    data: data.values || [],
                                    backgroundColor: '#0984e3',
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Tickets por Departamento'
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                        break;
                    case 'auxiliar':
                        chartInstance = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data.labels || [],
                                datasets: [{
                                    label: 'Tickets Finalizados',
                                    data: data.values || [],
                                    backgroundColor: '#00b894',
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Productividad por Auxiliar'
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                        break;
                    case 'tiempo':
                        chartInstance = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data.labels || [],
                                datasets: [{
                                    label: 'Tiempo Promedio (horas)',
                                    data: data.values || [],
                                    borderColor: '#0984e3',
                                    backgroundColor: 'rgba(9, 132, 227, 0.1)',
                                    fill: true,
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Tiempo Promedio de Respuesta'
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                        break;
                }
            } catch (error) {
                console.error('Error:', error);
                const contenedor = document.getElementById('contenedor-grafica');
                contenedor.innerHTML = '<p style="color: var(--color-danger-red);">Error al cargar la gráfica</p>';
            }
        }

        // Cargar departamentos en el select
        async function cargarDepartamentos() {
            try {
                const response = await fetch('/api/departamentos');
                if (!response.ok) throw new Error('Error al cargar departamentos');
                
                const departamentos = await response.json();
                const select = document.getElementById('reporte_departamento');
                
                departamentos.forEach(dept => {
                    const option = document.createElement('option');
                    option.value = dept.id;
                    option.textContent = dept.nombre;
                    select.appendChild(option);
                });
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Cargar gráfica al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            cargarGrafica();
            cargarDepartamentos();
        });

        // Manejar envío del formulario de reporte PDF
        document.getElementById('form-generar-reporte').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const mensajeDiv = document.getElementById('mensaje-reporte');
            
            try {
                mensajeDiv.style.display = 'block';
                mensajeDiv.style.backgroundColor = '#d1ecf1';
                mensajeDiv.style.color = '#0c5460';
                mensajeDiv.style.padding = '15px';
                mensajeDiv.style.borderRadius = '8px';
                mensajeDiv.textContent = 'Generando reporte PDF...';
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                const response = await fetch('/admin/reportes/generar-pdf', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: formData,
                });

                if (response.ok) {
                    const contentType = response.headers.get('content-type');
                    
                    if (contentType && contentType.includes('application/pdf')) {
                        // Es un PDF
                        const blob = await response.blob();
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `reporte-tickets-${new Date().toISOString().split('T')[0]}.pdf`;
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        document.body.removeChild(a);
                    } else if (contentType && contentType.includes('text/html')) {
                        // Es HTML (para imprimir como PDF)
                        const blob = await response.blob();
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `reporte-tickets-${new Date().toISOString().split('T')[0]}.html`;
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        document.body.removeChild(a);
                        
                        mensajeDiv.innerHTML = 'Reporte HTML generado. Puede abrirlo e imprimirlo como PDF desde su navegador (Ctrl+P → Guardar como PDF).';
                    } else {
                        // JSON response (fallback)
                        const data = await response.json();
                        if (data.success) {
                            mensajeDiv.innerHTML = `Reporte generado con ${data.total} tickets. Los datos están disponibles en la consola.`;
                            console.log('Datos del reporte:', data);
                        }
                    }
                    
                    mensajeDiv.style.backgroundColor = '#d4edda';
                    mensajeDiv.style.color = '#155724';
                    if (!mensajeDiv.innerHTML.includes('Reporte')) {
                        mensajeDiv.textContent = 'Reporte generado y descargado exitosamente';
                    }
                } else {
                    throw new Error('Error al generar el reporte');
                }
            } catch (error) {
                console.error('Error:', error);
                mensajeDiv.style.backgroundColor = '#f8d7da';
                mensajeDiv.style.color = '#721c24';
                mensajeDiv.textContent = 'Error al generar el reporte PDF';
            }
        });
    </script>

</body>
</html>