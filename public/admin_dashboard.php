<?php
session_start();
require_once '../src/config/database.php';

// Verificação simples de autenticação e permissão de admin (ajuste conforme necessário)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// Buscar todos os usuários
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();

// Buscar todos os documentos com nome do usuário
$stmt = $pdo->query("
    SELECT d.*, u.name AS user_name, u.email AS user_email 
    FROM documents d
    INNER JOIN users u ON d.user_id = u.id
    ORDER BY d.uploaded_at DESC
");
$documents = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #343a40;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        .nav-links a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            padding: 40px;
            max-width: 1000px;
            margin: auto;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            border-radius: 8px;
        }

        h2 {
            color: #343a40;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        footer {
            background-color: #343a40;
            color: #ccc;
            text-align: center;
            padding: 15px;
            margin-top: 40px;
        }

        footer a {
            color: #ccc;
            text-decoration: none;
        }
    </style>
</head>
<body>

<header>
    <h1>Painel do Administrador</h1>
    <div class="nav-links">
        <a href="logout.php">Sair</a>
    </div>
</header>

<div class="container">
    <h2>Usuários Registrados</h2>
    <table>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Data de Registro</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= $user['created_at'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2 style="margin-top: 50px;">Documentos Enviados</h2>
    <table>
        <tr>
            <th>Usuário</th>
            <th>Email</th>
            <th>Documento</th>
            <th>Data de Envio</th>
        </tr>
        <?php foreach ($documents as $doc): ?>
            <tr>
                <td><?= htmlspecialchars($doc['user_name']) ?></td>
                <td><?= htmlspecialchars($doc['user_email']) ?></td>
                <td><?= basename($doc['file_path']) ?></td>
                <td><?= $doc['uploaded_at'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<footer>
    &copy; <?= date('Y') ?> Incubadora Digital. Todos os direitos reservados.
</footer>

</body>
</html>
