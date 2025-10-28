<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Admin</title>
</head>
<body>

    <header>
        <h1>Panel de Administración</h1>
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
                    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
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
                        <label for="password">Contraseña <span id="password-hint">(Dejar en blanco para mantener la actual)</span>:</label>
                        <input type="password" id="password" name="password">
                    </div>

                    <div>
                        <label for="password_confirmation">Confirmar Contraseña:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation">
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
                    <button type="submit" id="submit-button">Guardar Nuevo Usuario</button>
                    <button type="button" id="cancel-button" onclick="cancelarEdicion()" style="display: none; background-color: #95a5a6;">Cancelar</button>
                </div>
            </form>
        </section>

        <section id="lista-usuarios">
            <h3>📋 Lista de Empleados y Administración</h3>
            
            <div>
                <label for="filtro_rol">Filtrar por Rol:</label>
                <select id="filtro_rol">
                    <option value="todos">Todos los Roles</option>
                    <option value="auxiliar">Auxiliares</option>
                    <option value="usuario">Empleados Regulares</option>
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
                <tbody>
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->correo }}</td>
                            <td>{{ $usuario->rol_nombre }}</td>
                            <td>{{ $usuario->departamento_nombre }}</td>
                            <td>
                                <button onclick="editarUsuario({{ $usuario->id }})">Editar</button>
                                <button onclick="eliminarUsuario({{ $usuario->id }})" style="background-color: #e74c3c;">Eliminar</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 20px;">
                                No hay usuarios registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

    </main>

    <script>
        // Función para editar un usuario
        async function editarUsuario(id) {
            try {
                // Obtener los datos del usuario
                const response = await fetch(`/api/usuarios/${id}`);
                if (!response.ok) {
                    throw new Error('Error al obtener los datos del usuario');
                }
                
                const usuario = await response.json();
                
                // Rellenar el formulario con los datos del usuario
                document.getElementById('usuario-id').value = usuario.id;
                document.getElementById('nombre_completo').value = usuario.nombre;
                document.getElementById('email').value = usuario.correo;
                document.getElementById('rol').value = usuario.id_rol;
                document.getElementById('departamento').value = usuario.id_departamento;
                
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
            if (confirm('¿Está seguro de que desea eliminar este usuario?')) {
                // Aquí puedes implementar la lógica de eliminación
                alert('Funcionalidad de eliminación pendiente de implementar');
            }
        }
        
        // Ocultar hint de contraseña por defecto al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const passwordHint = document.getElementById('password-hint');
            if (passwordHint) {
                passwordHint.style.display = 'none';
            }
        });
    </script>

</body>
</html>