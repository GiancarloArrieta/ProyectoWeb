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