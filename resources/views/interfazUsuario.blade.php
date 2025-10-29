<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Empleado</title>
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
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-close">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </header>

    <main style="display: flex; gap: 30px; margin-top: 20px;">
        
        <section id="user-profile" style="width: 30%; border: 1px solid #ccc; padding: 20px; background: white; border-radius: 8px;">
            <h2>Mi Perfil</h2>
            
            <div style="text-align: center; margin-bottom: 20px;">
                @php
                    // Determina la ruta de la foto guardada por el usuario
                    $profilePhotoPath = $usuario->profile_photo 
                        ? asset('storage/' . $usuario->profile_photo) 
                        : asset('images/default-avatar.png'); 
                @endphp
                <img 
                    src="{{ $profilePhotoPath }}" 
                    alt="Foto de perfil" 
                    style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #3498db;"
                >
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

        <section id="user-tickets" style="width: 70%; border: 1px solid #ccc; padding: 20px; background: white; border-radius: 8px;">
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
                        <th style="padding: 10px;">ID</th>
                        <th style="padding: 10px;">Fecha Creación</th>
                        <th style="padding: 10px;">Título / Problema</th>
                        <th style="padding: 10px;">Auxiliar Asignado</th>
                        <th style="padding: 10px;">Estatus</th>
                        <th style="padding: 10px;">Acción</th>
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
        // Funciones auxiliares para manejo de tickets
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
                        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 20px; color: #7f8c8d;">No tienes tickets registrados</td></tr>';
                        return;
                    }

                    tickets.forEach(ticket => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td style="padding: 10px;">${ticket.id}</td>
                            <td style="padding: 10px;">${new Date(ticket.created_at).toLocaleDateString()}</td>
                            <td style="padding: 10px;">${ticket.título}</td>
                            <td style="padding: 10px;">${ticket.departamento_asignado ? ticket.departamento_asignado.nombre : 'Sin asignar'}</td>
                            <td style="padding: 10px;"><span style="padding: 4px 8px; border-radius: 4px; background-color: ${getStatusColor(ticket.status)}; color: white; font-size: 0.9em;">${ticket.status}</span></td>
                            <td style="padding: 10px;">${getActionButton(ticket.status, ticket.id)}</td>
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
                case 'Completado': return '#2ecc71';
                case 'Cerrado': return '#95a5a6';
                default: return '#95a5a6';
            }
        }

        function getActionButton(status, ticketId) {
            if (status === 'Pendiente') {
                return `<button onclick="showCustomConfirm(${ticketId})" style="background-color: #e74c3c; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 0.9em;">Eliminar</button>`;
            }
            return '<span style="color: #95a5a6; font-size: 0.9em;">No disponible</span>';
        }
        
        // Función para mostrar confirmación personalizada (reemplaza alert/confirm)
        function showCustomConfirm(ticketId) {
            const modal = document.createElement('div');
            modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: flex; justify-content: center; align-items: center;';
            modal.innerHTML = `
                <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 350px;">
                    <h4 style="margin-top: 0; color: #e74c3c;">Confirmación</h4>
                    <p>¿Estás seguro de que quieres eliminar este ticket?</p>
                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <button id="cancel-btn" style="padding: 8px 15px; border: 1px solid #ccc; background: #f4f4f4; border-radius: 4px; cursor: pointer;">Cancelar</button>
                        <button id="delete-btn" style="padding: 8px 15px; border: none; background: #e74c3c; color: white; border-radius: 4px; cursor: pointer;">Eliminar</button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);

            document.getElementById('cancel-btn').onclick = () => document.body.removeChild(modal);
            document.getElementById('delete-btn').onclick = () => {
                document.body.removeChild(modal);
                eliminarTicket(ticketId);
            };
        }

        // Modificamos eliminarTicket para usar el nuevo modal
        function eliminarTicket(ticketId) {
            fetch(`/api/tickets/${ticketId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    cargarTickets(); // Recargar la tabla
                } else {
                    console.error('Error al eliminar el ticket:', data);
                    // Puedes añadir un mensaje de error personalizado aquí si es necesario
                }
            })
            .catch(error => {
                console.error('Error de red al eliminar el ticket:', error);
                // Muestra el error en consola para depuración
            });
        }
    </script>
</body>
</html>
