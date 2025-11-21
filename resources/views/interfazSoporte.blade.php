<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Auxiliar de Soporte</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
            min-height: 100vh;
            padding: 20px;
        }

        header {
            background-color: #2d3436;
            color: white;
            padding: 25px 40px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        header h1 {
            font-size: 28px;
            font-weight: 600;
        }

        header button {
            background-color: #d63031;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        header button:hover {
            background-color: #e74c3c;
        }

        header a button:hover {
            background-color: #0c6ccf !important;
        }

        /* Layout principal con sidebar */
        .soporte-layout {
            display: flex;
            gap: 25px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Sidebar izquierdo con perfil */
        .soporte-sidebar {
            width: 320px;
            flex-shrink: 0;
        }

        /* Contenido principal */
        main {
            flex-grow: 1;
            min-width: 0; /* Permite que el contenido principal se ajuste */
        }

        #dashboard-resumen {
            background-color: #fff5e6;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 3px solid #fab1a0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        #dashboard-resumen h2 {
            text-align: center;
            color: #2d3436;
            font-size: 26px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #fdcb6e;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .stat-box {
            background-color: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            border: 2px solid #ffeaa7;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .stat-box p {
            font-size: 16px;
            color: #636e72;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .stat-box strong {
            font-size: 36px;
            color: #2d3436;
            font-weight: 700;
            display: block;
        }

        .stat-box.asignados strong {
            color: #0984e3;
        }

        .stat-box.proceso strong {
            color: #fdcb6e;
        }

        .stat-box.finalizados strong {
            color: #00b894;
        }

        #tickets-asignados {
            background-color: #fff;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        #tickets-asignados h2 {
            text-align: center;
            color: #2d3436;
            font-size: 26px;
            margin-bottom: 30px;
            padding: 15px;
            background-color: #ffeaa7;
            border-radius: 10px;
            border: 2px solid #fdcb6e;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
        }

        thead {
            background-color: #2d3436;
            color: white;
        }

        th {
            padding: 18px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        th:first-child {
            border-top-left-radius: 10px;
        }

        th:last-child {
            border-top-right-radius: 10px;
        }

        tbody tr {
            background-color: #fef5e7;
            border-bottom: 2px solid #ffeaa7;
            transition: background-color 0.2s;
        }

        tbody tr:hover {
            background-color: #ffe8c0;
        }

        td {
            padding: 16px 18px;
            color: #2d3436;
            font-size: 14px;
        }

        td button {
            background-color: #0984e3;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        td button:hover {
            background-color: #74b9ff;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        /* Estilos para el sidebar de perfil */
        .profile-sidebar {
            background-color: #fff5e6;
            padding: 25px;
            border-radius: 15px;
            border: 3px solid #fab1a0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            position: sticky;
            top: 20px;
        }

        .profile-sidebar h2 {
            text-align: center;
            color: #2d3436;
            font-size: 22px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #fdcb6e;
        }

        .profile-sidebar .profile-image-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .profile-sidebar .profile-image {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fdcb6e;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            margin: 0 auto;
        }

        .profile-sidebar .profile-info {
            font-size: 14px;
            color: #2d3436;
        }

        .profile-sidebar .profile-info-item {
            margin: 15px 0;
            padding: 12px;
            background-color: rgba(255, 255, 255, 0.6);
            border-radius: 8px;
            border-left: 4px solid #fdcb6e;
        }

        .profile-sidebar .profile-info-item strong {
            display: block;
            color: #2d3436;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            color: #636e72;
        }

        .profile-sidebar .profile-info-item span {
            display: block;
            color: #2d3436;
            font-size: 15px;
            font-weight: 600;
            word-wrap: break-word;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .soporte-layout {
                flex-direction: column;
            }
            
            .soporte-sidebar {
                width: 100%;
            }
            
            .profile-sidebar {
                position: relative;
                top: 0;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>🛠️ Panel de Soporte Técnico - Bienvenido, {{ $usuario->nombre ?? 'Usuario' }}</h1>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('usuario.edit.adminaux', ['origen' => 'auxiliar']) }}" style="text-decoration: none;">
                <button type="button" style="background-color: #0984e3; color: white; border: none; padding: 12px 30px; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background-color 0.3s;">
                    ✏️ Editar Datos
                </button>
            </a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit">🚪 Cerrar Sesión</button>
            </form>
        </div>
    </header>

    <div class="soporte-layout">
        
        <!-- Sidebar izquierdo con perfil -->
        <aside class="soporte-sidebar">
            <div class="profile-sidebar">
                <h2>👤 Mi Perfil</h2>
                
                <div class="profile-image-container">
                    @php
                        $profilePhotoPath = $usuario->profile_photo ?? null;
                        $profilePhotoPath = $profilePhotoPath ? asset('storage/' . $profilePhotoPath) : asset('images/default-avatar.png');
                    @endphp
                    <img 
                        src="{{ $profilePhotoPath }}" 
                        alt="Foto de perfil" 
                        class="profile-image"
                    >
                </div>
                
                <div class="profile-info">
                    <div class="profile-info-item">
                        <strong>Nombre Completo</strong>
                        <span>{{ $usuario->nombre ?? 'N/A' }}</span>
                    </div>
                    
                    <div class="profile-info-item">
                        <strong>Correo Electrónico</strong>
                        <span>{{ $usuario->correo ?? 'N/A' }}</span>
                    </div>
                    
                    <div class="profile-info-item">
                        <strong>Puesto</strong>
                        <span>{{ $usuario->rol_nombre ?? 'N/A' }}</span>
                    </div>
                    
                    <div class="profile-info-item">
                        <strong>Departamento</strong>
                        <span>{{ $usuario->departamento_nombre ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Contenido principal -->
        <main>
            
            @if (session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    ✅ {{ session('success') }}
                </div>
            @endif
        
            <section id="dashboard-resumen">
            <h2>📊 Resumen Rápido de Tickets</h2>
            <div class="stats-container">
                <div class="stat-box asignados">
                    <p>Tickets Asignados</p>
                    <strong id="total-asignados">0</strong>
                </div>
                <div class="stat-box proceso">
                    <p>Tickets En Proceso</p>
                    <strong id="total-proceso">0</strong>
                </div>
                <div class="stat-box finalizados">
                    <p>Tickets Finalizados</p>
                    <strong id="total-finalizados">0</strong>
                </div>
            </div>
        </section>

        <section id="tickets-asignados">
            <h2>🎫 Mis Tickets Asignados</h2>

            <table id="tabla-tickets-soporte">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha Creación</th>
                        <th>Usuario que Reporta</th>
                        <th>Departamento</th>
                        <th>Título del Problema</th>
                        <th>Estatus Actual</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="tickets-soporte-tbody">
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px;">
                            Cargando tickets asignados...
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        </main>
        
    </div>

    <script>
        let misTickets = [];

        // Cargar tickets asignados al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarMisTickets();
            // Recargar cada 30 segundos para ver nuevos tickets asignados
            setInterval(cargarMisTickets, 30000);
        });

        // Cargar tickets asignados al auxiliar
        async function cargarMisTickets() {
            try {
                const response = await fetch('/api/tickets/mis-asignados');
                if (!response.ok) throw new Error('Error al cargar tickets');
                
                misTickets = await response.json();
                mostrarTickets(misTickets);
                actualizarResumen(misTickets);
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('tickets-soporte-tbody').innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: red;">
                            Error al cargar los tickets asignados
                        </td>
                    </tr>
                `;
            }
        }

        // Mostrar tickets en la tabla
        function mostrarTickets(tickets) {
            const tbody = document.getElementById('tickets-soporte-tbody');
            
            if (tickets.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px;">
                            No tienes tickets asignados en este momento
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = tickets.map(ticket => {
                const fechaCreacion = new Date(ticket.created_at).toLocaleDateString('es-ES');
                const statusColor = getStatusColor(ticket.status);

                return `
                    <tr>
                        <td>${ticket.id}</td>
                        <td>${fechaCreacion}</td>
                        <td>${ticket.usuario.nombre}</td>
                        <td>${ticket.departamento_asignado.nombre}</td>
                        <td>${ticket.título}</td>
                        <td><span style="background-color: ${statusColor}; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">${ticket.status}</span></td>
                        <td>
                            <button onclick="verDetalles(${ticket.id})" 
                                    style="padding: 5px 10px; background-color: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                Ver
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Actualizar resumen
        function actualizarResumen(tickets) {
            const totalAsignados = tickets.filter(t => t.status === 'Asignado').length;
            const totalEnProceso = tickets.filter(t => t.status === 'En Proceso').length;
            const totalFinalizados = tickets.filter(t => t.status === 'Finalizado').length;
            
            document.getElementById('total-asignados').textContent = totalAsignados;
            document.getElementById('total-proceso').textContent = totalEnProceso;
            document.getElementById('total-finalizados').textContent = totalFinalizados;
        }

        // Obtener color según el estado
        function getStatusColor(status) {
            const colors = {
                'Pendiente': '#e67e22',
                'Asignado': '#3498db',
                'En Proceso': '#f39c12',
                'Finalizado': '#27ae60'
            };
            return colors[status] || '#95a5a6';
        }

        // Ver detalles del ticket
        function verDetalles(ticketId) {
            window.location.href = `/detalleticket/${ticketId}`;
        }
    </script>

</body>
</html>