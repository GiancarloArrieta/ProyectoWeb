<!DOCTYPE html>
<html>
    <head>
        <title>Inicio de Sesion</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <div class="error-message" style="display: block; background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
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
                        <span class="input-focus-border"></span>
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
                        <span class="input-focus-border"></span>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-login">
                        Iniciar Sesión
                    </button>
                </div>
            </form>

            <div class="login-info">
                <div class="info-item">
                    <span class="info-icon">🔐</span>
                    <span>Tus datos están protegidos</span>
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