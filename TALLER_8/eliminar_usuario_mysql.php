<?php
require_once "config_mysqli.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_usuario'])) {
    $id = $_POST['id'];
    
    $sql = "DELETE FROM usuarios WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "Usuario eliminado con éxito.<br>";
        } else {
            echo "ERROR: No se pudo eliminar el usuario. " . mysqli_error($conn);
        }
    }
    mysqli_stmt_close($stmt);
}

// Cerrar la conexión
mysqli_close($conn);
?>
<!-- Formulario para Eliminar Usuario -->
<h2>Eliminar Usuario</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>ID del Usuario</label><input type="number" name="id" required></div>
    <input type="submit" name="eliminar_usuario" value="Eliminar Usuario" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
</form>