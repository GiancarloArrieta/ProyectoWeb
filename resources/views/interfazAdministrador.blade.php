<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Jefe de Soporte</title>
</head>
<body>
    
    <header>
        <h1>Panel de Jefe de Soporte</h1>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-close">
                    Cerrar Sesión
                </button>
        </form>
    </header>

    <div class="admin-layout">
        
        <aside>
            <h3>Gestión del Sistema</h3>
            <nav>
                <a href="/gestionarusuarios">👥 Crear Usuarios y Roles</a>
                
                <a href="/administrardepartamentos">🏢 Administrar Departamentos</a>
                
                <a href="/gestionauxiliares">🛠️ Gestión de Auxiliares</a>
                
                <a href="/reportesestadisticas">📈 Reportes y Estadísticas</a>
            </nav>
        </aside>

        <main>
            
            <section id="reportes-graficas">
                <h2>📈 Dashboard de Indicadores</h2>
                
                <div class="charts-section">
                    <div class="chart-placeholder">Gráfica 1: Tickets Pendientes vs. Finalizados</div>
                    <div class="chart-placeholder">Gráfica 2: Tickets por Departamento</div>
                    <div class="chart-placeholder">Gráfica 3: Productividad por Auxiliar</div>
                </div>
            </section>
            
            <section id="todos-los-tickets">
                <h2>🎫 Todos los Tickets del Sistema</h2>
                
                <div class="controls-panel">
                    <label>Filtrar por Estatus:</label>
                    <select id="filtro-estatus" onchange="filtrarTickets()">
                        <option value="todos">Todos</option>
                        <option value="Pendiente">Pendientes</option>
                        <option value="Asignado">Asignados</option>
                        <option value="En Proceso">En Proceso</option>
                        <option value="Finalizado">Finalizados</option>
                    </select>

                    <button type="button" onclick="generarReporte()" style="margin-left: 20px; padding: 8px 15px; background-color: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        📄 Generar Reporte de Finalizados
                    </button>
                </div>
                
                <table id="tabla-tickets">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha Creación</th>
                            <th>Usuario</th>
                            <th>Título</th>
                            <th>Departamento</th>
                            <th>Estatus</th>
                            <th>Auxiliar Asignado</th>
                        </tr>
                    </thead>
                    <tbody id="tickets-tbody">
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 20px;">
                                Cargando tickets...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <script>
        let todosLosTickets = [];
        let auxiliaresDisponibles = [];

        // Cargar tickets y auxiliares al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarTickets();
            cargarAuxiliares();
        });

        // Cargar todos los tickets
        async function cargarTickets() {
            try {
                const response = await fetch('/api/tickets/todos');
                if (!response.ok) throw new Error('Error al cargar tickets');
                
                todosLosTickets = await response.json();
                mostrarTickets(todosLosTickets);
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('tickets-tbody').innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: red;">
                            Error al cargar los tickets
                        </td>
                    </tr>
                `;
            }
        }

        // Cargar auxiliares disponibles
        async function cargarAuxiliares() {
            try {
                const response = await fetch('/api/auxiliares/disponibles');
                if (!response.ok) throw new Error('Error al cargar auxiliares');
                
                auxiliaresDisponibles = await response.json();
            } catch (error) {
                console.error('Error al cargar auxiliares:', error);
            }
        }

        // Mostrar tickets en la tabla
        function mostrarTickets(tickets) {
            const tbody = document.getElementById('tickets-tbody');
            
            if (tickets.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px;">
                            No hay tickets registrados
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = tickets.map(ticket => {
                const fechaCreacion = new Date(ticket.created_at).toLocaleDateString('es-ES');
                const auxiliar = ticket.auxiliar_asignado ? ticket.auxiliar_asignado.nombre : 'Sin asignar';
                const statusColor = getStatusColor(ticket.status);
                
                // Hacer la fila clickeable para asignar solo si está pendiente
                const rowStyle = ticket.status === 'Pendiente' ? 'cursor: pointer;' : '';
                const rowClick = ticket.status === 'Pendiente' ? `onclick="mostrarModalAsignar(${ticket.id})"` : '';

                return `
                    <tr ${rowClick} style="${rowStyle}">
                        <td>${ticket.id}</td>
                        <td>${fechaCreacion}</td>
                        <td>${ticket.usuario.nombre}</td>
                        <td>${ticket.título}</td>
                        <td>${ticket.departamento_asignado.nombre}</td>
                        <td><span style="background-color: ${statusColor}; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">${ticket.status}</span></td>
                        <td>${auxiliar}</td>
                    </tr>
                `;
            }).join('');
        }

        // Filtrar tickets por estado
        function filtrarTickets() {
            const filtroEstatus = document.getElementById('filtro-estatus').value;
            
            if (filtroEstatus === 'todos') {
                mostrarTickets(todosLosTickets);
            } else {
                const ticketsFiltrados = todosLosTickets.filter(ticket => ticket.status === filtroEstatus);
                mostrarTickets(ticketsFiltrados);
            }
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

        // Mostrar modal para asignar ticket
        async function mostrarModalAsignar(ticketId) {
            // Recargar auxiliares para tener información actualizada
            await cargarAuxiliares();
            
            if (auxiliaresDisponibles.length === 0) {
                alert('No hay auxiliares registrados en el sistema.');
                return;
            }

            const opcionesAuxiliares = auxiliaresDisponibles.map(aux => {
                const ticketsInfo = aux.tickets_activos > 0 ? ` - ${aux.tickets_activos} ticket(s) activo(s)` : '';
                return `<option value="${aux.id}">${aux.nombre}${ticketsInfo}</option>`;
            }).join('');

            const html = `
                <div id="modal-asignar" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 1000;">
                    <div style="background-color: white; padding: 30px; border-radius: 8px; max-width: 500px; width: 90%;">
                        <h3 style="margin-top: 0;">Asignar Ticket #${ticketId}</h3>
                        <p>Seleccione un auxiliar disponible para asignar este ticket:</p>
                        <select id="select-auxiliar" style="width: 100%; padding: 10px; margin: 15px 0; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">Seleccione un auxiliar...</option>
                            ${opcionesAuxiliares}
                        </select>
                        <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                            <button onclick="cerrarModal()" style="padding: 10px 20px; background-color: #95a5a6; color: white; border: none; border-radius: 4px; cursor: pointer;">Cancelar</button>
                            <button onclick="asignarTicket(${ticketId})" style="padding: 10px 20px; background-color: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer;">Asignar</button>
                        </div>
                    </div>
                </div>
            `;

            document.body.insertAdjacentHTML('beforeend', html);
        }

        // Cerrar modal
        function cerrarModal() {
            const modal = document.getElementById('modal-asignar');
            if (modal) modal.remove();
        }

        // Asignar ticket a auxiliar
        async function asignarTicket(ticketId) {
            const auxiliarId = document.getElementById('select-auxiliar').value;
            
            if (!auxiliarId) {
                alert('Por favor seleccione un auxiliar');
                return;
            }

            try {
                const response = await fetch(`/api/tickets/${ticketId}/asignar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id_auxiliar: auxiliarId })
                });

                const data = await response.json();

                if (data.success) {
                    alert('Ticket asignado exitosamente');
                    cerrarModal();
                    cargarTickets();
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al asignar el ticket');
            }
        }

        // Ver detalles del ticket
        function verDetalles(ticketId) {
            window.location.href = `/detalleticket/${ticketId}`;
        }

        // Generar reporte de tickets finalizados
        async function generarReporte() {
            try {
                const response = await fetch('/api/tickets/reporte/finalizados');
                if (!response.ok) throw new Error('Error al generar reporte');
                
                const data = await response.json();
                
                if (data.total === 0) {
                    alert('No hay tickets finalizados para generar reporte');
                    return;
                }

                // Crear tabla HTML para mostrar/imprimir
                let reporteHtml = `
                    <html>
                    <head>
                        <title>Reporte de Tickets Finalizados</title>
                        <style>
                            body { font-family: Arial, sans-serif; padding: 20px; }
                            h1 { color: #2c3e50; }
                            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                            th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                            th { background-color: #3498db; color: white; }
                            tr:nth-child(even) { background-color: #f2f2f2; }
                        </style>
                    </head>
                    <body>
                        <h1>📊 Reporte de Tickets Finalizados</h1>
                        <p><strong>Total de tickets finalizados:</strong> ${data.total}</p>
                        <p><strong>Fecha de generación:</strong> ${new Date().toLocaleString('es-ES')}</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Usuario</th>
                                    <th>Auxiliar</th>
                                    <th>Fecha Creación</th>
                                    <th>Fecha Finalización</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                data.tickets.forEach(ticket => {
                    const fechaCreacion = new Date(ticket.created_at).toLocaleDateString('es-ES');
                    const fechaFin = ticket.fecha_finalizacion ? new Date(ticket.fecha_finalizacion).toLocaleDateString('es-ES') : 'N/A';
                    reporteHtml += `
                        <tr>
                            <td>${ticket.id}</td>
                            <td>${ticket.título}</td>
                            <td>${ticket.usuario.nombre}</td>
                            <td>${ticket.auxiliar_asignado ? ticket.auxiliar_asignado.nombre : 'N/A'}</td>
                            <td>${fechaCreacion}</td>
                            <td>${fechaFin}</td>
                        </tr>
                    `;
                });

                reporteHtml += `
                            </tbody>
                        </table>
                    </body>
                    </html>
                `;

                // Abrir en nueva ventana para imprimir
                const ventana = window.open('', '_blank');
                ventana.document.write(reporteHtml);
                ventana.document.close();
                ventana.print();
            } catch (error) {
                console.error('Error:', error);
                alert('Error al generar el reporte');
            }
        }
    </script>

</body>
</html>