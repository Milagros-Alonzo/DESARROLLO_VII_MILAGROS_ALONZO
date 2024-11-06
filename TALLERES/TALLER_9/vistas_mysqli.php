<?php
require_once "config_mysqli.php";

function mostrarResumenCategorias($conn) {
   

    $sql = "SELECT * FROM vista_resumen_categorias";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Resumen por Categorías:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Categoría</th>
            <th>Total Productos</th>
            <th>Stock Total</th>
            <th>Precio Promedio</th>
            <th>Precio Mínimo</th>
            <th>Precio Máximo</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['categoria']}</td>";
        echo "<td>{$row['total_productos']}</td>";
        echo "<td>{$row['total_stock']}</td>";
        echo "<td>{$row['precio_promedio']}</td>";
        echo "<td>{$row['precio_minimo']}</td>";
        echo "<td>{$row['precio_maximo']}</td>";
        
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}

function mostrarProductosPopulares($conn) {
    $sql = "SELECT * FROM vista_productos_populares LIMIT 5";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Top 5 Productos Más Vendidos:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Producto</th>
            <th>Categoría</th>
            <th>Total Vendido</th>
            <th>Ingresos Totales</th>
            <th>Compradores Únicos</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['producto']}</td>";
        echo "<td>{$row['categoria']}</td>";
        echo "<td>{$row['total_vendido']}</td>";
        echo "<td>{$row['ingresos_totales']}</td>";
        echo "<td>{$row['compradores_unicos']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}
function mostrarProductosBajoStock($conn) {
    $sql = "SELECT * FROM vista_productos_bajo_stock";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Productos con Bajo Stock:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>Producto</th><th>Categoría</th><th>Stock</th><th>Total Vendido</th><th>Ingresos Totales</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>{$row['producto']}</td><td>{$row['categoria']}</td><td>{$row['stock']}</td><td>{$row['total_vendido']}</td><td>{$row['ingresos_totales']}</td></tr>";
    }
    echo "</table>";
}

function mostrarHistorialClientes($conn) {
    $sql = "SELECT * FROM vista_historial_clientes";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Historial de Compras de Clientes:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>Cliente</th><th>Email</th><th>Producto</th><th>Cantidad</th><th>Monto Total</th><th>Fecha Venta</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$row['cliente']}</td>
            <td>{$row['email']}</td>
            <td>{$row['producto']}</td>
            <td>{$row['cantidad']}</td>
            <td>{$row['monto_total']}</td>
            <td>{$row['fecha_venta']}</td>
        </tr>";
    }
    echo "</table>";
}

function mostrarRendimientoCategoria($conn) {
    $sql = "SELECT * FROM vista_rendimiento_categoria";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Rendimiento por Categoría:</h3>";
    echo "<table border='1'><tr><th>Categoría</th><th>Total Productos</th><th>Productos Vendidos</th><th>Ingresos Totales</th><th>Producto Más Vendido</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>{$row['categoria']}</td><td>{$row['total_productos']}</td><td>{$row['productos_vendidos']}</td><td>{$row['ingresos_totales']}</td><td>{$row['producto_mas_vendido']}</td></tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}

function mostrarTendenciasVentas($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM vista_tendencias_ventas");
        
        echo "<h3>Tendencias de Ventas Mensuales:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Mes</th><th>Ventas Totales</th><th>Comparativa Mes Anterior</th></tr>";
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['mes']}</td>";
            
            // Verificar que 'ventas_totales' esté definido y no sea null
            if (isset($row['ventas_totales']) && $row['ventas_totales'] !== null) {
                echo "<td>$" . number_format($row['ventas_totales'], 2) . "</td>";
            } else {
                echo "<td>No disponible</td>";
            }
            
            // Mostrar el cambio con respecto al mes anterior, si existe el campo
            if (isset($row['comparativa_mes_anterior']) && $row['comparativa_mes_anterior'] !== null) {
                $comparativa = $row['comparativa_mes_anterior'] >= 0 ? "+" : "";
                $comparativa .= number_format($row['comparativa_mes_anterior'], 2) . "%";
                echo "<td>{$comparativa}</td>";
            } else {
                echo "<td>No disponible</td>";
            }
            
            echo "</tr>";
        }
        
        echo "</table>";
    } catch (PDOException $e) {
        echo "Error al mostrar tendencias de ventas: " . $e->getMessage();
    }
}

    mysqli_free_result($result);


// Mostrar resultados
mostrarResumenCategorias($conn);
mostrarProductosPopulares($conn);
mostrarProductosBajoStock($conn);
mostrarHistorialClientes($conn);
mostrarRendimientoCategoria($conn);
mostrarTendenciasVentas($conn);



mysqli_close($conn);
?>