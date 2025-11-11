<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Departamentos - Admin</title>
    <style>
        /* ------------------------------------- */
        /* Variables de Color (Esquema del Usuario: Cálido/Oscuro) */
        /* ------------------------------------- */
        :root {
            /* Colores Base del Usuario */
            --color-dark-primary: #2d3436; /* Negro/Gris Oscuro (Header, Botones, Texto) */
            --color-warm-accent: #fdcb6e;  /* Amarillo-Naranja (Acento principal) */
            --color-soft-bg: #fff5e6;     /* Fondo de tarjetas (similar a #ffeaa7) */

            /* Colores de Estado/Acción */
            --color-info-blue: #0984e3;    /* Azul (Botón Principal) */
            --color-danger-red: #d63031;   /* Rojo (Botón Eliminar/Cerrar Sesión) */
            --color-cancel-gray: #95a5a6; /* Gris (Cancelar) */
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
            /* Fondo solicitado por el usuario */
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
            background-color: var(--color-dark-primary); /* Negro/Gris oscuro */
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
        /* FORMULARIOS (Generales) */
        /* ------------------------------------- */
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        form > div {
            display: flex;
            flex-direction: column;
        }
        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--color-dark-primary);
            font-size: 0.95em;
        }
        form input[type="text"],
        form select,
        form textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s, box-shadow 0.3s;
            background-color: white;
        }
        form input:focus,
        form select:focus,
        form textarea:focus {
            border-color: var(--color-warm-accent);
            box-shadow: 0 0 5px rgba(253, 203, 110, 0.5);
            outline: none;
        }
        form textarea {
            resize: vertical;
        }

        /* Botón de Guardar / Reasignar (Acción Principal) */
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
            align-self: flex-start;
            margin-top: 10px;
        }
        form button[type="submit"]:hover {
            background-color: #0c6ccf;
        }

        /* ------------------------------------- */
        /* TABLA DE DEPARTAMENTOS */
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
        }

        td button:first-of-type { /* Editar Nombre */
            background-color: var(--color-warm-accent);
            color: var(--color-dark-primary);
        }
        td button:first-of-type:hover {
            background-color: #f0a747;
        }

        td button:last-of-type { /* Eliminar */
            background-color: var(--color-danger-red);
            color: white;
            margin-left: 5px;
        }
        td button:last-of-type:hover {
            background-color: #c0392b;
        }

        /* Estilos específicos del formulario de reasignación */
        #asignar-usuarios-a-departamentos form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        #asignar-usuarios-a-departamentos form button {
            grid-column: span 2;
            align-self: center;
        }
        /* Ajuste para el estilo del botón cuando está solo en el grid */
        #asignar-usuarios-a-departamentos form > button {
             grid-column: span 2; 
             margin-top: 0;
             justify-self: start;
        }
    </style>
</head>
<body>

    <header>
        <h1><span>🏢</span> Panel de Administración</h1>
        <nav>
            <a href="/interfazadministrador">← Volver al Dashboard</a>
        </nav>
    </header>

    <main>

        <section id="content-header">
            <h2>🏢 Administrar Departamentos y Asignación</h2>
            <p>Gestione los departamentos operativos y asigne a los empleados a la estructura correcta.</p>
        </section>

        <section id="crear-departamento">
            <h3>➕ Crear Nuevo Departamento</h3>

            <form method="POST" action="/admin/departamentos/store">
                <div>
                    <label for="nombre_departamento">Nombre del Departamento:</label>
                    <input type="text" id="nombre_departamento" name="name" required placeholder="Ej: Logística y Distribución">
                </div>

                <div>
                    <label for="descripcion_departamento">Descripción Breve:</label>
                    <textarea id="descripcion_departamento" name="description" rows="3" placeholder="Función principal del departamento..."></textarea>
                </div>

                <button type="submit">Guardar Departamento</button>
            </form>
        </section>

        <section id="lista-departamentos">
            <h3>📋 Departamentos Existentes</h3>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Departamento</th>
                        <th>Empleados Asignados</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Ventas</td>
                        <td>15</td>
                        <td>
                            <button type="button" onclick="editarDepartamento(1)">Editar Nombre</button>
                            <button type="button" onclick="eliminarDepartamento(1)">Eliminar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Producción</td>
                        <td>32</td>
                        <td>
                            <button type="button" onclick="editarDepartamento(2)">Editar Nombre</button>
                            <button type="button" onclick="eliminarDepartamento(2)">Eliminar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Recursos Humanos</td>
                        <td>8</td>
                        <td>
                            <button type="button" onclick="editarDepartamento(3)">Editar Nombre</button>
                            <button type="button" onclick="eliminarDepartamento(3)">Eliminar</button>
                        </td>
                    </tr>
                    </tbody>
            </table>
        </section>

        <section id="asignar-usuarios-a-departamentos">
            <h3>🔗 Reasignar Empleado a Departamento</h3>

            <form method="POST" action="/admin/departamentos/reasignar">
                <div>
                    <label for="usuario_a_reasignar">Seleccionar Empleado:</label>
                    <select id="usuario_a_reasignar" name="user_id" required>
                        <option value="">Buscar y Seleccionar Usuario</option>
                        <option value="101">Juan Pérez (Ventas)</option>
                        <option value="102">María García (Producción)</option>
                        </select>
                </div>

                <div>
                    <label for="nuevo_departamento">Nuevo Departamento:</label>
                    <select id="nuevo_departamento" name="department_id" required>
                        <option value="">Seleccione Departamento</option>
                        <option value="1">Ventas</option>
                        <option value="2">Producción</option>
                        <option value="3">Recursos Humanos</option>
                    </select>
                </div>

                <button type="submit">Reasignar Empleado</button>
            </form>
        </section>

    </main>

    <script>
        // Funciones Placeholder (deben ser implementadas con la lógica de backend)

        function editarDepartamento(id) {
            alert('Funcionalidad de Edición para el Departamento ID: ' + id + ' pendiente de implementar.');
            // Aquí iría la lógica para cargar el formulario de "Crear Nuevo Departamento" con los datos del departamento seleccionado para edición.
        }

        function eliminarDepartamento(id) {
            if (confirm('¿Está seguro de que desea eliminar el Departamento ID: ' + id + '? Todos los empleados deberán ser reasignados.')) {
                alert('Solicitud de eliminación para Departamento ID: ' + id + ' enviada.');
                // Aquí iría la lógica para enviar la solicitud DELETE al servidor.
            }
        }
    </script>

</body>
</html>