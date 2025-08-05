<?php
session_start();
require_once '../src/config/database.php';
require_once '../src/models/Documents.php';

if (!isset($_SESSION['user_id'])) {
    die("Acesso negado. Faça login para continuar.");
}

$userId = $_SESSION['user_id'];
$uploadSuccess = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
    $file = $_FILES['document'];

    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
    $maxSize = 25 * 1024 * 1024; 

    if ($file['error'] === 0) {
        if (!in_array($file['type'], $allowedTypes)) {
            $error = 'Tipo de arquivo inválido. Envie PDF, JPG ou PNG.';
        } elseif ($file['size'] > $maxSize) {
            $error = 'O arquivo excede o tamanho máximo de 5MB.';
        } else {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $uniqueName = uniqid('doc_', true) . '.' . $ext;
            $uploadDir = '../uploads/';
            $targetPath = $uploadDir . $uniqueName;

            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                $originalName = $file['name'];
                $relativePath = 'uploads/' . $uniqueName; 

                if (Document::save($pdo, $userId, $relativePath, $originalName)) {
                    $uploadSuccess = 'Documento enviado com sucesso!';
                } else {
                    $error = 'Erro ao salvar no banco de dados.';
                }
            } else {
                $error = 'Erro ao mover o arquivo.';
            }
        }
    } else {
        $error = 'Erro no envio do arquivo.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Upload de Documento</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .upload-container {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            margin-top: 0;
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
            color: #444;
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #005bb5;
        }

        .message {
            margin-top: 15px;
            text-align: center;
            font-weight: bold;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #0066cc;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="upload-container">
        <h2>Enviar Documento</h2>

        <?php if ($uploadSuccess): ?>
            <div class="message success"><?= htmlspecialchars($uploadSuccess) ?></div>
        <?php elseif ($error): ?>
            <div class="message error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <label for="document">Escolha um arquivo (PDF, JPG, PNG):</label>
            <input type="file" name="document" id="document" required>

            <button type="submit">Enviar</button>
        </form>

        <div class="back-link">
            <a href="dashboard.php">Voltar ao Painel</a>
        </div>
    </div>
</body>
</html>

