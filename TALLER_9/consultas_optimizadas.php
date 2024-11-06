<?php
require_once "config_pdo.php";

class ConsultasOptimizadas {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Consulta optimizada usando índices
    public function buscarProductos($categoria_id, $precio_min, $precio_max) {
        $sql = "SELECT p.id, p.nombre, p.precio, p.stock
                FROM productos p
                USE INDEX (idx_productos_categoria, idx_productos_precio)
                WHERE p.categoria_id = :categoria_id
                AND p.precio BETWEEN :precio_min AND :precio_max
                AND p.stock > 0";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':categoria_id' => $categoria_id,
            ':precio_min' => $precio_min,
            ':precio_max' => $precio_max
        ]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Consulta paginada optimizada
    public function listarVentas($pagina = 1, $por_pagina = 10) {
        $offset = ($pagina - 1) * $por_pagina;
        
        $sql = "SELECT SQL_CALC_FOUND_ROWS 
                    v.id, v.fecha_venta, v.total,
                    c.nombre as cliente
                FROM ventas v
                USE INDEX (idx_ventas_fecha)
                JOIN clientes c ON v.cliente_id = c.id
                ORDER BY v.fecha_venta DESC
                LIMIT :offset, :limit";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
        $stmt->execute();
        
        $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Obtener el total de registros
        $total = $this->pdo->query("SELECT FOUND_ROWS()")->fetchColumn();
        
        return [
            'ventas' => $ventas,
            'total' => $total,
            'paginas' => ceil($total / $por_pagina)
        ];
    }
    
    // Búsqueda de texto optimizada
    public function buscarProductosTexto($termino) {
        $sql = "SELECT p.*, 
                MATCH(p.nombre, p.descripcion) AGAINST(:termino IN NATURAL LANGUAGE MODE) as relevancia
                FROM productos p
                WHERE MATCH(p.nombre, p.descripcion) AGAINST(:termino IN NATURAL LANGUAGE MODE)
                ORDER BY relevancia DESC";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':termino' => $termino]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Reporte optimizado con agrupación
    public function reporteVentasPorCategoria($fecha_inicio, $fecha_fin) {
        $sql = "SELECT 
                    c.nombre as categoria,
                    COUNT(DISTINCT v.id) as total_ventas,
                    SUM(dv.cantidad) as productos_vendidos,
                    SUM(dv.subtotal) as total_ingresos
                FROM categorias c
                JOIN productos p ON p.categoria_id = c.id
                JOIN detalles_venta dv ON dv.producto_id = p.id
                JOIN ventas v ON v.id = dv.venta_id
                WHERE v.fecha_venta BETWEEN :fecha_inicio AND :fecha_fin
                GROUP BY c.id, c.nombre
                WITH ROLLUP";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_fin' => $fecha_fin
        ]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Ejemplo de uso
$consultas = new ConsultasOptimizadas($pdo);

// Buscar productos
$productos = $consultas->buscarProductos(1, 100, 500);
echo "<h3>Productos encontrados:</h3>";
print_r($productos);

// Listar ventas paginadas
$resultado = $consultas->listarVentas(1, 10);
echo "<h3>Ventas (Página 1):</h3>";
print_r($resultado);

// Buscar productos por texto
$resultados = $consultas->buscarProductosTexto("laptop");
echo "<h3>Búsqueda de productos:</h3>";
print_r($resultados);

// Reporte de ventas
$reporte = $consultas->reporteVentasPorCategoria('2023-01-01', '2023-12-31');
echo "<h3>Reporte de ventas por categoría:</h3>";
print_r($reporte);

$pdo = null;
?>