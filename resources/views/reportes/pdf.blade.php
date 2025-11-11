<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Tickets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h1 {
            color: #2d3436;
            border-bottom: 3px solid #fdcb6e;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #2d3436;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #fff5e6;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <h1>📊 Reporte de Tickets</h1>
    
    <div class="summary">
        <p><strong>Fecha de Inicio:</strong> {{ $request->start_date }}</p>
        <p><strong>Fecha de Fin:</strong> {{ $request->end_date }}</p>
        <p><strong>Total de Tickets:</strong> {{ $tickets->count() }}</p>
        @if($request->status && $request->status !== 'todos')
            <p><strong>Filtro de Estatus:</strong> {{ ucfirst($request->status) }}</p>
        @endif
        @if($request->department && $request->department !== 'todos')
            <p><strong>Departamento:</strong> {{ $request->department }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Usuario</th>
                <th>Departamento</th>
                <th>Estatus</th>
                <th>Auxiliar</th>
                <th>Fecha Creación</th>
                <th>Fecha Finalización</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->título }}</td>
                    <td>{{ $ticket->usuario ? $ticket->usuario->nombre : 'N/A' }}</td>
                    <td>{{ $ticket->departamentoAsignado ? $ticket->departamentoAsignado->nombre : 'N/A' }}</td>
                    <td>{{ $ticket->status }}</td>
                    <td>{{ $ticket->auxiliarAsignado ? $ticket->auxiliarAsignado->nombre : 'Sin asignar' }}</td>
                    <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $ticket->fecha_finalizacion ? $ticket->fecha_finalizacion->format('d/m/Y H:i') : 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">No hay tickets en el período seleccionado</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p style="margin-top: 30px; font-size: 10px; color: #7f8c8d;">
        Reporte generado el {{ now()->format('d/m/Y H:i:s') }}
    </p>
</body>
</html>

