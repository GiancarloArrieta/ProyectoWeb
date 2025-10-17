<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Empleado - Dulces Ricos</title>
    </head>
<body>
    <header>
        <h1>Bienvenido(a), [Nombre del Usuario]</h1>
        <button type="button">Cerrar Sesión</button>
    </header>

    <main style="display: flex; gap: 30px; margin-top: 20px;">
        
        <section id="user-profile" style="width: 30%; border: 1px solid #ccc; padding: 20px;">
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
                <a href="editarInformacionUsuario" style="text-decoration: none;">
                <button type="button">
                    Editar Datos Personales
                </button>
                </a>
            </div>
        </section>

        <section id="user-tickets" style="width: 70%; border: 1px solid #ccc; padding: 20px;">
            <h2>Gestión de Tickets</h2>
            <a href="levantarTicket" style="text-decoration: none;">
            <button type="button" onclick="mostrarModalNuevoTicket()">
                + Levantar Nuevo Ticket
            </button>
            </a>
            
            <h3 style="margin-top: 20px;">Lista de Mis Tickets</h3>

            <table border="1" style="width: 100%; margin-top: 10px; text-align: left;">
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
                <tbody>
                    <tr>
                        <td>1001</td>
                        <td>2025-10-15</td>
                        <td>Falla de impresora</td>
                        <td>PENDIENTE DE ASIGNAR</td>
                        <td>
                            <span style="font-weight: bold; color: orange;">Pendiente</span>
                        </td>
                        <td>
                            <button type="button" style="color: red;">
                                Cancelar Ticket
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>1002</td>
                        <td>2025-10-14</td>
                        <td>Error de software</td>
                        <td>Juan Pérez (Auxiliar)</td>
                        <td>
                            <span style="font-weight: bold; color: blue;">En proceso</span>
                        </td>
                        <td>No disponible</td>
                    </tr>
                    <tr>
                        <td>1003</td>
                        <td>2025-10-10</td>
                        <td>Problema de red</td>
                        <td>María García (Auxiliar)</td>
                        <td>
                            <span style="font-weight: bold; color: green;">Finalizado</span>
                        </td>
                        <td>No disponible</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>

    <div id="modal-nuevo-ticket" style="display:none;">
        <h3>Levantar Nuevo Ticket</h3>
        <form>
            <p>
                <label for="ticket_title">Título del Problema:</label><br>
                <input type="text" id="ticket_title" name="title" required>
            </p>
            <p>
                <label for="ticket_description">Descripción Detallada del Problema Técnico:</label><br>
                <textarea id="ticket_description" name="description" rows="5" required></textarea>
            </p>
            <button type="submit">Enviar Solicitud</button>
            <button type="button" onclick="ocultarModalNuevoTicket()">Cerrar</button>
        </form>
    </div>
</body>
</html>