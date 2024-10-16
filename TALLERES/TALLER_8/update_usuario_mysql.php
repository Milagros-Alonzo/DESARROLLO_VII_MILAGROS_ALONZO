<?php
require_once "config_mysqli.php";
// Actualizar usuario (MySQLi)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_usuario'])) {
    $id = $_POST['id'];
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    $sql = "UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssi", $nombre, $email, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Usuario actualizado con éxito.<br>";
        } else {
            echo "ERROR: No se pudo actualizar el usuario. " . mysqli_error($conn);
        }
    }
    mysqli_stmt_close($stmt);
}
?>
<hr>

<!-- Formulario para Actualizar Usuario -->
<h2>Actualizar Usuario</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>ID del Usuario</label><input type="number" name="id" required></div>
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Email</label><input type="email" name="email" required></div>
    <input type="submit" name="actualizar_usuario" value="Actualizar Usuario">
</form>

<hr>