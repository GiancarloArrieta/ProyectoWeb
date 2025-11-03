<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Ticket</title>
    <style>
        /* Variables de color (Consistentes con el proyecto) */
        :root {
            --color-primary-blue: #0984e3;
            --color-accent-warm: #fdcb6e;
            --color-accent-light: #ffeaa7;
            --color-dark-text: #2d3436;
            --color-danger-red: #e74c3c;
            --color-success-green: #2ecc71;
            --color-card-background: #fff5e6;
        }

        /* Reset y Layout principal */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* Fondo degradado cálido del proyecto */
            background: linear-gradient(135deg, var(--color-accent-light) 0%, var(--color-accent-warm) 100%);
            min-height: 100vh;
            /* Estos estilos centran el contenido del body, aunque el modal use 'fixed' */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* ------------------------------------- */
        /* Estilos de Modal (Centrado) */
        /* ------------------------------------- */

        .modal-overlay {
            /* Fija la posición y cubre toda la pantalla */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente oscuro */
            
            /* Centrado perfecto con Flexbox */
            display: flex; 
            justify-content: center;
            align-items: center;
            
            z-index: 1000;
        }

        .modal-content {
            max-width: 700px;
            width: 90%;
            background-color: var(--color-card-background);
            padding: 30px 40px;
            border-radius: 15px;
            border: 3px solid #fab1a0;
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
            animation: modalPopIn 0.3s ease-out;
            max-height: 90vh;
            overflow-y: auto;
        }
        @keyframes modalPopIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        /* ------------------------------------- */
        /* Estilos de Formulario y Tipografía */
        /* ------------------------------------- */
        
        h2 {
            font-size: 24px;
            color: var(--color-dark-text);
            font-weight: 700;
            border-bottom: 2px solid var(--color-accent-warm); 
            padding-bottom: 10px;
            margin-bottom: 25px;
            text-align: center;
        }
        
        div { /* Aplica margen a los contenedores de campo */
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            color: var(--color-dark-text);
            margin-bottom: 8px;
            font-weight: 600;
        }

        input[type="text"], 
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--color-accent-warm); 
            border-radius: 8px;
            font-size: 16px;
            color: var(--color-dark-text);
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
            background-color: white;
            box-sizing: border-box;
            resize: vertical;
        }

        input[type="text"]:focus, 
        textarea:focus {
            border-color: var(--color-primary-blue);
            box-shadow: 0 0 0 3px rgba(9, 132, 227, 0.2);
        }

        /* Estilos de Alerta (Error y Éxito) */
        .alert-error {
            background-color: #f8d7da; 
            color: #721c24;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #f5c6cb;
            font-size: 14px;
        }
        .alert-success {
            background-color: #d4edda; 
            color: #155724;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #c3e6cb;
            font-size: 14px;
        }
        .alert-error ul, .alert-success ul {
            margin: 0;
            padding-left: 20px;
        }

        /* ------------------------------------- */
        /* Estilos de Botones */
        /* ------------------------------------- */

        .btn-group {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }
        
        .btn-group > * {
            flex-grow: 1;
            text-decoration: none;
        }

        .btn-group button {
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.1s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 100%;
        }
        
        .btn-group button:active {
            transform: scale(0.99);
        }

        /* Botón Enviar Solicitud (Éxito) */
        .btn-submit {
            background-color: var(--color-success-green);
            color: white;
            box-shadow: 0 4px 10px rgba(46, 204, 113, 0.3);
        }
        .btn-submit:hover {
            background-color: #27ae60;
        }

        /* Botón Cancelar (Peligro/Advertencia) */
        .btn-close button {
            background-color: var(--color-danger-red); 
            color: white;
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3);
        }
        .btn-close button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

    <div id="new-ticket-modal" class="modal-overlay" style="display: flex;"> 
        
        <div class="modal-content">
            
            <h2>✍️ Levantar Nuevo Ticket de Soporte</h2>
            
            @if ($errors->any())
                <div class="alert-error">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert-success">
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
                    <a href="{{ route('usuario.profile') }}" class="btn-close">
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