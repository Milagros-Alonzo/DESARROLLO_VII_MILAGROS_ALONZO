<?php
require_once 'config.php';

// Registrar un préstamo
function registrarPrestamo($pdo, $usuario_id, $libro_id) {
    try {
        $pdo->beginTransaction();

        $sql = "INSERT INTO prestamos (usuario_id, libro_id, fecha_prestamo) VALUES (:usuario_id, :libro_id, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id, ':libro_id' => $libro_id]);

        $sql = "UPDATE libros SET cantidad = cantidad - 1 WHERE id = :libro_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':libro_id' => $libro_id]);

        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}
?>
