<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes y Estadísticas - Admin</title>
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
            min-height: 300px;
            background-color: white;
            border: 1px dashed #ccc;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #7f8c8d;
            font-size: 1.2em;
            padding: 20px;
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
                <p>Aquí se visualizaría la gráfica seleccionada.</p>
                <p style="font-size: 0.9em; margin-top: 5px;">(Simulación de gráfico de barras/pastel)</p>
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
                        <option value="produccion">Producción</option>
                        <option value="rh">Recursos Humanos</option>
                    </select>
                </div>

                <button type="submit">Generar y Descargar Reporte PDF 📄</button>
            </form>
        </section>

    </main>
    
    <script>
        function cargarGrafica() {
            const tipo = document.getElementById('tipo_grafica').value;
            const contenedor = document.getElementById('contenedor-grafica');
            
            let descripcion = '';
            switch (tipo) {
                case 'estatus':
                    descripcion = 'Gráfico de pastel mostrando tickets por estado (Finalizado, Pendiente, Proceso).';
                    break;
                case 'departamento':
                    descripcion = 'Gráfico de barras mostrando el volumen de tickets por departamento.';
                    break;
                case 'auxiliar':
                    descripcion = 'Gráfico de barras de la productividad (tickets cerrados) por auxiliar.';
                    break;
                case 'tiempo':
                    descripcion = 'Gráfico de línea del tiempo promedio de respuesta a lo largo del periodo.';
                    break;
                default:
                    descripcion = 'Aquí se visualizaría la gráfica seleccionada.';
            }

            contenedor.innerHTML = `<p style="font-weight: 600; color: var(--color-dark-primary);">Gráfica: ${tipo.charAt(0).toUpperCase() + tipo.slice(1)}</p><p style="font-size: 0.9em; margin-top: 5px;">${descripcion}</p>`;
        }
    </script>

</body>
</html>