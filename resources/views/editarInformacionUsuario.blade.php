<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <style>
        /* Variables de color del proyecto (Basadas en el Login) */
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Contenedor principal (Tarjeta de edición) */
        .profile-container {
            max-width: 600px;
            width: 100%;
            background-color: var(--color-card-background);
            padding: 40px;
            border-radius: 15px;
            border: 3px solid #fab1a0; /* Borde suave */
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Encabezado */
        h2 {
            font-size: 28px;
            color: var(--color-dark-text);
            font-weight: 700;
            /* Línea de acento cálida */
            border-bottom: 3px solid var(--color-accent-warm); 
            padding-bottom: 10px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        /* Estilos de Alerta (Error y Éxito) */
        .alert-box {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 14px;
            border: 1px solid transparent;
        }
        .alert-error {
            background-color: #f8d7da; /* Rojo claro */
            color: #721c24;
            border-color: #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda; /* Verde claro */
            color: #155724;
            border-color: #c3e6cb;
        }
        .alert-box ul {
            margin: 0;
            padding-left: 20px;
        }
        
        /* Campos de Formulario */
        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-size: 14px;
            color: var(--color-dark-text);
            margin-bottom: 8px;
            font-weight: 600;
        }

        input[type="text"], 
        input[type="email"], 
        input[type="file"] {
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
        }
        
        input[type="file"] {
            padding: 5px 0; /* Ajuste para inputs de tipo file */
            border: none;
            width: auto;
        }

        input[type="text"]:focus, 
        input[type="email"]:focus {
            border-color: var(--color-primary-blue);
            box-shadow: 0 0 0 3px rgba(9, 132, 227, 0.2);
        }
        
        /* Perfil de Imagen */
        .profile-img {
            /* Usamos el color cálido para el borde de acento */
            border: 4px solid var(--color-accent-warm) !important; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        /* Caja de restricción (Información no editable) */
        .restriction-box {
            padding: 15px;
            border: 2px solid var(--color-accent-warm) !important; 
            background-color: #fef9e7 !important; 
            border-radius: 10px !important;
            margin-top: 30px;
        }
        .restriction-box p {
            color: var(--color-dark-text);
            margin: 8px 0;
            font-size: 14px;
        }
        .restriction-box strong {
            color: var(--color-dark-text);
            font-weight: 700;
        }

        /* Estilos del Botón General */
        .btn {
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.1s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
            width: 100%;
        }
        .btn:active {
            transform: scale(0.99);
        }

        /* Botón Guardar (Acción principal: Éxito) */
        .btn-save {
            background-color: var(--color-success-green) !important;
            color: white;
            box-shadow: 0 4px 10px rgba(46, 204, 113, 0.3);
        }
        .btn-save:hover {
            background-color: #27ae60 !important;
        }

        /* Botón Cancelar (Acción secundaria: Peligro/Advertencia) */
        .btn-cancel {
            background-color: var(--color-danger-red) !important; 
            color: white;
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3);
        }
        .btn-cancel:hover {
            background-color: #c0392b !important;
        }
        
        /* Contenedor de botones (Flex) */
        .btn-group {
            margin-top: 30px !important;
            display: flex;
            gap: 15px !important;
        }
        .btn-group > * {
            flex-grow: 1;
            text-decoration: none; /* Quitar subrayado al enlace de Cancelar */
        }
    </style>
</head>
<body>

    <div class="profile-container">
        
        <h2>Editar Mi Perfil</h2>
        
        @if ($errors->any())
            <div class="alert-box alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert-box alert-success">
                {{ session('success') }}
            </div>
        @endif
        
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
                    style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;"
                >
            </div>

            <div class="form-group">
                <label for="profile_photo">Cambiar Foto de Perfil (Max 5MB, JPG/PNG):</label>
                <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="@error('profile_photo') is-invalid @enderror">
                @error('profile_photo')
                    <span style="color: var(--color-danger-red); font-size: 0.8em; display: block; margin-top: 8px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="edit_name">Nombre Completo:</label>
                <input type="text" id="edit_name" name="name" value="{{ old('name', auth()->user()->nombre ?? '') }}" required>
            </div>
            
            <div class="form-group">
                <label for="edit_email">Email (Usado para Login):</label>
                <input type="email" id="edit_email" name="email" value="{{ old('email', auth()->user()->correo ?? '') }}" required>
            </div>
            
            <div class="restriction-box">
                <p style="font-weight: bold; margin-top: 0;">⚠️ Información NO Modificable por el Usuario</p>
                
                <p style="margin: 5px 0;">
                    <strong>Departamento Actual:</strong> <span style="font-style: italic;">{{ auth()->user()->departamento_nombre ?? 'No asignado' }}</span>
                </p>
                
                <p style="margin: 5px 0;">
                    <strong>Puesto Actual:</strong> <span style="font-style: italic;">{{ auth()->user()->rol_nombre ?? 'No asignado' }}</span>
                </p>
            </div>
            
            <div class="btn-group">
                <button type="submit" class="btn btn-save">
                    💾 Guardar Cambios
                </button>
                <a href="{{ route('usuario.profile') }}">
                    <button type="button" class="btn btn-cancel">
                        Cancelar
                    </button>
                </a>
            </div>
        </form>

    </div>

</body>
</html>