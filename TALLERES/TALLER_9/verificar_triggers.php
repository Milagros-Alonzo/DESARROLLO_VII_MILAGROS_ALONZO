<?php
require_once "config_pdo.php"; // O usar mysqli según prefieras

function verificarCambiosPrecio($pdo, $producto_id, $nuevo_precio) {
    try {
        // Actualizar precio
        $stmt = $pdo->prepare("UPDATE productos SET precio = ? WHERE id = ?");
        $stmt->execute([$nuevo_precio, $producto_id]);
        
        // Verificar log de cambios
        $stmt = $pdo->prepare("SELECT * FROM historial_precios WHERE producto_id = ? ORDER BY fecha_cambio DESC LIMIT 1");
        $stmt->execute([$producto_id]);
        $log = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Cambio de Precio Registrado:</h3>";
        echo "Precio anterior: $" . $log['precio_anterior'] . "<br>";
        echo "Precio nuevo: $" . $log['precio_nuevo'] . "<br>";
        echo "Fecha del cambio: " . $log['fecha_cambio'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function verificarMovimientoInventario($pdo, $producto_id, $nueva_cantidad) {
    try {
        // Actualizar stock
        $stmt = $pdo->prepare("UPDATE productos SET stock = ? WHERE id = ?");
        $stmt->execute([$nueva_cantidad, $producto_id]);
        
        // Verificar movimientos de inventario
        $stmt = $pdo->prepare("
            SELECT * FROM movimientos_inventario 
            WHERE producto_id = ? 
            ORDER BY fecha_movimiento DESC LIMIT 1
        ");
        $stmt->execute([$producto_id]);
        $movimiento = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Movimiento de Inventario Registrado:</h3>";
        echo "Tipo de movimiento: " . $movimiento['tipo_movimiento'] . "<br>";
        echo "Cantidad: " . $movimiento['cantidad'] . "<br>";
        echo "Stock anterior: " . $movimiento['stock_anterior'] . "<br>";
        echo "Stock nuevo: " . $movimiento['stock_nuevo'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
function verificarMembresia($pdo, $cliente_id) {
    $stmt = $pdo->prepare("SELECT nivel_membresia FROM clientes WHERE id = ?");
    $stmt->execute([$cliente_id]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<h3>Nivel de Membresía Actualizado:</h3>";
    echo "Nivel de membresía: " . $cliente['nivel_membresia'] . "<br>";
}
function verificarEstadisticasVentas($pdo, $categoria_id) {
    $stmt = $pdo->prepare("SELECT total_ventas FROM estadisticas_categorias WHERE categoria_id = ?");
    $stmt->execute([$categoria_id]);
    $estadistica = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<h3>Estadísticas de Ventas por Categoría:</h3>";
    echo "Total de ventas: $" . $estadistica['total_ventas'] . "<br>";
}
function verificarAlertasStock($pdo, $producto_id) {
    $stmt = $pdo->prepare("SELECT mensaje, fecha_alerta FROM alertas_stock WHERE producto_id = ? ORDER BY fecha_alerta DESC LIMIT 1");
    $stmt->execute([$producto_id]);
    $alerta = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($alerta) {
        echo "<h3>Alerta de Stock Crítico:</h3>";
        echo "Mensaje: " . $alerta['mensaje'] . "<br>";
        echo "Fecha de alerta: " . $alerta['fecha_alerta'] . "<br>";
    } else {
        echo "<h3>No hay alertas de stock crítico para este producto.</h3>";
    }
}
function verificarHistorialEstadoCliente($pdo, $cliente_id) {
    $stmt = $pdo->prepare("SELECT estado_anterior, estado_nuevo, fecha_cambio FROM historial_estado_clientes WHERE cliente_id = ? ORDER BY fecha_cambio DESC LIMIT 1");
    $stmt->execute([$cliente_id]);
    $historial = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<h3>Historial de Estado del Cliente:</h3>";
    echo "Estado anterior: " . $historial['estado_anterior'] . "<br>";
    echo "Estado nuevo: " . $historial['estado_nuevo'] . "<br>";
    echo "Fecha de cambio: " . $historial['fecha_cambio'] . "<br>";
}

// Probar los triggersg
verificarCambiosPrecio($pdo, 1, 999.99);
verificarMovimientoInventario($pdo, 1, 15);
verificarMembresia($pdo, $cliente_id);
verificarEstadisticasVentas($pdo, $categoria_id);
verificarAlertasStock($pdo, $producto_id);
verificarHistorialEstadoCliente($pdo, $cliente_id);
$pdo = null;
?>
        
