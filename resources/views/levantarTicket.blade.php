<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Ticket - Dulces Ricos</title>
    <style>
        /* Estilos de fondo del modal (el overlay oscuro) */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        /* Estilos del contenedor del formulario */
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 550px;
        }
        h2 {
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
            color: #34495e;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            resize: vertical; /* Permite al usuario redimensionar la descripción */
        }
        .btn-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        .btn-group button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-submit { background-color: #2ecc71; color: white; }
        .btn-close { background-color: #bdc3c7; color: #333; }
    </style>
</head>
<body>

    <div id="new-ticket-modal" class="modal-overlay" style="display: block;"> 
        
        <div class="modal-content">
            
            <h2>✍️ Levantar Nuevo Ticket de Soporte</h2>
            
            <form method="POST" action="/api/tickets/store">
                
                <div>
                    <label for="ticket_title">Título o Asunto del Problema:</label>
                    <input 
                        type="text" 
                        id="ticket_title" 
                        name="title" 
                        placeholder="Ej: La impresora no funciona en el área de Ventas" 
                        required 
                        maxlength="100">
                </div>
                
                <div>
                    <label for="ticket_description">Descripción Detallada del Problema Técnico:</label>
                    <textarea 
                        id="ticket_description" 
                        name="description" 
                        rows="7" 
                        placeholder="Describa qué sucede, cuándo comenzó, si aparece algún mensaje de error y qué pasos ha tomado para intentar resolverlo." 
                        required>
                    </textarea>
                </div>
                
                <div class="btn-group">
                    <button type="button" onclick="window.history.back()" class="btn-close">
                        Cancelar y Cerrar
                    </button>
                    <button type="submit" class="btn-submit">
                        Enviar Solicitud
                    </button>
                </div>
            </form>

        </div>
        
    </div>

    </body>
</html>