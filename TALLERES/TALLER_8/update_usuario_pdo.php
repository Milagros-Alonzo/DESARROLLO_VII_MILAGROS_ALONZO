<?php
// Configuración de conexión PDO
require_once "config_pdo.php";

// Actualizar usuario (PDO)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_usuario'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];

    try {
        $sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            echo "Usuario actualizado con éxito.<br>";
        } else {
            echo "ERROR: No se pudo actualizar el usuario.<br>";
        }
    } catch (PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }
}

?>
<!-- Formulario para Actualizar Usuario -->
<h2>Actualizar Usuario</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div>
        <label>ID del Usuario</label>
        <input type="number" name="id" required>
    </div>
    <div>
        <label>Nombre</label>
        <input type="text" name="nombre" required>
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" required>
    </div>
    <input type="submit" name="actualizar_usuario" value="Actualizar Usuario">
</form>
