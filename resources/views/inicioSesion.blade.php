<!DOCTYPE html>
<html>
    <head>
        <title>Vista 1</title>
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
            </div>

            <form method="POST" action="/iniciosesion" class="login-form">
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

            <div class="login-footer">
                <button type="button" class="btn-back" onclick="location.href='/menuinicial'">
                    <span class="btn-icon">←</span>
                    Regresar al Menú
                </button>
            </div>

            <div class="login-info">
                <div class="info-item">
                    <span class="info-icon">🔐</span>
                    <span>Tus datos están protegidos</span>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>