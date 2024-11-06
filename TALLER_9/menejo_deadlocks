
<?php
require_once "config_pdo.php";

class DeadlockManager {
    private $pdo;
    private $maxRetries = 3;
    private $retryDelay = 1; // segundos
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function executeWithDeadlockRetry(callable $operation) {
        $attempts = 0;
        
        while ($attempts < $this->maxRetries) {
            try {
                $this->pdo->beginTransaction();
                
                $result = $operation($this->pdo);
                
                $this->pdo->commit();
                return $result;
                
            } catch (PDOException $e) {
                $this->pdo->rollBack();
                
                // Verificar si es un deadlock
                if ($this->isDeadlock($e) && $attempts < $this->maxRetries - 1) {
                    $attempts++;
                    echo "Deadlock detectado, reintentando (intento $attempts)...<br>";
                    sleep($this->retryDelay);
                    continue;
                }
                
                throw $e;
            }
        }
    }
    
    private function isDeadlock(PDOException $e) {
        // Código de error MySQL para deadlock
        return $e->errorInfo[1] === 1213;
    }
    
    public function transferirStock($origen_id, $destino_id, $cantidad) {
        return $this->executeWithDeadlockRetry(function($pdo) use ($origen_id, $destino_id, $cantidad) {
            // Obtener los IDs en orden para prevenir deadlocks
            $ids = [$origen_id, $destino_id];
            sort($ids);
            
            // Bloquear las filas en un orden específico
            foreach ($ids as $id) {
                $stmt = $pdo->prepare("
                    SELECT stock 
                    FROM productos 
                    WHERE id = ? 
                    FOR UPDATE
                ");
                $stmt->execute([$id]);
            }
            
            // Verificar stock disponible
            $stmt = $pdo->prepare("SELECT stock FROM productos WHERE id = ?");
            $stmt->execute([$origen_id]);
            $stock_origen = $stmt->fetchColumn();
            
            if ($stock_origen < $cantidad) {
                throw new Exception("Stock insuficiente");
            }
            
            // Realizar la transferencia
            $stmt = $pdo->prepare("
                UPDATE productos 
                SET stock = stock - ? 
                WHERE id = ?
            ");
            $stmt->execute([$cantidad, $origen_id]);
            
            $stmt = $pdo->prepare("
                UPDATE productos 
                SET stock = stock + ? 
                WHERE id = ?
            ");
            $stmt->execute([$cantidad, $destino_id]);
            
            return true;
        });
    }
}

// Ejemplo de uso
$dm = new DeadlockManager($pdo);

try {
    $dm->transferirStock(1, 2, 5);
    echo "Transferencia exitosa<br>";
} catch (Exception $e) {
    echo "Error en la transferencia: " . $e->getMessage();
}
?>