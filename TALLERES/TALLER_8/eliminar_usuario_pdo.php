<?php
// Configuración de conexión PDO
require_once "config_pdo.php";

// Eliminar usuario (PDO)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_usuario'])) {
    $id = $_POST['id'];

    try {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            echo "Usuario eliminado con éxito.<br>";
        } else {
            echo "ERROR: No se pudo eliminar el usuario.<br>";
        }
    } catch (PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }
}

// Cerrar la conexión PDO
$pdo = null;
?>


<!-- Formulario para Eliminar Usuario -->
<h2>Eliminar Usuario</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div>
        <label>ID del Usuario</label>
        <input type="number" name="id" required>
    </div>
    <input type="submit" name="eliminar_usuario" value="Eliminar Usuario" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
</form>