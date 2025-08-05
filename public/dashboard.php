<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once '../src/config/database.php';
$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

$stmt = $pdo->prepare("SELECT * FROM documents WHERE user_id = ?");
$stmt->execute([$userId]);
$documents = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Usuário</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #007bff;
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
            max-width: 800px;
            margin: auto;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            border-radius: 8px;
        }

        h2 {
            color: #007bff;
            margin-bottom: 10px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #e9ecef;
            margin-bottom: 10px;
            padding: 10px 15px;
            border-radius: 4px;
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
            font-weight: bold;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    <h1>Área do Usuário</h1>
    <div class="nav-links">
        <a href="upload.php">Enviar Documento</a>
        <a href="logout.php">Sair</a>
    </div>
</header>

<div class="container">
    <h2>Bem-vindo, <?= htmlspecialchars($user['name']) ?></h2>
    <p>Email: <?= htmlspecialchars($user['email']) ?></p>

    <h3>Seus Documentos</h3>
    <ul>
        <?php if (count($documents) > 0): ?>
            <?php foreach ($documents as $doc): ?>
                <li><?= basename($doc['file_path']) ?> - Enviado em: <?= $doc['uploaded_at'] ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Você ainda não enviou nenhum documento.</li>
        <?php endif; ?>
    </ul>
</div>

<footer>
    &copy; <?= date('Y') ?> Incubadora Digital. Todos os direitos reservados. |
    <a href="#">Política de Privacidade</a> |
    <a href="#">Contato</a>
</footer>

</body>
</html>
