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
            <h3>➕ Crear Nuevo Empleado</h3>
            
            <form method="POST" action="{{ route('usuarios.store') }}">
                @csrf
                
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
                        <label for="password">Contraseña Inicial:</label>
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

                <button type="submit">Guardar Nuevo Usuario</button>
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

</body>
</html>