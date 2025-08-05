<?php
session_start();

// Verifica se o usuário está autenticado e é admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$userName = htmlspecialchars($_SESSION['user_name']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        header, footer {
            background: #333;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }

        .container {
            padding: 2rem;
            max-width: 900px;
            margin: auto;
            background-color: #fff;
            margin-top: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }

        h1 {
            color: #444;
        }

        .logout {
            margin-top: 20px;
            display: inline-block;
            background-color: #c0392b;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        .logout:hover {
            background-color: #e74c3c;
        }
    </style>
</head>
<body>
    <header>
        <h2>Painel Administrativo</h2>
    </header>

    <div class="container">
        <h1>Bem-vindo, <?= $userName ?> (Admin)</h1>
        <p>Use o menu acima ou os botões abaixo para gerenciar os dados da aplicação.</p>

        <a href="admin_documents.php">📄 Gerenciar Documentos</a><br><br>
        <a class="logout" href="logout.php">Sair</a>
    </div>

    <footer>
        &copy; <?= date('Y') ?> Sistema de Documentos - Todos os direitos reservados.
    </footer>
</body>
</html>
