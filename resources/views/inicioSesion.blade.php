<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Inicio de Sesión - Gestión de Tickets</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            /* Reset básico y tipografía */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                /* Fondo degradado del panel de soporte */
                background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px;
            }

            /* Contenedor principal de la tarjeta de login */
            .login-container {
                max-width: 450px;
                width: 100%;
                /* Color de fondo y bordes claros del panel */
                background-color: #fff5e6;
                padding: 40px;
                border-radius: 15px;
                border: 3px solid #fab1a0;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                animation: fadeIn 0.5s ease-out;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            /* Encabezado del formulario de login */
            .login-header {
                text-align: center;
                margin-bottom: 30px;
            }

            .logo-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                margin-bottom: 20px;
            }

            .logo-icon {
                /* Simulación del icono */
                font-size: 50px;
                color: #2d3436;
                margin-bottom: 10px;
            }
            .logo-icon::before {
                content: '🎟️'; /* Ícono de ticket para el login */
            }

            .login-header h1 {
                font-size: 24px;
                color: #2d3436;
                font-weight: 700;
                letter-spacing: 1px;
                border-bottom: 2px solid #fdcb6e;
                padding-bottom: 10px;
            }

            .login-header h2 {
                font-size: 20px;
                color: #2d3436;
                margin-top: 15px;
                margin-bottom: 10px;
            }

            .login-header p {
                color: #636e72;
                font-size: 14px;
            }

            /* Estilo del mensaje de error */
            .error-message {
                background-color: #f8d7da; /* Rojo claro para errores */
                color: #721c24;
                padding: 12px;
                margin-top: 20px;
                border-radius: 8px;
                border: 1px solid #f5c6cb;
                font-size: 14px;
                text-align: left;
            }

            /* Estilos del formulario y campos */
            .form-group {
                margin-bottom: 20px;
                position: relative;
            }

            .form-label {
                display: block;
                font-size: 14px;
                color: #2d3436;
                margin-bottom: 8px;
                font-weight: 600;
            }

            .input-container {
                position: relative;
            }

            .form-input {
                width: 100%;
                padding: 12px 15px;
                border: 2px solid #fdcb6e; /* Color principal del esquema */
                border-radius: 8px;
                font-size: 16px;
                color: #2d3436;
                outline: none;
                transition: border-color 0.3s, box-shadow 0.3s;
                background-color: white;
            }

            .form-input:focus {
                border-color: #0984e3; /* Color de enfoque azul */
                box-shadow: 0 0 0 3px rgba(9, 132, 227, 0.2);
            }

            /* Botón de alternar contraseña */
            .password-toggle {
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                cursor: pointer;
                font-size: 18px;
                padding: 5px;
            }

            /* Botón de Iniciar Sesión */
            .form-actions {
                margin-top: 30px;
            }

            .btn-login {
                width: 100%;
                /* Estilo similar al botón de "Ver" del panel */
                background-color: #0984e3; 
                color: white;
                border: none;
                padding: 15px 30px;
                border-radius: 8px;
                font-size: 18px;
                font-weight: 600;
                cursor: pointer;
                transition: background-color 0.3s, transform 0.1s;
                box-shadow: 0 4px 10px rgba(9, 132, 227, 0.3);
            }

            .btn-login:hover {
                background-color: #74b9ff; /* Color de hover similar al panel */
            }

            .btn-login:active {
                transform: scale(0.99);
            }
            
            /* Información adicional al pie */
            .login-info {
                margin-top: 25px;
                padding-top: 15px;
                border-top: 1px solid #ffeaa7; /* Borde de color del esquema */
                text-align: center;
            }
            
            .info-item {
                display: flex;
                align-items: center;
                justify-content: center;
                color: #636e72;
                font-size: 13px;
                margin-top: 10px;
            }
            
            .info-icon {
                margin-right: 8px;
                font-size: 16px;
            }
        </style>
    </head>
    <body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-container">
                    <div class="logo-icon"></div>
                    <h1>GESTIÓN DE TICKETS</h1>
                </div>
                <h2>Iniciar Sesión</h2>
                <p>Ingresa tus credenciales para acceder a tu cuenta</p>
                @if ($errors->any())
                    <div class="error-message">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
            </div>

            <form method="POST" action="{{ route('authenticate') }}" class="login-form">
                @csrf
                
                <div class="form-group">
                    <label for="usuario" class="form-label">
                        Email
                    </label>
                    <div class="input-container">
                        <input 
                            type="email" 
                            id="usuario" 
                            name="usuario" 
                            required 
                            class="form-input"
                            placeholder="tu@email.com"
                            autocomplete="username"
                            value="{{ old('usuario') }}"
                        >
                        </div>
                </div>

                <div class="form-group">
                    <label for="contrasena" class="form-label">
                        Contraseña
                    </label>
                    <div class="input-container">
                        <input 
                            type="password" 
                            id="contrasena" 
                            name="contrasena" 
                            required 
                            class="form-input"
                            placeholder="Contraseña"
                            autocomplete="current-password"
                            maxlength="50"
                            minlength="6"
                        >
                        <button 
                            type="button" 
                            class="password-toggle" 
                            onclick="togglePassword()"
                            aria-label="Mostrar/ocultar contraseña"
                        >
                            <span class="toggle-icon">👁️</span>
                        </button>
                        </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-login">
                        🔑 Iniciar Sesión
                    </button>
                </div>
            </form>

            <div class="login-info">
                <div class="info-item">
                    <span class="info-icon">🔐</span>
                    <span>Tus datos están protegidos y el sistema es seguro.</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para mostrar/ocultar la contraseña
        function togglePassword() {
            const passwordField = document.getElementById('contrasena');
            const toggleIcon = document.querySelector('.toggle-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.textContent = '🙈';
            } else{
                passwordField.type = 'password';
                toggleIcon.textContent = '👁️';
            }
        }
    </script>
    </body>
</html>