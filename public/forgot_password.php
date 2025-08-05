<?php
require_once __DIR__ . '/../src/controllers/UserController.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    // Aqui você deve implementar a lógica para enviar um e-mail de redefinição de senha
    // Exemplo: UserController::sendPasswordResetEmail($email);
    // Após enviar o e-mail, você pode redirecionar ou mostrar uma mensagem de sucesso
    $successMessage = "Instruções para redefinir sua senha foram enviadas para $email.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Esqueci a Senha - Sistema</title>
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

        input[type="email"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        .message {
            text-align: center;
            margin-top: 1rem;
            color: green;
        }

        .back-link {
            text-align: center;
            margin-top: 1rem;
        }

        .back-link a {
            color: #3498db;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Esqueci a Senha</h2>
    <?php if (isset($successMessage)): ?>
        <div class="message">
            <p><?php echo $successMessage; ?></p>
        </div>
    <?php endif; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Digite seu e-mail" required>
        <button type="submit">Enviar Instruções</button>
    </form>
    <div class="back-link">
        <p><a href="login.php">Voltar para o Login</a></p>
    </div>
</div>

</body>
</html>
