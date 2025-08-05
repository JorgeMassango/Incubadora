<?php
require_once '../includes/auth_check.php'; 
require_once '../includes/db.php';

$uploadSuccess = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user']['id'];
    $file = $_FILES['document'];

    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
    $maxSize = 5 * 1024 * 1024; 

    if ($file['error'] === 0) {
        if (in_array($file['type'], $allowedTypes)) {
            if ($file['size'] <= $maxSize) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid('doc_', true) . '.' . $ext;
                $uploadPath = '../uploads/' . $filename;

                if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    
                    $stmt = $pdo->prepare("INSERT INTO documents (user_id, filename, original_name, uploaded_at, status) VALUES (?, ?, ?, NOW(), 'em análise')");
                    $stmt->execute([$userId, $filename, $file['name']]);
                    $uploadSuccess = 'Documento enviado com sucesso!';
                } else {
                    $error = 'Erro ao mover o arquivo.';
                }
            } else {
                $error = 'O arquivo excede o tamanho máximo de 5MB.';
            }
        } else {
            $error = 'Tipo de arquivo não permitido. Envie PDF ou imagem.';
        }
    } else {
        $error = 'Erro no envio do arquivo.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload de Documentos</title>
</head>
<body>
    <h2>Enviar Documento</h2>

    <?php if ($uploadSuccess): ?>
        <p style="color:green"><?= $uploadSuccess ?></p>
    <?php elseif ($error): ?>
        <p style="color:red"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="document" required>
        <button type="submit">Enviar</button>
    </form>

    <br>
    <a href="dashboard.php">Voltar ao painel</a>
</body>
</html>
