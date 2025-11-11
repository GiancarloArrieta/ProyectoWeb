<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

            @if ($errors->any())
                <div style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #f5c6cb;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('departamentos.store') }}" id="form-departamento">
                @csrf
                <input type="hidden" id="departamento-id" name="departamento_id" value="">
                <input type="hidden" id="form-method" name="_method" value="POST">

                <div>
                    <label for="nombre_departamento">Nombre del Departamento:</label>
                    <input type="text" id="nombre_departamento" name="name" required placeholder="Ej: Logística y Distribución" value="{{ old('name') }}">
                </div>

                <div>
                    <label for="descripcion_departamento">Descripción Breve:</label>
                    <textarea id="descripcion_departamento" name="description" rows="3" placeholder="Función principal del departamento...">{{ old('description') }}</textarea>
                </div>

                <button type="submit" id="submit-button">Guardar Departamento</button>
                <button type="button" id="cancel-button" onclick="cancelarEdicion()" style="display: none; background-color: var(--color-cancel-gray); color: white; padding: 12px 25px; border: none; border-radius: 8px; cursor: pointer; font-size: 1em; font-weight: 700; margin-left: 10px;">Cancelar</button>
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
                <tbody id="departamentos-tbody">
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px; color: #7f8c8d;">
                            Cargando departamentos...
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section id="asignar-usuarios-a-departamentos">
            <h3>🔗 Reasignar Empleado a Departamento</h3>

            <form method="POST" action="{{ route('departamentos.reasignar') }}" id="form-reasignar">
                @csrf
                <div>
                    <label for="usuario_a_reasignar">Seleccionar Empleado:</label>
                    <select id="usuario_a_reasignar" name="user_id" required>
                        <option value="">Cargando usuarios...</option>
                    </select>
                </div>

                <div>
                    <label for="nuevo_departamento">Nuevo Departamento:</label>
                    <select id="nuevo_departamento" name="department_id" required>
                        <option value="">Cargando departamentos...</option>
                    </select>
                </div>

                <button type="submit">Reasignar Empleado</button>
            </form>
        </section>

    </main>

    <script>
        // Cargar datos al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            cargarDepartamentos();
            cargarUsuarios();
            cargarDepartamentosSelect();
            // Actualizar cada 10 segundos
            setInterval(cargarDepartamentos, 10000);
            setInterval(cargarUsuarios, 10000);
            setInterval(cargarDepartamentosSelect, 10000);
        });

        // Cargar departamentos en la tabla
        async function cargarDepartamentos() {
            try {
                const response = await fetch('/api/departamentos');
                if (!response.ok) throw new Error('Error al cargar departamentos');
                
                const departamentos = await response.json();
                const tbody = document.getElementById('departamentos-tbody');
                
                if (departamentos.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 20px; color: #7f8c8d;">
                                No hay departamentos registrados
                            </td>
                        </tr>
                    `;
                    return;
                }

                tbody.innerHTML = departamentos.map(dept => `
                    <tr>
                        <td>${dept.id}</td>
                        <td>${dept.nombre}</td>
                        <td>${dept.usuarios_count || 0}</td>
                        <td>
                            <button type="button" onclick="editarDepartamento(${dept.id}, '${dept.nombre.replace(/'/g, "\\'")}')">Editar Nombre</button>
                            <button type="button" onclick="eliminarDepartamento(${dept.id})">Eliminar</button>
                        </td>
                    </tr>
                `).join('');
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('departamentos-tbody').innerHTML = `
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px; color: var(--color-danger-red);">
                            Error al cargar los departamentos
                        </td>
                    </tr>
                `;
            }
        }

        // Cargar usuarios en el select
        async function cargarUsuarios() {
            try {
                const response = await fetch('/api/usuarios/todos');
                if (!response.ok) throw new Error('Error al cargar usuarios');
                
                const usuarios = await response.json();
                const select = document.getElementById('usuario_a_reasignar');
                
                select.innerHTML = '<option value="">Seleccionar Usuario</option>' + 
                    usuarios.map(usuario => {
                        const departamento = usuario.departamento ? usuario.departamento.nombre : 'Sin departamento';
                        return `<option value="${usuario.id}">${usuario.nombre} (${departamento})</option>`;
                    }).join('');
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Cargar departamentos en el select
        async function cargarDepartamentosSelect() {
            try {
                const response = await fetch('/api/departamentos');
                if (!response.ok) throw new Error('Error al cargar departamentos');
                
                const departamentos = await response.json();
                const select = document.getElementById('nuevo_departamento');
                
                select.innerHTML = '<option value="">Seleccione Departamento</option>' + 
                    departamentos.map(dept => `<option value="${dept.id}">${dept.nombre}</option>`).join('');
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Editar departamento
        function editarDepartamento(id, nombre) {
            document.getElementById('departamento-id').value = id;
            document.getElementById('nombre_departamento').value = nombre;
            document.getElementById('form-method').value = 'PUT';
            document.getElementById('form-departamento').action = `/api/departamentos/${id}`;
            document.getElementById('submit-button').textContent = 'Actualizar Departamento';
            document.getElementById('cancel-button').style.display = 'inline-block';
            
            // Scroll al formulario
            document.getElementById('crear-departamento').scrollIntoView({ behavior: 'smooth' });
        }

        // Cancelar edición
        function cancelarEdicion() {
            document.getElementById('form-departamento').reset();
            document.getElementById('departamento-id').value = '';
            document.getElementById('form-method').value = 'POST';
            document.getElementById('form-departamento').action = '{{ route("departamentos.store") }}';
            document.getElementById('submit-button').textContent = 'Guardar Departamento';
            document.getElementById('cancel-button').style.display = 'none';
        }

        // Eliminar departamento
        async function eliminarDepartamento(id) {
            if (!confirm('¿Está seguro de que desea eliminar este departamento? Todos los empleados deberán ser reasignados.')) {
                return;
            }

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await fetch(`/api/departamentos/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                    },
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    alert('Departamento eliminado exitosamente');
                    cargarDepartamentos();
                    cargarDepartamentosSelect();
                } else {
                    alert('Error: ' + (data.message || 'Error desconocido al eliminar'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al eliminar el departamento');
            }
        }

        // Manejar envío del formulario de departamento
        document.getElementById('form-departamento').addEventListener('submit', async function(e) {
            const method = document.getElementById('form-method').value;
            const id = document.getElementById('departamento-id').value;
            
            if (method === 'PUT') {
                e.preventDefault();
                
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const nombre = document.getElementById('nombre_departamento').value;
                    
                    const response = await fetch(`/api/departamentos/${id}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ nombre: nombre }),
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        alert('Departamento actualizado exitosamente');
                        cancelarEdicion();
                        cargarDepartamentos();
                        cargarDepartamentosSelect();
                    } else {
                        alert('Error: ' + (data.message || 'Error desconocido al actualizar'));
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error al actualizar el departamento');
                }
            } else {
                // POST - dejar que el formulario se envíe normalmente y la página se recargue
                // La página se recargará con el mensaje de éxito
            }
        });
    </script>

</body>
</html>