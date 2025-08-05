<?php
require_once __DIR__ . '/../src/controllers/UserController.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $redirectPage = ($_SESSION['role'] === 'admin') ? 'admin_dashboard.php' : 'dashboard.php';
    header("Location: $redirectPage");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    UserController::register($_POST['name'], $_POST['email'], $_POST['password']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Cadastro - Sistema</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #219150;
        }
        .login-link {
            text-align: center;
            margin-top: 1rem;
        }
        .login-link a {
            color: #27ae60;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Cadastro</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Nome completo" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Senha" required />
        <button type="submit">Registrar</button>
    </form>
    <div class="login-link">
        <p>Já tem conta? <a href="index.php">Entrar</a></p>
    </div>
</div>

</body>
</html>
