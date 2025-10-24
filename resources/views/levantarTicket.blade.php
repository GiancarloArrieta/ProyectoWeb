<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Ticket - Dulces Ricos</title>
</head>
<body>

    <div id="new-ticket-modal" class="modal-overlay" style="display: block;"> 
        
        <div class="modal-content">
            
            <h2>✍️ Levantar Nuevo Ticket de Soporte</h2>
            
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
            
            <form method="POST" action="{{ route('ticket.store') }}">
                @csrf
                
                <div>
                    <label for="ticket_title">Título o Asunto del Problema:</label>
                    <input 
                        type="text" 
                        id="ticket_title" 
                        name="title" 
                        placeholder="Ej: La impresora no funciona en el área de Ventas" 
                        required 
                        maxlength="100"
                        value="{{ old('title') }}">
                </div>
                
                <div>
                    <label for="ticket_description">Descripción Detallada del Problema Técnico:</label>
                    <textarea 
                        id="ticket_description" 
                        name="description" 
                        rows="7" 
                        placeholder="Describa qué sucede, cuándo comenzó, si aparece algún mensaje de error y qué pasos ha tomado para intentar resolverlo." 
                        required>{{ old('description') }}</textarea>
                </div>
                
                <div class="btn-group">
                    <a href="{{ route('usuario.profile') }}" class="btn-close" style="text-decoration: none; color: inherit;">
                        <button type="button">
                            Cancelar y Cerrar
                        </button>
                    </a>
                    <button type="submit" class="btn-submit">
                        Enviar Solicitud
                    </button>
                </div>
            </form>

        </div>
        
    </div>

    </body>
</html>