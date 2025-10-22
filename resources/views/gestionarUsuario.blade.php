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
            
            <form method="POST" action="/admin/usuarios/store">
                
                <div>
                    <div>
                        <label for="nombre_completo">Nombre Completo:</label>
                        <input type="text" id="nombre_completo" name="name" required placeholder="Ej: Juan Pérez">
                    </div>

                    <div>
                        <label for="email">Email (Usuario de Login):</label>
                        <input type="email" id="email" name="email" required placeholder="ejuan@dulcesricos.com">
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
                            <option value="usuario">Usuario (Empleado)</option>
                            <option value="auxiliar">Auxiliar de Soporte</option>
                            <option value="jefe">Jefe de Soporte</option>
                        </select>
                    </div>

                    <div>
                        <label for="departamento">Asignar Departamento:</label>
                        <select id="departamento" name="department_id" required>
                            <option value="">Seleccione un Departamento</option>
                            <option value="1">Ventas</option>
                            <option value="2">Producción</option>
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
                    <tr>
                        <td>1</td>
                        <td>Juan Pérez</td>
                        <td>juan.perez@dulcesricos.com</td>
                        <td>Auxiliar de Soporte</td>
                        <td>Tecnología</td>
                        <td>
                            <button type="button" onclick="editarUsuario(1)">Editar</button>
                            <button type="button" onclick="eliminarUsuario(1)">Eliminar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>María García</td>
                        <td>maria.garcia@dulcesricos.com</td>
                        <td>Usuario</td>
                        <td>Ventas</td>
                        <td>
                            <button type="button" onclick="editarUsuario(2)">Editar</button>
                            <button type="button" onclick="eliminarUsuario(2)">Eliminar</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>[Nombre del Jefe]</td>
                        <td>admin@dulcesricos.com</td>
                        <td>Jefe de Soporte</td>
                        <td>Tecnología</td>
                        <td>
                            <button type="button" onclick="editarUsuario(3)">Editar</button>
                            </td>
                    </tr>
                </tbody>
            </table>
        </section>

    </main>

</body>
</html>