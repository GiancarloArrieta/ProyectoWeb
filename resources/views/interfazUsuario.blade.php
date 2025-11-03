<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>Panel de Empleado</title>
    <style>
        
        :root {
            --color-primary-blue: #0984e3;
            --color-accent-warm: #fdcb6e;
            --color-accent-light: #ffeaa7;
            --color-dark-text: #2d3436;
            --color-danger-red: #e74c3c;
            --color-success-green: #2ecc71;
        }

        /* BASE Y LAYOUT */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, var(--color-accent-light) 0%, var(--color-accent-warm) 100%);
            min-height: 100vh;
        }

        /* ENCABEZADO SUPERIOR */
        header { 
            background-color: white;
            border-bottom: 1px solid #dfe6e9; /* Borde más suave */
            padding: 20px 50px; /* Más espacioso */
            margin-bottom: 35px; /* Más separación del contenido */
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            /* Sombra ligera */
            box-shadow: 0 4px 10px rgba(0,0,0,0.05); 
        }
        header h1 { 
            color: var(--color-dark-text); 
            margin: 0; 
            font-size: 1.8em;
            font-weight: 700;
        }

        /* ESTILO GENERAL DE BOTONES */
        .btn { 
            border: none; 
            padding: 12px 22px; /* Más grande */
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: 600;
            transition: background-color 0.3s, box-shadow 0.3s, transform 0.1s;
        }
        .btn:active {
            transform: scale(0.99);
        }

        /* BOTONES DE ACCIÓN PRINCIPAL */
        .btn-primary { 
            background-color: var(--color-primary-blue);
            color: white;
            box-shadow: 0 4px 10px rgba(9, 132, 227, 0.3);
        }
        .btn-primary:hover {
            background-color: #74b9ff; 
        }

        /* BOTONES DE PELIGRO/CERRAR */
        .btn-danger {
            background-color: var(--color-danger-red); 
            color: white;
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3);
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }


        /* CONTENIDO PRINCIPAL */
        main { 
            display: flex; 
            gap: 30px; 
            margin: 0 50px; 
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        /* TARJETAS DE SECCIÓN */
        #user-profile, #user-tickets {
            padding: 30px; 
            background: white; 
            border-radius: 15px; /* Bordes más redondeados */
            box-shadow: 0 10px 30px rgba(0,0,0,0.15); 
        }
        #user-profile {
            width: 30%; 
            min-width: 300px;
        }
        #user-tickets {
            width: 70%; 
            flex-grow: 1;
        }

        /* Títulos de sección h2 */
        h2 { 
            color: var(--color-dark-text); 
            font-weight: 700;
            font-size: 1.5em;
            /* Línea de acento con el color cálido del proyecto */
            border-bottom: 3px solid var(--color-accent-warm); 
            padding-bottom: 10px; 
            margin-bottom: 25px;
        }
        
        /* Título de la lista de tickets */
        #user-tickets h3 {
            color: var(--color-dark-text);
            margin-top: 30px;
        }


        /* PERFIL */
        #user-profile img {
            /* Borde con el color cálido para acentuar el esquema */
            border: 4px solid var(--color-accent-warm); 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        #user-profile p {
            margin: 10px 0;
            color: #555;
            font-size: 15px;
        }
        #user-profile strong {
            color: var(--color-dark-text);
            display: inline-block;
            min-width: 100px; 
            font-weight: 600;
        }
        #user-profile a .btn {
            margin-top: 25px;
        }

        /* TABLA DE TICKETS */
        #user-tickets table {
            width: 100%;
            border-collapse: separate; 
            border-spacing: 0;
            margin-top: 20px; 
            text-align: left; 
            font-size: 0.95em;
            overflow: hidden; /* Para que los border-radius funcionen en thead */
            border-radius: 8px;
        }
        #user-tickets th, #user-tickets td {
            padding: 15px 18px; /* Más padding para una tabla más legible */
            border-bottom: 1px solid #f4f4f4; 
        }
        #user-tickets thead tr {
            background-color: #f4f4f4; /* Fondo gris muy claro */
            color: var(--color-dark-text);
        }
        #user-tickets tbody tr:hover {
            background-color: #fffaf0; /* Hover con un toque del color cálido */
        }

        /* Estilo para los botones dentro de la tabla */
        #user-tickets td button {
            padding: 8px 12px;
            font-size: 0.85em;
            font-weight: 600;
        }
        
        /* ESTILOS DEL MODAL DE CONFIRMACIÓN (Ajustados al esquema) */
        .custom-modal-content {
            background: white; 
            padding: 30px; 
            border-radius: 15px; /* Más redondeado */
            box-shadow: 0 10px 30px rgba(0,0,0,0.3); 
            max-width: 400px;
        }
        .custom-modal-content h4 {
            border-bottom: 2px solid var(--color-danger-red); /* Borde rojo */
            color: var(--color-danger-red);
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <header>
        <h1><span class="logo-icon">🎟️</span> Bienvenido(a), {{ $usuario->nombre ?? 'Usuario' }}</h1> 
        <div>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </header>

    <main>
        
        <section id="user-profile">
            <h2>Mi Perfil</h2>
            
            <div style="text-align: center; margin-bottom: 30px;">
                @php
                    // Lógica Blade para mostrar la foto de perfil
                    $profilePhotoPath = $usuario->profile_photo 
                        ? asset('storage/' . $usuario->profile_photo) 
                        : asset('images/default-avatar.png'); 
                @endphp
                <img 
                    src="{{ $profilePhotoPath }}" 
                    alt="Foto de perfil" 
                    style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;"
                >
            </div>

            <div>
                <p><strong>Nombre:</strong> {{ $usuario->nombre ?? 'No disponible' }}</p>
                <p><strong>Email:</strong> {{ $usuario->correo ?? 'No disponible' }}</p>
                
                <p style="border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px;">
                    <strong>Departamento:</strong> {{ $usuario->departamento_nombre ?? 'No asignado' }}
                </p>
                <p>
                    <strong>Puesto:</strong> {{ $usuario->rol_nombre ?? 'No asignado' }}
                </p>
                
                <a href="{{ route('usuario.edit') }}" style="text-decoration: none;">
                    <button type="button" class="btn btn-primary" style="width: 100%;">
                        Editar Datos Personales
                    </button>
                </a>
            </div>
        </section>

        <section id="user-tickets">
            <h2>Gestión de Tickets</h2>
            
            <a href="{{ route('ticket.create') }}" style="text-decoration: none;">
                <button type="button" class="btn btn-primary">
                    + Levantar Nuevo Ticket
                </button>
            </a>
            
            <h3 style="margin-top: 30px; color: var(--color-dark-text); font-weight: 600;">Lista de Mis Tickets</h3>

            <table cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha Creación</th>
                        <th>Título / Problema</th>
                        <th>Auxiliar Asignado</th>
                        <th>Estatus</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="tickets-table-body">
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px; color: #7f8c8d;">Cargando tickets...</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
    
    <div id="modal-nuevo-ticket" style="display:none;"></div> 

    <script>
        // *** FUNCIÓN DE INICIO: SE RESTAURA LA LLAMADA A CARGAR TICKETS REALES ***
        document.addEventListener('DOMContentLoaded', function() {
            // Llama a la función que hace la solicitud AJAX
            cargarTickets(); 
        });
        
        // Función real para cargar tickets
        function cargarTickets() {
            // Endpoint Blade para obtener los tickets del usuario
            fetch('{{ route("ticket.mis-tickets") }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Respuesta de red no fue ok');
                    }
                    return response.json();
                })
                .then(tickets => {
                    renderTickets(tickets);
                })
                .catch(error => {
                    console.error('Error al cargar tickets:', error);
                    document.getElementById('tickets-table-body').innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 20px; color: var(--color-danger-red);">Error al cargar tickets</td></tr>';
                });
        }
        
        // Función de renderizado
        function renderTickets(tickets) {
            const tbody = document.getElementById('tickets-table-body');
            tbody.innerHTML = '';
            
            if (tickets.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 20px; color: #7f8c8d;">No tienes tickets registrados</td></tr>';
                return;
            }

            tickets.forEach(ticket => {
                const row = document.createElement('tr');
                // Se asegura de manejar el caso donde departamento_asignado sea null
                const auxiliarNombre = ticket.departamento_asignado ? ticket.departamento_asignado.nombre : 'Sin asignar';

                row.innerHTML = `
                    <td>${ticket.id}</td>
                    <td>${new Date(ticket.created_at).toLocaleDateString()}</td>
                    <td>${ticket.título}</td>
                    <td>${auxiliarNombre}</td>
                    <td>${createStatusPill(ticket.status)}</td>
                    <td>${getActionButton(ticket.status, ticket.id)}</td>
                `;
                tbody.appendChild(row);
            });
        }
        
        // Función que crea el pill (cápsula) con el color de estatus
        function createStatusPill(status) {
            const color = getStatusColor(status);
            return `<span style="padding: 6px 12px; border-radius: 20px; background-color: ${color}; color: white; font-size: 0.8em; display: inline-block; font-weight: bold; min-width: 90px; text-align: center;">${status}</span>`;
        }

        // Se mantienen los colores originales para el significado de cada estatus
        function getStatusColor(status) {
            switch(status) {
                case 'Pendiente': return '#f39c12'; /* Naranja (Advertencia) */
                case 'En Proceso': return '#3498db'; /* Azul (En progreso) */
                case 'Completado': 
                case 'Finalizado': return 'var(--color-success-green)'; /* Verde (Éxito) */
                case 'Cerrado': return '#95a5a6'; /* Gris (Inactivo/Archivado) */
                default: return '#95a5a6';
            }
        }

        // La lógica de la acción se mantiene intacta
        function getActionButton(status, ticketId) {
            if (status === 'Pendiente') {
                return `<button onclick="showCustomConfirm(${ticketId})" class="btn btn-danger" style="box-shadow: none;">Cancelar Ticket</button>`;
            }
            // Botón de ver ticket
            return `<a href="/tickets/${ticketId}" style="text-decoration: none;"><button class="btn btn-primary" style="box-shadow: none; padding: 8px 12px;">NO DISPONIBLE</button></a>`;
        }
        
        // Función para mostrar confirmación personalizada (con estilos limpios)
        function showCustomConfirm(ticketId) {
            const modal = document.createElement('div');
            // Estilos del overlay
            modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(44, 62, 80, 0.7); z-index: 1000; display: flex; justify-content: center; align-items: center;';
            
            modal.innerHTML = `
                <div class="custom-modal-content">
                    <h4>⚠️ Confirmación de Cancelación</h4>
                    <p style="color: #555;">¿Estás seguro de que deseas **cancelar** el ticket ID ${ticketId}? Esta acción no se puede deshacer.</p>
                    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
                        <button id="cancel-btn" class="btn" style="background: #f4f4f4; color: var(--color-dark-text); box-shadow: none; border: 1px solid #ddd;">Volver</button>
                        <button id="delete-btn" class="btn btn-danger" style="box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3);">Sí, Cancelar Ticket</button>
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

        // La función de eliminación fetch se mantiene intacta
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
                    alert('Ticket cancelado con éxito.');
                } else {
                    console.error('Error al eliminar el ticket:', data);
                    alert('Error al intentar cancelar el ticket.');
                }
            })
            .catch(error => {
                console.error('Error de red al eliminar el ticket:', error);
                alert('Error de red. No se pudo cancelar el ticket.');
            });
        }
    </script>
</body>
</html>