<?php
require_once 'config.php';

// Registrar nuevo usuario
function registrarUsuario($pdo, $nombre, $email, $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':password' => $hash
    ]);
}

// Listar usuarios
function listarUsuarios($pdo) {
    $sql = "SELECT * FROM usuarios";
    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Nombre: " . $row['nombre'] . ", Email: " . $row['email'] . "<br>";
    }
}
?>
