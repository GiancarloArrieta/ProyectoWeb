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
                <div id="error-alert" class="error-message" style="display: none;"></div>
            </div>

            <form onsubmit="return handleLogin(event)" class="login-form">
                
                <div class="form-group">
                    <label for="usuario" class="form-label">
                        Usuario
                    </label>
                    <div class="input-container">
                        <input 
                            type="text" 
                            id="usuario" 
                            name="usuario" 
                            required 
                            class="form-input"
                            placeholder="Ingresa tu nombre de usuario"
                            autocomplete="username"
                            maxlength="30"
                            pattern="[a-zA-Z0-9_]+"
                            title="Solo letras, números y guiones bajos"
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
                            placeholder="Ingresa tu contraseña"
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
                toggleIcon.textContent = '🙈'; // Cambia el icono a ojo tachado
            } else {
                passwordField.type = 'password';
                toggleIcon.textContent = '👁️'; // Cambia el icono a ojo abierto
            }
        }

        // FUNCIÓN PRINCIPAL PARA MANEJAR LA LÓGICA DE INICIO DE SESIÓN LOCAL
        function handleLogin(event) {
            // 1. Previene el envío del formulario a la ruta del action
            event.preventDefault();

            // 2. Obtiene los valores ingresados (los convertimos a mayúsculas para hacer la verificación insensible a mayúsculas/minúsculas)
            const usuario = document.getElementById('usuario').value.toUpperCase().trim();
            const contrasena = document.getElementById('contrasena').value.trim();
            const errorAlert = document.getElementById('error-alert');

            // 3. Define las credenciales codificadas
            const credenciales = {
                ADMIN: 'ADMIN123',
                GIANCARLO: 'GIANCARLO1'
            };

            // 4. Lógica de verificación
            errorAlert.style.display = 'none'; // Oculta errores anteriores
            errorAlert.textContent = '';

            if (credenciales.hasOwnProperty(usuario) && credenciales[usuario] === contrasena) {
                // Credenciales correctas
                if (usuario === 'ADMIN') {
                    // Redirigir al Dashboard de Admin
                    window.location.href = 'dashboard_admin.html';
                } else if (usuario === 'GIANCARLO') {
                    // Redirigir al Dashboard de Usuario (Requisito)
                    window.location.href = 'interfazUsuario.html';
                }
            } else {
                // Credenciales incorrectas
                errorAlert.textContent = '⚠️ Usuario o Contraseña incorrectos.';
                errorAlert.style.display = 'block';
            }

            // Siempre devuelve false para mantener el control con JavaScript
            return false;
        }
    </script>
    </body>
</html>