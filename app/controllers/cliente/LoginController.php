<?php
require_once '../../models/LoginModel.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método inválido.");
    }

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        throw new Exception("Email e senha são obrigatórios.");
    }

    $user = User::authenticate($email, $password);
    if ($user) {
        session_start();
        $_SESSION['user'] = $user['email'];
        echo json_encode(['success' => true]);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Email ou senha incorretos']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
