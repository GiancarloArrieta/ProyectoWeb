<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ticket - ID {{ $ticket->id }}</title>
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
            background-color: #6c5ce7;
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
            background-color: #a29bfe;
        }

        main {
            max-width: 1200px;
            margin: 0 auto;
        }

        .ticket-header {
            background-color: #2d3436;
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .ticket-header h2 {
            font-size: 30px;
            font-weight: 700;
        }

        .info-section {
            background-color: #fff5e6;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 25px;
            border: 3px solid #fab1a0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .info-section h3 {
            color: #2d3436;
            font-size: 22px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 3px solid #fdcb6e;
            text-align: center;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
            margin-top: 20px;
        }

        .info-item {
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            border: 2px solid #ffeaa7;
        }

        .info-item strong {
            color: #636e72;
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item span {
            color: #2d3436;
            font-size: 16px;
            font-weight: 600;
        }

        .status-badge {
            padding: 8px 18px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 700;
            color: white;
            display: inline-block;
        }

        .description-section {
            background-color: #ffe8b8;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 25px;
            border: 3px solid #fdcb6e;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .description-section h3 {
            color: #2d3436;
            font-size: 22px;
            margin-bottom: 20px;
            text-align: center;
            padding-bottom: 12px;
            border-bottom: 3px solid #d63031;
        }

        .description-content {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            border: 2px solid #fdcb6e;
            line-height: 1.8;
            color: #2d3436;
            font-size: 15px;
        }

        .actions-section {
            background-color: #d5f4e6;
            padding: 35px;
            border-radius: 15px;
            margin-bottom: 25px;
            border: 3px solid #00b894;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .actions-section h3 {
            color: #2d3436;
            font-size: 22px;
            margin-bottom: 20px;
            text-align: center;
            padding-bottom: 12px;
            border-bottom: 3px solid #00b894;
        }

        .action-message {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 16px;
            color: #636e72;
            border: 2px solid #00b894;
        }

        .action-button {
            width: 100%;
            padding: 18px;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-iniciar {
            background-color: #f39c12;
            color: white;
        }

        .btn-iniciar:hover {
            background-color: #e67e22;
        }

        .btn-finalizar {
            background-color: #00b894;
            color: white;
        }

        .btn-finalizar:hover {
            background-color: #00a383;
        }

        .success-box {
            background-color: #d4edda;
            color: #155724;
            padding: 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
            font-size: 16px;
            border: 2px solid #00b894;
            display: none;
        }

        .error-box {
            background-color: #f8d7da;
            color: #721c24;
            padding: 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
            font-size: 16px;
            border: 2px solid #d63031;
            display: none;
        }

        .completed-message {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            font-size: 20px;
            color: #00b894;
            font-weight: 700;
            border: 3px solid #00b894;
        }
    </style>
</head>
<body>

    <header>
        <h1>🛠️ Panel de Soporte Técnico</h1>
        <a href="/interfazsoporte" style="text-decoration: none;">
            <button type="button">← Volver a Mis Tickets</button>
        </a>
    </header>

    <main>
        
        <div class="ticket-header">
            <h2>🎫 Ticket ID: {{ $ticket->id }}</h2>
        </div>

        <div class="info-section">
            <h3>📋 Información del Reporte</h3>
            <div class="info-grid">
                <div class="info-item">
                    <strong>Título del Ticket</strong>
                    <span>{{ $ticket->título }}</span>
                </div>
                <div class="info-item">
                    <strong>Reportado por</strong>
                    <span>{{ $ticket->usuario->nombre }}</span>
                </div>
                <div class="info-item">
                    <strong>Email de Contacto</strong>
                    <span>{{ $ticket->usuario->correo }}</span>
                </div>
                <div class="info-item">
                    <strong>Departamento</strong>
                    <span>{{ $ticket->departamentoAsignado->nombre }}</span>
                </div>
                <div class="info-item">
                    <strong>Fecha de Creación</strong>
                    <span>{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-item">
                    <strong>Estatus Actual</strong>
                    <span class="status-badge" style="background-color: {{ getStatusColor($ticket->status) }};">
                        {{ $ticket->status }}
                    </span>
                </div>
                @if($ticket->fecha_asignacion)
                <div class="info-item">
                    <strong>Fecha de Asignación</strong>
                    <span>{{ $ticket->fecha_asignacion->format('d/m/Y H:i') }}</span>
                </div>
                @endif
                @if($ticket->fecha_inicio)
                <div class="info-item">
                    <strong>Fecha de Inicio</strong>
                    <span>{{ $ticket->fecha_inicio->format('d/m/Y H:i') }}</span>
                </div>
                @endif
                @if($ticket->fecha_finalizacion)
                <div class="info-item">
                    <strong>Fecha de Finalización</strong>
                    <span>{{ $ticket->fecha_finalizacion->format('d/m/Y H:i') }}</span>
                </div>
                @endif
            </div>
            </div>

        <div class="description-section">
            <h3>📝 Descripción Detallada del Problema</h3>
            <div class="description-content">
                {{ $ticket->descripción }}
            </div>
            </div>
            
        @if($ticket->auxiliarAsignado && $ticket->auxiliarAsignado->id === auth()->id())
            <div class="actions-section">
                <h3>⚡ Acciones del Auxiliar</h3>
                
                <div id="success-message" class="success-box">
                    ✅ Estado actualizado correctamente
                </div>
                
                <div id="error-message" class="error-box">
                </div>

                @if($ticket->status === 'Asignado')
                    <div class="action-message">
                        Este ticket está asignado a ti. Haz clic en el botón para comenzar a trabajar en él.
                    </div>
                    <button onclick="cambiarEstado('En Proceso')" class="action-button btn-iniciar">
                        ▶️ Iniciar Trabajo en Este Ticket
                    </button>
                @elseif($ticket->status === 'En Proceso')
                    <div class="action-message">
                        Estás trabajando activamente en este ticket. Finalízalo cuando hayas completado la solución.
                    </div>
                    <button onclick="cambiarEstado('Finalizado')" class="action-button btn-finalizar">
                        ✔️ Marcar Ticket Como Finalizado
                    </button>
                @elseif($ticket->status === 'Finalizado')
                    <div class="completed-message">
                        ✅ Este ticket ha sido completado exitosamente
                    </div>
                @endif
                </div>
        @endif

    </main>

    <script>
        async function cambiarEstado(nuevoEstado) {
            const confirmacion = confirm(`¿Está seguro de cambiar el estado a "${nuevoEstado}"?`);
            if (!confirmacion) return;

            try {
                // Obtener la fecha y hora actual del cliente (computadora local)
                const fechaHoraCliente = new Date().toISOString();

                const response = await fetch('/api/tickets/{{ $ticket->id }}/estado', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ 
                        status: nuevoEstado,
                        fecha_hora_cliente: fechaHoraCliente
                    })
                });

                const data = await response.json();

                if (data.success) {
                    const successBox = document.getElementById('success-message');
                    successBox.style.display = 'block';
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    const errorBox = document.getElementById('error-message');
                    errorBox.textContent = 'Error: ' + data.message;
                    errorBox.style.display = 'block';
                }
            } catch (error) {
                console.error('Error:', error);
                const errorBox = document.getElementById('error-message');
                errorBox.textContent = '❌ Error al cambiar el estado del ticket';
                errorBox.style.display = 'block';
            }
        }
    </script>

</body>
</html>

@php
function getStatusColor($status) {
    $colors = [
        'Pendiente' => '#e67e22',
        'Asignado' => '#3498db',
        'En Proceso' => '#f39c12',
        'Finalizado' => '#27ae60'
    ];
    return $colors[$status] ?? '#95a5a6';
}
@endphp