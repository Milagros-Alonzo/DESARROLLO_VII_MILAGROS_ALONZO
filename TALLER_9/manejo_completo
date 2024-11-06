
<?php
require_once "config_pdo.php";

class ComplexTransactionManager {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function procesarVentaCompleja($cliente_id, $items) {
        try {
            $this->pdo->beginTransaction();
            
            // Crear la venta
            $stmt = $this->pdo->prepare("INSERT INTO ventas (cliente_id, total) VALUES (?, 0)");
            $stmt->execute([$cliente_id]);
            $venta_id = $this->pdo->lastInsertId();
            
            // Punto de guardado después de crear la venta
            $this->pdo->exec("SAVEPOINT venta_creada");
            
            $total_venta = 0;
            $items_procesados = 0;
            
            foreach ($items as $item) {
                try {
                    // Verificar stock
                    $stmt = $this->pdo->prepare("
                        SELECT stock, precio 
                        FROM productos 
                        WHERE id = ? 
                        FOR UPDATE
                    ");
                    $stmt->execute([$item['producto_id']]);
                    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($producto['stock'] < $item['cantidad']) {
                        throw new Exception("Stock insuficiente para producto {$item['producto_id']}");
                    }
                    
                    // Crear punto de guardado antes de procesar cada item
                    $this->pdo->exec("SAVEPOINT item_" . $items_procesados);
                    
                    // Actualizar stock
                    $stmt = $this->pdo->prepare("
                        UPDATE productos 
                        SET stock = stock - ? 
                        WHERE id = ?
                    ");
                    $stmt->execute([$item['cantidad'], $item['producto_id']]);
                    
                    // Registrar detalle de venta
                    $subtotal = $producto['precio'] * $item['cantidad'];
                    $stmt = $this->pdo->prepare("
                        INSERT INTO detalles_venta 
                        (venta_id, producto_id, cantidad, precio_unitario, subtotal) 
                        VALUES (?, ?, ?, ?, ?)
                    ");
                    $stmt->execute([
                        $venta_id,
                        $item['producto_id'],
                        $item['cantidad'],
                        $producto['precio'],
                        $subtotal
                    ]);
                    
                    $total_venta += $subtotal;
                    $items_procesados++;
                    
                } catch (Exception $e) {
                    // Revertir al último punto de guardado exitoso
                    $this->pdo->exec("ROLLBACK TO SAVEPOINT item_" . ($items_procesados - 1));
                    echo "Error procesando item: " . $e->getMessage() . "<br>";
                    continue;
                }
            }
            
            // Actualizar el total de la venta
            $stmt = $this->pdo->prepare("UPDATE ventas SET total = ? WHERE id = ?");
            $stmt->execute([$total_venta, $venta_id]);
            
            // Confirmar la transacción
            $this->pdo->commit();
            echo "Venta procesada exitosamente<br>";
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo "Error en la transacción: " . $e->getMessage();
        }
    }
}

// Ejemplo de uso
$ctm = new ComplexTransactionManager($pdo);

$items = [
    ['producto_id' => 1, 'cantidad' => 2],
    ['producto_id' => 2, 'cantidad' => 1],
    ['producto_id' => 3, 'cantidad' => 3]
];

$ctm->procesarVentaCompleja(1, $items);
?>