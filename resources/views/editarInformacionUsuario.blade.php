<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - Sistema de Tickets</title>
</head>
<body>

    <div class="profile-container">
        
        <h2>Editar Mi Perfil</h2>
        
        <form method="POST" enctype="multipart/form-data" action="/profile/update">
            
            <div class="profile-img-container">
                <img src="/ruta/a/foto_actual.png" alt="Foto de perfil actual" class="profile-img">
            </div>

            <div style="margin-bottom: 25px;">
                <label for="profile_photo">Cambiar Foto de Perfil:</label>
                <input type="file" id="profile_photo" name="profile_photo" accept="image/*">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="edit_name">Nombre Completo:</label>
                <input type="text" id="edit_name" name="name" value="[Nombre Actual del Usuario]" required>
            </div>
            
            <div style="margin-bottom: 25px;">
                <label for="edit_email">Email (Usado para Login):</label>
                <input type="email" id="edit_email" name="email" value="[Email Actual del Usuario]" required>
            </div>
            
            <div class="restriction-box">
                <p style="font-weight: bold;">⚠️ Información NO Modificable por el Usuario</p>
                
                <p>
                    <strong>Departamento Actual:</strong> <span style="font-style: italic;">[Departamento Asignado]</span>
                </p>
                
                <p>
                    <strong>Puesto Actual:</strong> <span style="font-style: italic;">[Puesto del Empleado]</span>
                </p>
            </div>
            
            <div class="btn-group">
                <button type="submit" class="btn-save">
                    💾 Guardar Cambios
                </button>
                <button type="button" onclick="window.history.back()" class="btn-cancel">
                    Cancelar
                </button>
            </div>
        </form>

    </div>

</body>
</html>