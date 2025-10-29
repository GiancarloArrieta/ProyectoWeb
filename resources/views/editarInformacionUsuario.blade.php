<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
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
        
        <!-- IMPORTANTE: Añadido enctype="multipart/form-data" -->
        <form method="POST" enctype="multipart/form-data" action="{{ route('usuario.update') }}">
            @csrf
            
            <div class="profile-img-container" style="text-align: center; margin-bottom: 20px;">
                @php
                    // Determina la ruta de la foto: usa la guardada o un avatar por defecto
                    // ASUME: default-avatar.png está en public/images/
                    $profilePhotoPath = auth()->user()->profile_photo 
                        ? asset('storage/' . auth()->user()->profile_photo) 
                        : asset('images/default-avatar.png'); 
                @endphp
                <img 
                    src="{{ $profilePhotoPath }}" 
                    alt="Foto de perfil actual" 
                    class="profile-img"
                    style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid #3498db;"
                >
            </div>

            <div style="margin-bottom: 25px;">
                <label for="profile_photo">Cambiar Foto de Perfil (Max 5MB, JPG/PNG):</label>
                <!-- Campo de tipo file ya incluido -->
                <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="@error('profile_photo') is-invalid @enderror" style="display: block; margin-top: 5px;">
                @error('profile_photo')
                    <span style="color: red; font-size: 0.8em; display: block; margin-top: 3px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label for="edit_name">Nombre Completo:</label>
                <input type="text" id="edit_name" name="name" value="{{ old('name', auth()->user()->nombre ?? '') }}" required>
            </div>
            
            <div style="margin-bottom: 25px;">
                <label for="edit_email">Email (Usado para Login):</label>
                <input type="email" id="edit_email" name="email" value="{{ old('email', auth()->user()->correo ?? '') }}" required>
            </div>
            
            <div class="restriction-box" style="padding: 10px; border: 1px solid #f39c12; background-color: #fef9e7; border-radius: 4px;">
                <p style="font-weight: bold; margin-top: 0;">⚠️ Información NO Modificable por el Usuario</p>
                
                <p style="margin: 5px 0;">
                    <strong>Departamento Actual:</strong> <span style="font-style: italic;">{{ auth()->user()->departamento_nombre ?? 'No asignado' }}</span>
                </p>
                
                <p style="margin: 5px 0;">
                    <strong>Puesto Actual:</strong> <span style="font-style: italic;">{{ auth()->user()->rol_nombre ?? 'No asignado' }}</span>
                </p>
            </div>
            
            <div class="btn-group" style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn-save" style="background-color: #2ecc71; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer;">
                    💾 Guardar Cambios
                </button>
                <a href="{{ route('usuario.profile') }}" class="btn-cancel" style="text-decoration: none;">
                    <button type="button" style="background-color: #e74c3c; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer;">
                        Cancelar
                    </button>
                </a>
            </div>
        </form>

    </div>

</body>
</html>