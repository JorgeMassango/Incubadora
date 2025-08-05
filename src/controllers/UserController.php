<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    public static function register($name, $email, $password) {
        if (User::findByEmail($email)) {
            echo "Email já registrado!";
            return;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        if (User::create($name, $email, $hash)) {
            header("Location: index.php");
        } else {
            echo "Erro ao registrar.";
        }
    }

    public static function login($email, $password) {
        $user = User::findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['is_admin'] = $user['is_admin'];

            if ($user['is_admin']) {
                header("Location: admin.php");
            } else {
                header("Location: dashboard.php");
            }
        } else {
            echo "Email ou senha inválidos.";
        }
    }
}
