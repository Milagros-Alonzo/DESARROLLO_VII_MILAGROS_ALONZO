
<?php
require_once "config_pdo.php";

// Función para registrar una venta
function registrarVenta($pdo, $cliente_id, $producto_id, $cantidad) {
    try {
        $stmt = $pdo->prepare("CALL sp_registrar_venta(:cliente_id, :producto_id, :cantidad, @venta_id)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->execute();
        
        // Obtener el ID de la venta
        $result = $pdo->query("SELECT @venta_id as venta_id")->fetch(PDO::FETCH_ASSOC);
        
        echo "Venta registrada con éxito. ID de venta: " . $result['venta_id'];
    } catch (PDOException $e) {
        echo "Error al registrar la venta: " . $e->getMessage();
    }
}

// Función para obtener estadísticas de cliente
function obtenerEstadisticasCliente($pdo, $cliente_id) {
    try {
        $stmt = $pdo->prepare("CALL sp_estadisticas_cliente(:cliente_id)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $estadisticas = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Estadísticas del Cliente</h3>";
        echo "Nombre: " . $estadisticas['nombre'] . "<br>";
        echo "Membresía: " . $estadisticas['nivel_membresia'] . "<br>";
        echo "Total compras: " . $estadisticas['total_compras'] . "<br>";
        echo "Total gastado: $" . $estadisticas['total_gastado'] . "<br>";
        echo "Promedio de compra: $" . $estadisticas['promedio_compra'] . "<br>";
        echo "Últimos productos: " . $estadisticas['ultimos_productos'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
function procesarDevolucion($pdo, $venta_id, $producto_id, $cantidad) {
    try {
        $stmt = $pdo->prepare("CALL sp_procesar_devolucion(:venta_id, :producto_id, :cantidad)");
        $stmt->bindParam(':venta_id', $venta_id, PDO::PARAM_INT);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->execute();

        echo "Devolución procesada correctamente.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
function aplicarDescuento($pdo, $cliente_id, $venta_id) {
    try {
        $stmt = $pdo->prepare("CALL sp_aplicar_descuento(:cliente_id, :venta_id, @total_con_descuento)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->bindParam(':venta_id', $venta_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $pdo->query("SELECT @total_con_descuento as total_con_descuento")->fetch(PDO::FETCH_ASSOC);
        echo "Total con descuento aplicado: $" . $result['total_con_descuento'];
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
function reporteBajoStock($pdo) {
    try {
        $stmt = $pdo->query("CALL sp_reporte_bajo_stock()");
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h3>Reporte de Productos con Bajo Stock</h3>";
        foreach ($productos as $row) {
            echo "Producto: " . $row['nombre'] . "<br>";
            echo "Stock actual: " . $row['stock'] . "<br>";
            echo "Cantidad a reponer: " . $row['cantidad_reponer'] . "<br><br>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
function calcularComisiones($pdo) {
    try {
        $stmt = $pdo->query("CALL sp_calcular_comisiones()");
        $comisiones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h3>Comisiones por Ventas</h3>";
        foreach ($comisiones as $row) {
            echo "ID de Venta: " . $row['venta_id'] . "<br>";
            echo "Total de Venta: $" . $row['total'] . "<br>";
            echo "Comisión: $" . $row['comision'] . "<br><br>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Ejemplos de uso
registrarVenta($pdo, 1, 1, 2);
obtenerEstadisticasCliente($pdo, 1);

$pdo = null;
?>
        