<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Admin</title>
    <style>
        /* ------------------------------------- */
        /* Variables de Color (Esquema del Usuario: Cálido/Oscuro) */
        /* ------------------------------------- */
        :root {
            /* Colores Base del Usuario */
            --color-dark-primary: #2d3436; /* Negro/Gris Oscuro (Header, Botones, Texto) */
            --color-warm-accent: #fdcb6e;  /* Amarillo-Naranja (Acento principal) */
            --color-light-bg: #fffaf0;    /* Fondo de contenido muy claro */
            --color-soft-bg: #fff5e6;     /* Fondo de tarjetas (similar a #ffeaa7) */

            /* Colores de Estado/Acción */
            --color-info-blue: #0984e3;    /* Azul (Botón Principal) */
            --color-danger-red: #d63031;   /* Rojo (Botón Eliminar/Cerrar Sesión) */
            --color-success-green: #00b894; /* Verde (Éxito) */
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
            max-width: 1200px;
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
            margin-bottom: 20px;
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
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        header h1 {
            margin: 0;
            font-size: 1.8em;
            font-weight: 700;
        }
        header nav a {
            color: var(--color-warm-accent);
            text-decoration: none;
            font-weight: 600;
            padding: 10px 15px;
            border: 2px solid var(--color-warm-accent);
            border-radius: 8px;
            transition: background-color 0.3s;
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
        /* FORMULARIO */
        /* ------------------------------------- */
        #usuario-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        #usuario-form > div {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        #usuario-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--color-dark-primary);
            font-size: 0.95em;
        }
        #usuario-form input[type="text"],
        #usuario-form input[type="email"],
        #usuario-form input[type="password"],
        #usuario-form select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        #usuario-form input:focus,
        #usuario-form select:focus {
            border-color: var(--color-warm-accent);
            box-shadow: 0 0 5px rgba(253, 203, 110, 0.5);
            outline: none;
        }
        
        #password-hint {
            font-size: 0.8em;
            color: #7f8c8d;
            font-weight: 400;
            margin-left: 5px;
        }
        
        /* Botones del Formulario */
        #usuario-form button {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 700;
            transition: background-color 0.3s, opacity 0.3s;
        }

        #submit-button {
            background-color: var(--color-info-blue); /* Azul para acción principal */
            color: white;
        }
        #submit-button:hover {
            background-color: #0c6ccf;
        }

        #cancel-button {
            background-color: var(--color-cancel-gray); /* Gris para cancelar */
            color: white;
            margin-left: 10px;
        }
        #cancel-button:hover {
            background-color: #7f8c8d;
        }
        
        /* ------------------------------------- */
        /* MENSAJES DE ERROR/ÉXITO (Estilos mejorados) */
        /* ------------------------------------- */
        .error-message {
            background-color: #f8d7da; 
            color: #721c24; 
            padding: 15px; 
            margin-bottom: 20px; 
            border-radius: 8px;
            border: 1px solid #f5c6cb;
        }
        .success-message {
            background-color: #d4edda; 
            color: #155724; 
            padding: 15px; 
            margin-bottom: 20px; 
            border-radius: 8px;
            border: 1px solid #c3e6cb;
        }
        .error-message ul, .success-message ul {
            margin: 0; 
            padding-left: 20px;
        }


        /* ------------------------------------- */
        /* LISTA Y TABLA DE USUARIOS */
        /* ------------------------------------- */
        #lista-usuarios > div {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        #lista-usuarios label {
            font-weight: 600;
            color: var(--color-dark-primary);
        }
        #lista-usuarios select {
            padding: 10px 15px;
            border-radius: 6px;
            border: 1px solid var(--color-warm-accent);
            font-size: 1em;
            min-width: 200px;
            background-color: #fcfcfc;
        }

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

        td button:first-of-type { /* Editar */
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

        /* Responsive Básico */
        @media (max-width: 768px) {
            #usuario-form > div {
                grid-template-columns: 1fr;
            }
            header {
                flex-direction: column;
                gap: 15px;
            }
        }

    </style>
