<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Allinkay</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #14a5b5;
            --primary-light: #5ec8d4;
            --primary-dark: rgba(14, 126, 138, 1);
            --secondary: #f8f9fa;
            --accent: #ff6b6b;
            --success: #28a745;
            --dark: #343a40;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 50%, var(--primary-dark) 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            padding: 20px;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
            position: relative;
            z-index: 10;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo-placeholder {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(20, 165, 181, 0.3);
            animation: pulse 2s infinite;
        }
        
        .logo-placeholder i {
            font-size: 2.5rem;
            color: white;
        }
        
        .company-name {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-dark);
            letter-spacing: 1px;
        }
        
        .company-tagline {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h3 {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        .form-floating {
            margin-bottom: 1.5rem;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 1rem 0.75rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(20, 165, 181, 0.25);
        }
        
        .form-floating label {
            padding: 1rem 0.75rem;
            color: #6c757d;
        }
        
        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 5;
        }
        
        .btn-login {
            background: linear-gradient(to right, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(20, 165, 181, 0.4);
        }
        
        .btn-login:hover {
            background: linear-gradient(to right, var(--primary-dark) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(20, 165, 181, 0.5);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .animated-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
        }
        
        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .shape-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation: float 15s infinite ease-in-out;
        }
        
        .shape-2 {
            width: 200px;
            height: 200px;
            bottom: -50px;
            right: -50px;
            animation: float 12s infinite ease-in-out reverse;
        }
        
        .shape-3 {
            width: 150px;
            height: 150px;
            top: 50%;
            left: 70%;
            animation: float 10s infinite ease-in-out;
        }
        
        .shape-4 {
            width: 100px;
            height: 100px;
            bottom: 30%;
            left: 10%;
            animation: float 8s infinite ease-in-out reverse;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            padding: 12px 15px;
            margin-bottom: 1.5rem;
            animation: shake 0.5s ease-in-out;
        }
        
        .alert-danger {
            background-color: #ffdfdf;
            color: #dc3545;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.15);
        }
        
        .password-toggle {
            cursor: pointer;
            transition: color 0.3s ease;
        }
        
        .password-toggle:hover {
            color: var(--primary);
        }
        
        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            25% {
                transform: translate(10px, 10px) rotate(5deg);
            }
            50% {
                transform: translate(0, 20px) rotate(0deg);
            }
            75% {
                transform: translate(-10px, 10px) rotate(-5deg);
            }
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(20, 165, 181, 0.4);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(20, 165, 181, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(20, 165, 181, 0);
            }
        }
        
        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            10%, 30%, 50%, 70%, 90% {
                transform: translateX(-5px);
            }
            20%, 40%, 60%, 80% {
                transform: translateX(5px);
            }
        }
        
        @media (max-width: 576px) {
            .login-card {
                padding: 2rem 1.5rem;
            }
            
            .logo-placeholder {
                width: 80px;
                height: 80px;
            }
            
            .logo-placeholder i {
                font-size: 2rem;
            }
            
            .company-name {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="animated-bg">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>
    
    <div class="login-container">
        <div class="login-card">
            <div class="logo-container">
                <div class="logo-placeholder">
                    <i class="fas fa-plane"></i> <!-- Puedes reemplazar con tu logo -->
                </div>
                <h1 class="company-name">Expediciones Allinkay</h1>
                <h5 class="company-tagline">Ines Travel</h5>
                <p class="company-tagline">Viajes y Experiencias Únicas</p>
            </div>
            
            <div class="login-header">
                <h3>Iniciar Sesión</h3>
                <p>Ingresa a tu cuenta para continuar</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-floating">
                    <input type="email" name="correo" id="correo" class="form-control" placeholder="nombre@ejemplo.com" required>
                    <label for="correo"><i class="fas fa-envelope me-2"></i>Correo Electrónico</label>
                    <span class="input-icon"><i class="fas fa-envelope"></i></span>
                </div>

                <div class="form-floating position-relative">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
                    <label for="password"><i class="fas fa-lock me-2"></i>Contraseña</label>
                    <span class="input-icon password-toggle" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Ingresar
                    </button>
                </div>
                
                <div class="text-center mt-3">
                    <a href="#" class="text-decoration-none" style="color: var(--primary);">¿Olvidaste tu contraseña?</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mostrar/ocultar contraseña
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
            
            // Efecto de entrada para el formulario
            const loginCard = document.querySelector('.login-card');
            loginCard.style.opacity = '0';
            loginCard.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                loginCard.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                loginCard.style.opacity = '1';
                loginCard.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>