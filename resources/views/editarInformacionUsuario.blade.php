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
        
        <form method="POST" enctype="multipart/form-data" action="{{ route('usuario.update') }}">
            @csrf
            
            <div class="profile-img-container">
                <img src="/ruta/a/foto_actual.png" alt="Foto de perfil actual" class="profile-img">
            </div>

            <div style="margin-bottom: 25px;">
                <label for="profile_photo">Cambiar Foto de Perfil:</label>
                <input type="file" id="profile_photo" name="profile_photo" accept="image/*">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="edit_name">Nombre Completo:</label>
                <input type="text" id="edit_name" name="name" value="{{ auth()->user()->nombre ?? '' }}" required>
            </div>
            
            <div style="margin-bottom: 25px;">
                <label for="edit_email">Email (Usado para Login):</label>
                <input type="email" id="edit_email" name="email" value="{{ auth()->user()->correo ?? '' }}" required>
            </div>
            
            <div class="restriction-box">
                <p style="font-weight: bold;">⚠️ Información NO Modificable por el Usuario</p>
                
                <p>
                    <strong>Departamento Actual:</strong> <span style="font-style: italic;">{{ auth()->user()->departamento_nombre ?? 'No asignado' }}</span>
                </p>
                
                <p>
                    <strong>Puesto Actual:</strong> <span style="font-style: italic;">{{ auth()->user()->rol_nombre ?? 'No asignado' }}</span>
                </p>
            </div>
            
            <div class="btn-group">
                <button type="submit" class="btn-save">
                    💾 Guardar Cambios
                </button>
                <a href="{{ route('usuario.profile') }}" class="btn-cancel" style="text-decoration: none; color: inherit;">
                    <button type="button">
                        Cancelar
                    </button>
                </a>
            </div>
        </form>

    </div>

</body>
</html>