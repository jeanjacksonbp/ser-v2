<?php
// Não exige guard; é página pública
?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login — SER - Sistema de Excelência em Resultados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 0;
            margin: 0;
        }
        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
        }
        
        /* Mobile First - Ocupar mais espaço no mobile */
        @media (max-width: 576px) {
            .login-container {
                max-width: none;
                width: calc(100% - 30px);
                margin: 15px;
                border-radius: 15px;
                min-height: auto;
            }
            
            body {
                padding: 15px 0;
            }
        }
        
        /* Tablet */
        @media (min-width: 577px) and (max-width: 768px) {
            .login-container {
                max-width: 480px;
                width: 90%;
            }
        }
        
        /* Desktop */
        @media (min-width: 769px) {
            .login-container {
                max-width: 500px;
                width: 100%;
            }
        }
        .login-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
        }
        .login-header .logo {
            width: 90px;
            height: 90px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.2rem;
            font-weight: bold;
        }
        .login-body {
            padding: 2.5rem;
        }
        
        @media (max-width: 576px) {
            .login-header {
                padding: 2rem 1.5rem;
            }
            .login-header .logo {
                width: 70px;
                height: 70px;
                font-size: 1.8rem;
                margin-bottom: 1rem;
            }
            .login-body {
                padding: 2rem 1.5rem;
            }
        }
        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 14px 16px;
            font-size: 16px;
            transition: all 0.3s ease;
            height: auto;
        }
        
        @media (max-width: 576px) {
            .form-control {
                padding: 12px 14px;
                font-size: 16px; /* Importante: 16px evita zoom no iOS */
            }
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border: none;
            border-radius: 10px;
            padding: 14px 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            font-size: 16px;
            min-height: 50px;
        }
        
        @media (max-width: 576px) {
            .btn-login {
                padding: 12px 16px;
                min-height: 48px;
                font-size: 15px;
            }
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }
        .alert-custom {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #dc2626;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 1rem;
        }
        .forgot-password {
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }
        .forgot-password:hover {
            color: #3b82f6;
        }
        .input-group-text {
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        .form-control.with-icon {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid px-3">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="login-container">
                    <div class="login-header">
                        <div class="logo">
                            <i class="fa fa-chart-line"></i>
                        </div>
                        <h2 class="mb-1">SER</h2>
                        <p class="mb-0 opacity-75">Sistema de Excelência em Resultados</p>
                    </div>
                    
                    <div class="login-body">
                        <h4 class="text-center mb-1 text-dark">Bem-vindo de volta!</h4>
                        <p class="text-center text-muted mb-4">Faça login para acessar sua conta</p>

                        <?php if (!empty($_GET['err'])): ?>
                            <div class="alert-custom">
                                <i class="fa fa-exclamation-triangle me-2"></i>
                                <?= htmlspecialchars($_GET['err']) ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="<?= url('login') ?>">
                            <div class="mb-3">
                                <label for="email" class="form-label text-dark fw-semibold">
                                    <i class="fa fa-envelope me-1"></i> E-mail
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-user text-muted"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control with-icon" 
                                           id="email" 
                                           name="email" 
                                           placeholder="seu@email.com"
                                           required 
                                           autofocus>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="senha" class="form-label text-dark fw-semibold">
                                    <i class="fa fa-lock me-1"></i> Senha
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-key text-muted"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control with-icon" 
                                           id="senha" 
                                           name="senha" 
                                           placeholder="Digite sua senha"
                                           required>
                                </div>
                            </div>
                            
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-login">
                                    <i class="fa fa-sign-in-alt me-2"></i>
                                    Entrar
                                </button>
                            </div>
                            
                            <div class="text-center">
                                <a href="#" class="forgot-password">
                                    <i class="fa fa-question-circle me-1"></i>
                                    Esqueci minha senha
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Animação de entrada -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.login-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                container.style.transition = 'all 0.6s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>

