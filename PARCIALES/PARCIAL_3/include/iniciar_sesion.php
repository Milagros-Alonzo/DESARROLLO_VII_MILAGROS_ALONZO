<?php
session_start();
include 'data.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // validar user debe tener almenos 3 caracter (solo numero y letras)

    if (strlen($username) < 3 || !ctype_alnum($username)) {
        $errors[] = "El nombre de usuario debe tener al menos 3 caracters y solo puede contener letras y números.";
    }
    //validar que la contracena debe tener almenos 5 caracter
    if (strlen($password) < 5) {
        $errors[] = "La contraseña debe tener al menos 5 caracteres.";
    }

    // Verificar credenciales
    if (empty($errors)) {
        foreach ($usuarios as $user) {
            if ($user['username'] === $username && $user['password'] === $password) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user['role'];
                header('Location: dashboard.php');
                exit();
            }
        }
        $errors[] = "Credenciales incorrectas.";
    }
}
?>
