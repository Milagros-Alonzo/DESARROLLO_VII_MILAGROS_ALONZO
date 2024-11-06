<?php
require_once 'config.php';

// Registrar nuevo usuario
function registrarUsuario($conn, $nombre, $email, $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $nombre, $email, $hash);
    mysqli_stmt_execute($stmt);
}

// Listar usuarios
function listarUsuarios($conn) {
    $sql = "SELECT * FROM usuarios";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "Nombre: " . $row['nombre'] . ", Email: " . $row['email'] . "<br>";
    }
}
?>
