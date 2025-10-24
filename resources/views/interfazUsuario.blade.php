<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Empleado - Dulces Ricos</title>
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
        <h1>Bienvenido(a), [Nombre del Usuario]</h1>
            <button type="button" onclick="window.history.back()" class="btn-close">
                        Cerrar
            </button>
    </header>

    <main style="display: flex; gap: 30px; margin-top: 20px;">
        
        <section id="user-profile" style="width: 30%; border: 1px solid #ccc; padding: 20px; background: white;">
            <h2>Mi Perfil</h2>
            
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="/ruta/a/foto_de_perfil.png" alt="Foto de perfil" style="width: 100px; height: 100px; border-radius: 50%;">
            </div>

            <div>
                <p><strong>Nombre:</strong> [Nombre Completo del Usuario]</p>
                <p><strong>Email:</strong> [Email del Usuario]</p>
                
                <p style="border-top: 1px solid #ddd; padding-top: 10px;">
                    <strong>Departamento:</strong> [Departamento Asignado] 
                </p>
                <p>
                    <strong>Puesto:</strong> [Puesto del Empleado]
                </p>
                
                <a href="/editarInformacionUsuario" style="text-decoration: none;">
                    <button type="button">
                        Editar Datos Personales
                    </button>
                </a>
            </div>
        </section>

        <section id="user-tickets" style="width: 70%; border: 1px solid #ccc; padding: 20px; background: white;">
            <h2>Gestión de Tickets</h2>
            
            <a href="/levantarTicket" style="text-decoration: none;">
                <button type="button">
                    + Levantar Nuevo Ticket
                </button>
            </a>
            
            <h3 style="margin-top: 20px;">Lista de Mis Tickets</h3>

            <table border="1" style="width: 100%; margin-top: 10px; text-align: left; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #ecf0f1;">
                        <th>ID</th>
                        <th>Fecha Creación</th>
                        <th>Título / Problema</th>
                        <th>Auxiliar Asignado</th>
                        <th>Estatus</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </section>
    </main>
    
    <div id="modal-nuevo-ticket" style="display:none;">
         </div>
</body>
</html>