</head>
<body>

    <header>
        <h1><span style="color: var(--color-warm-accent);">🛠️</span> Panel de Administración</h1>
        <nav>
            <a href="/interfazadministrador">Dashboard Principal</a>
        </nav>
    </header>

    <main>

        <section id="content-header">
            <h2>👥 Gestión de Usuarios del Sistema</h2>
            <p>Aquí puede crear nuevos empleados, asignar sus roles (Usuario, Auxiliar, Jefe) y editar su información.</p>
        </section>

        <section id="crear-usuario">
            <h3 id="form-title">➕ Crear Nuevo Empleado</h3>

            <form id="usuario-form" method="POST" action="{{ route('usuarios.store') }}">
                @csrf
                <input type="hidden" id="usuario-id" name="usuario_id" value="">
                <input type="hidden" id="form-method" name="_method" value="POST">

                @if ($errors->any())
                    <div class="error-message">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                <div>
                    <div>
                        <label for="nombre_completo">Nombre Completo:</label>
                        <input type="text" id="nombre_completo" name="name" required placeholder="Ej: Juan Pérez" value="{{ old('name') }}">
                    </div>

                    <div>
                        <label for="email">Email (Usuario de Login):</label>
                        <input type="email" id="email" name="email" required placeholder="ejuan@dulcesricos.com" value="{{ old('email') }}">
                    </div>
                </div>

                <div>
                    <div>
                        <label for="password">Contraseña <span id="password-hint" style="display: none;">(Dejar en blanco para mantener la actual)</span>:</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div>
                        <label for="password_confirmation">Confirmar Contraseña:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <div>
                    <div>
                        <label for="rol">Asignar Rol:</label>
                        <select id="rol" name="role" required>
                            <option value="">Seleccione un Rol</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->id }}" {{ old('role') == $rol->id ? 'selected' : '' }}>
                                    {{ $rol->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="departamento">Asignar Departamento:</label>
                        <select id="departamento" name="department_id" required>
                            <option value="">Seleccione un Departamento</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}" {{ old('department_id') == $departamento->id ? 'selected' : '' }}>
                                    {{ $departamento->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <div>
                        <button type="submit" id="submit-button">Guardar Nuevo Usuario</button>
                        <button type="button" id="cancel-button" onclick="cancelarEdicion()" style="display: none;">Cancelar</button>
                    </div>
                </div>
            </form>
        </section>

        <section id="lista-usuarios">
            <h3>📋 Lista de Empleados y Administración</h3>

            <div>
                <label for="filtro_rol">Filtrar por Rol:</label>
                <select id="filtro_rol" onchange="filtrarUsuarios()">
                    <option value="todos">Todos los Roles</option>
                    <option value="auxiliar">Auxiliares</option>
                    <option value="usuario">Empleados Regulares</option>
                    <option value="administrador">Jefes de Soporte</option>
                </select>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Email / Usuario</th>
                        <th>Rol Asignado</th>
                        <th>Departamento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="usuarios-tbody">
                    @forelse($usuarios as $usuario)
                        <tr data-rol="{{ strtolower($usuario->rol_nombre) }}">
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->correo }}</td>
                            <td>{{ $usuario->rol_nombre }}</td>
                            <td>{{ $usuario->departamento_nombre }}</td>
                            <td>
                                <button onclick="editarUsuario({{ $usuario->id }})">Editar</button>
                                <button onclick="eliminarUsuario({{ $usuario->id }})">Eliminar</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px; color: #7f8c8d;">
                                No hay usuarios registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

    </main>

    <script>
        // Ocultar hint de contraseña por defecto al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const passwordHint = document.getElementById('password-hint');
            if (passwordHint) {
                passwordHint.style.display = 'none';
            }
        });
        
        // Función para editar un usuario
        async function editarUsuario(id) {
            try {
                // Obtener los datos del usuario (Asegúrate de que esta API exista y devuelva los datos)
                const response = await fetch(`/api/usuarios/${id}`);
                if (!response.ok) {
                    throw new Error('Error al obtener los datos del usuario');
                }
                
                const usuario = await response.json();
                
                // Rellenar el formulario con los datos del usuario
                document.getElementById('usuario-id').value = usuario.id;
                document.getElementById('nombre_completo').value = usuario.name || usuario.nombre;
                document.getElementById('email').value = usuario.email || usuario.correo;
                document.getElementById('rol').value = usuario.role_id || usuario.id_rol; // Adaptar a la propiedad correcta
                document.getElementById('departamento').value = usuario.department_id || usuario.id_departamento; // Adaptar a la propiedad correcta
                
                // Limpiar campos de contraseña
                document.getElementById('password').value = '';
                document.getElementById('password_confirmation').value = '';
                
                // Hacer que los campos de contraseña no sean requeridos
                document.getElementById('password').removeAttribute('required');
                document.getElementById('password_confirmation').removeAttribute('required');
                
                // Mostrar hint de contraseña
                document.getElementById('password-hint').style.display = 'inline';
                
                // Cambiar el método del formulario a PUT
                document.getElementById('form-method').value = 'PUT';
                
                // Cambiar la acción del formulario
                document.getElementById('usuario-form').action = `/admin/usuarios/${id}`;
                
                // Cambiar el título del formulario
                document.getElementById('form-title').textContent = '✏️ Editar Empleado';
                
                // Cambiar el texto del botón
                document.getElementById('submit-button').textContent = 'Actualizar Usuario';
                
                // Mostrar botón de cancelar
                document.getElementById('cancel-button').style.display = 'inline-block';
                
                // Hacer scroll al formulario
                document.getElementById('crear-usuario').scrollIntoView({ behavior: 'smooth' });
                
            } catch (error) {
                console.error('Error:', error);
                alert('Error al cargar los datos del usuario');
            }
        }
        
        // Función para cancelar la edición y volver al modo creación
        function cancelarEdicion() {
            // Limpiar el formulario
            document.getElementById('usuario-form').reset();
            document.getElementById('usuario-id').value = '';
            
            // Restaurar el método POST
            document.getElementById('form-method').value = 'POST';
            
            // Restaurar la acción del formulario
            document.getElementById('usuario-form').action = '{{ route("usuarios.store") }}';
            
            // Restaurar el título
            document.getElementById('form-title').textContent = '➕ Crear Nuevo Empleado';
            
            // Restaurar el texto del botón
            document.getElementById('submit-button').textContent = 'Guardar Nuevo Usuario';
            
            // Ocultar botón de cancelar
            document.getElementById('cancel-button').style.display = 'none';
            
            // Hacer que los campos de contraseña sean requeridos nuevamente
            document.getElementById('password').setAttribute('required', 'required');
            document.getElementById('password_confirmation').setAttribute('required', 'required');
            
            // Ocultar hint de contraseña
            document.getElementById('password-hint').style.display = 'none';
        }
        
        // Función para eliminar un usuario
        function eliminarUsuario(id) {
            if (confirm('¿Está seguro de que desea eliminar este usuario? Esta acción es irreversible.')) {
                // Lógica para enviar el formulario de eliminación (simulada)
                alert(`Solicitud de eliminación para el usuario ID: ${id} enviada. (Funcionalidad real requiere implementación de formulario DELETE)`);
                // En un entorno real, se crearía un formulario y se enviaría vía POST con el método _DELETE
                // const form = document.createElement('form');
                // form.action = `/admin/usuarios/${id}`;
                // form.method = 'POST';
                // form.innerHTML = '@csrf<input type="hidden" name="_method" value="DELETE">';
                // document.body.appendChild(form);
                // form.submit();
            }
        }
        
        // Función para filtrar usuarios por rol (basado en el atributo data-rol)
        function filtrarUsuarios() {
            const filtro = document.getElementById('filtro_rol').value;
            const filas = document.getElementById('usuarios-tbody').getElementsByTagName('tr');
            
            for (let i = 0; i < filas.length; i++) {
                const fila = filas[i];
                // Ignorar la fila 'No hay usuarios'
                if (fila.hasAttribute('data-rol')) { 
                    const rol = fila.getAttribute('data-rol').toLowerCase();
                    let mostrar = false;
                    
                    if (filtro === 'todos') {
                        mostrar = true;
                    } else if (filtro === 'administrador') {
                        // Mostrar usuarios con rol "Administrador" o "administrador"
                        mostrar = rol === 'administrador';
                    } else {
                        mostrar = rol.includes(filtro);
                    }
                    
                    fila.style.display = mostrar ? '' : 'none';
                }
            }
        }

    </script>

</body>
</html>