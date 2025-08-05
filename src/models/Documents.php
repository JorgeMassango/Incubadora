<?php

class Document
{
    public static function save($db, $userId, $filePath)
    {
        $stmt = $db->prepare("INSERT INTO documents (user_id, file_path, uploaded_at) VALUES (?, ?, NOW())");
        return $stmt->execute([$userId, $filePath]);
    }
}

