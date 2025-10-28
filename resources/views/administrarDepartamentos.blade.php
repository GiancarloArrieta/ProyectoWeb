<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Departamentos - Admin</title>
</head>
<body>

    <header>
        <h1>Panel de Administración</h1>
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
                    <textarea id="descripcion_departamento" name="description" rows="3"></textarea>
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
                        //ejemplo de departamentos
                        <td>1</td>
                        <td>Ventas</td>
                        <td>15</td>
                        <td>
                            <button type="button" onclick="editarDepartamento(1)">Editar Nombre</button>
                            <button type="button" onclick="eliminarDepartamento(1)">Eliminar</button>
                        </td>
                    </tr>
                    <tr>
            
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
                    </select>
                </div>

                <button type="submit">Reasignar Empleado</button>
            </form>
        </section>

    </main>

</body>
</html>