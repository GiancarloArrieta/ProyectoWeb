<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - Sistema de Tickets</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f9; }
        .profile-container { max-width: 500px; margin: 40px auto; padding: 25px; background: white; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h2 { border-bottom: 2px solid #3498db; padding-bottom: 10px; margin-bottom: 20px; color: #34495e; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], select, input[type="file"] { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .restriction-box { border: 2px dashed #e74c3c; padding: 15px; background: #fef0f0; margin-bottom: 20px; color: #c0392b; border-radius: 4px; }
        .restriction-box p { margin: 5px 0; }
        .btn-group button { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px; }
        .btn-group .btn-save { background-color: #2ecc71; color: white; }
        .btn-group .btn-cancel { background-color: #bdc3c7; color: #333; }
        .profile-img-container { text-align: center; margin-bottom: 20px; }
        .profile-img { width: 120px; height: 120px; border-radius: 50%; border: 3px solid #3498db; object-fit: cover; }
    </style>
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