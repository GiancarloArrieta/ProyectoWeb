<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Empleado - Dulces Ricos</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f9; padding: 20px; }
        header { border-bottom: 2px solid #ddd; padding-bottom: 15px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        header h1 { color: #34495e; margin: 0; }
        header button { padding: 8px 15px; background-color: #e74c3c; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a button { border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; }
        #user-profile a button { background-color: #3498db; color: white; margin-top: 15px; }
        #user-tickets a button { background-color: #2ecc71; color: white; }
    </style>
</head>
<body>
    <header>
        <h1>Bienvenido(a), {{ $usuario->nombre ?? 'Usuario' }}</h1>
        <div>
            <a href="{{ route('usuario.edit') }}" style="margin-right: 10px; text-decoration: none;">
                <button type="button" style="background-color: #3498db; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer;">
                    Editar Perfil
                </button>
            </a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-close">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </header>

    <main style="display: flex; gap: 30px; margin-top: 20px;">
        
        <section id="user-profile" style="width: 30%; border: 1px solid #ccc; padding: 20px; background: white;">
            <h2>Mi Perfil</h2>
            
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="/ruta/a/foto_de_perfil.png" alt="Foto de perfil" style="width: 100px; height: 100px; border-radius: 50%;">
            </div>

            <div>
                <p><strong>Nombre:</strong> {{ $usuario->nombre ?? 'No disponible' }}</p>
                <p><strong>Email:</strong> {{ $usuario->correo ?? 'No disponible' }}</p>
                
                <p style="border-top: 1px solid #ddd; padding-top: 10px;">
                    <strong>Departamento:</strong> {{ $usuario->departamento_nombre ?? 'No asignado' }}
                </p>
                <p>
                    <strong>Puesto:</strong> {{ $usuario->rol_nombre ?? 'No asignado' }}
                </p>
                
                <a href="{{ route('usuario.edit') }}" style="text-decoration: none;">
                    <button type="button">
                        Editar Datos Personales
                    </button>
                </a>
            </div>
        </section>

        <section id="user-tickets" style="width: 70%; border: 1px solid #ccc; padding: 20px; background: white;">
            <h2>Gestión de Tickets</h2>
            
            <a href="{{ route('ticket.create') }}" style="text-decoration: none;">
                <button type="button">
                    + Levantar Nuevo Ticket
                </button>
            </a>
            
            <h3 style="margin-top: 20px;">Lista de Mis Tickets</h3>

            <table border="1" style="width: 100%; margin-top: 10px; text-align: left; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #ecf0f1;">
                        <th>ID</th>
                        <th>Fecha Creación</th>
                        <th>Título / Problema</th>
                        <th>Auxiliar Asignado</th>
                        <th>Estatus</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="tickets-table-body">
                    <!-- Los tickets se cargarán aquí via JavaScript -->
                </tbody>
            </table>
        </section>
    </main>
    
    <div id="modal-nuevo-ticket" style="display:none;">
         </div>

    <script>
        // Cargar tickets del usuario al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarTickets();
        });

        function cargarTickets() {
            fetch('{{ route("ticket.mis-tickets") }}')
                .then(response => response.json())
                .then(tickets => {
                    const tbody = document.getElementById('tickets-table-body');
                    tbody.innerHTML = '';

                    if (tickets.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 20px;">No tienes tickets registrados</td></tr>';
                        return;
                    }

                    tickets.forEach(ticket => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${ticket.id}</td>
                            <td>${new Date(ticket.created_at).toLocaleDateString()}</td>
                            <td>${ticket.título}</td>
                            <td>${ticket.departamento_asignado ? ticket.departamento_asignado.nombre : 'Sin asignar'}</td>
                            <td><span style="padding: 4px 8px; border-radius: 4px; background-color: ${getStatusColor(ticket.status)}; color: white;">${ticket.status}</span></td>
                            <td><a href="/detalleticket/${ticket.id}" style="text-decoration: none; color: #3498db;">Ver Detalles</a></td>
                        `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error al cargar tickets:', error);
                    document.getElementById('tickets-table-body').innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 20px; color: red;">Error al cargar tickets</td></tr>';
                });
        }

        function getStatusColor(status) {
            switch(status) {
                case 'Pendiente': return '#f39c12';
                case 'En Proceso': return '#3498db';
                case 'Resuelto': return '#2ecc71';
                case 'Cerrado': return '#95a5a6';
                default: return '#95a5a6';
            }
        }
    </script>
</body>
</html>