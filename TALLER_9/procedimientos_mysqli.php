
<?php
require_once "config_mysqli.php";

// Función para registrar una venta
function registrarVenta($conn, $cliente_id, $producto_id, $cantidad) {
    $query = "CALL sp_registrar_venta(?, ?, ?, @venta_id)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $cliente_id, $producto_id, $cantidad);
    
    try {
        mysqli_stmt_execute($stmt);
        
        // Obtener el ID de la venta
        $result = mysqli_query($conn, "SELECT @venta_id as venta_id");
        $row = mysqli_fetch_assoc($result);
        
        echo "Venta registrada con éxito. ID de venta: " . $row['venta_id'];
    } catch (Exception $e) {
        echo "Error al registrar la venta: " . $e->getMessage();
    }
    
    mysqli_stmt_close($stmt);
}

// Función para obtener estadísticas de cliente
function obtenerEstadisticasCliente($conn, $cliente_id) {
    $query = "CALL sp_estadisticas_cliente(?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $estadisticas = mysqli_fetch_assoc($result);
        
        echo "<h3>Estadísticas del Cliente</h3>";
        echo "Nombre: " . $estadisticas['nombre'] . "<br>";
        echo "Membresía: " . $estadisticas['nivel_membresia'] . "<br>";
        echo "Total compras: " . $estadisticas['total_compras'] . "<br>";
        echo "Total gastado: $" . $estadisticas['total_gastado'] . "<br>";
        echo "Promedio de compra: $" . $estadisticas['promedio_compra'] . "<br>";
        echo "Últimos productos: " . $estadisticas['ultimos_productos'] . "<br>";
    }
    
    mysqli_stmt_close($stmt);
}
function procesarDevolucion($conn, $venta_id, $producto_id, $cantidad) {
    $query = "CALL sp_procesar_devolucion(?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $venta_id, $producto_id, $cantidad);

    if (mysqli_stmt_execute($stmt)) {
        echo "Devolución procesada correctamente.";
    } else {
        echo "Error al procesar la devolución: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
function aplicarDescuento($conn, $cliente_id, $venta_id) {
    $query = "CALL sp_aplicar_descuento(?, ?, @total_con_descuento)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $cliente_id, $venta_id);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_query($conn, "SELECT @total_con_descuento as total_con_descuento");
        $row = mysqli_fetch_assoc($result);
        echo "Total con descuento aplicado: $" . $row['total_con_descuento'];
    } else {
        echo "Error al aplicar el descuento: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
function reporteBajoStock($conn) {
    $query = "CALL sp_reporte_bajo_stock()";
    $result = mysqli_query($conn, $query);

    echo "<h3>Reporte de Productos con Bajo Stock</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Producto: " . $row['nombre'] . "<br>";
        echo "Stock actual: " . $row['stock'] . "<br>";
        echo "Cantidad a reponer: " . $row['cantidad_reponer'] . "<br><br>";
    }
}
function calcularComisiones($conn) {
    $query = "CALL sp_calcular_comisiones()";
    $result = mysqli_query($conn, $query);

    echo "<h3>Comisiones por Ventas</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "ID de Venta: " . $row['venta_id'] . "<br>";
        echo "Total de Venta: $" . $row['total'] . "<br>";
        echo "Comisión: $" . $row['comision'] . "<br><br>";
    }
}

// Ejemplos de uso
registrarVenta($conn, 1, 1, 2);
obtenerEstadisticasCliente($conn, 1);

mysqli_close($conn);
?>
        