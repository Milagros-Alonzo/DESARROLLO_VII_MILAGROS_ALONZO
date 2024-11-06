
<?php
// 1. Crear un string JSON con datos de una tienda en línea
$jsonDatos = '
{
    "tienda": "ElectroTech",
    "productos": [
        {"id": 1, "nombre": "Laptop Gamer", "precio": 1200, "categorias": ["electrónica", "computadoras"]},
        {"id": 2, "nombre": "Smartphone 5G", "precio": 800, "categorias": ["electrónica", "celulares"]},
        {"id": 3, "nombre": "Auriculares Bluetooth", "precio": 150, "categorias": ["electrónica", "accesorios"]},
        {"id": 4, "nombre": "Smart TV 4K", "precio": 700, "categorias": ["electrónica", "televisores"]},
        {"id": 5, "nombre": "Tablet", "precio": 300, "categorias": ["electrónica", "computadoras"]}
    ],
    "clientes": [
        {"id": 101, "nombre": "Ana López", "email": "ana@example.com"},
        {"id": 102, "nombre": "Carlos Gómez", "email": "carlos@example.com"},
        {"id": 103, "nombre": "María Rodríguez", "email": "maria@example.com"}
    ]
}
';

// 2. Convertir el JSON a un arreglo asociativo de PHP
$tiendaData = json_decode($jsonDatos, true);

// 3. Función para imprimir los productos
function imprimirProductos($productos) {
    foreach ($productos as $producto) {
        echo "{$producto['nombre']} - ${$producto['precio']} - Categorías: " . implode(", ", $producto['categorias']) . "\n";
    }
}

echo "Productos de {$tiendaData['tienda']}:\n";
imprimirProductos($tiendaData['productos']);

// 4. Calcular el valor total del inventario
$valorTotal = array_reduce($tiendaData['productos'], function($total, $producto) {
    return $total + $producto['precio'];
}, 0);

echo "\nValor total del inventario: $$valorTotal\n";

// 5. Encontrar el producto más caro
$productoMasCaro = array_reduce($tiendaData['productos'], function($max, $producto) {
    return ($producto['precio'] > $max['precio']) ? $producto : $max;
}, $tiendaData['productos'][0]);

echo "\nProducto más caro: {$productoMasCaro['nombre']} (${$productoMasCaro['precio']})\n";

// 6. Filtrar productos por categoría
function filtrarPorCategoria($productos, $categoria) {
    return array_filter($productos, function($producto) use ($categoria) {
        return in_array($categoria, $producto['categorias']);
    });
}

$productosDeComputadoras = filtrarPorCategoria($tiendaData['productos'], "computadoras");
echo "\nProductos en la categoría 'computadoras':\n";
imprimirProductos($productosDeComputadoras);

// 7. Agregar un nuevo producto
$nuevoProducto = [
    "id" => 6,
    "nombre" => "Smartwatch",
    "precio" => 250,
    "categorias" => ["electrónica", "accesorios", "wearables"]
];
$tiendaData['productos'][] = $nuevoProducto;

// 8. Convertir el arreglo actualizado de vuelta a JSON
$jsonActualizado = json_encode($tiendaData, JSON_PRETTY_PRINT);
echo "\nDatos actualizados de la tienda (JSON):\n$jsonActualizado\n";

// TAREA: Implementa una función que genere un resumen de ventas
// Crea un arreglo de ventas (producto_id, cliente_id, cantidad, fecha)
// y genera un informe que muestre:
// - Total de ventas
// - Producto más vendido
// - Cliente que más ha comprado
// Tu código aquí
function generarResumenVentas($ventas, $productos, $clientes) {
    $resumen = [
        "total_ventas" => 0,
        "producto_mas_vendido" => null,
        "cliente_mayor_comprador" => null
    ];
    
    $ventasPorProducto = [];
    $ventasPorCliente = [];
    
    foreach ($ventas as $venta) {
       
        $resumen["total_ventas"] += $venta["cantidad"];
        

        if (!isset($ventasPorProducto[$venta["producto_id"]])) {
            $ventasPorProducto[$venta["producto_id"]] = 0;
        }
        $ventasPorProducto[$venta["producto_id"]] += $venta["cantidad"];
        
        
        if (!isset($ventasPorCliente[$venta["cliente_id"]])) {
            $ventasPorCliente[$venta["cliente_id"]] = 0;
        }
        $ventasPorCliente[$venta["cliente_id"]] += $venta["cantidad"];
    }
    

    $idProductoMasVendido = array_keys($ventasPorProducto, max($ventasPorProducto))[0];
    $productoMasVendido = array_filter($productos, function($producto) use ($idProductoMasVendido) {
        return $producto["id"] == $idProductoMasVendido;
    });
    $resumen["producto_mas_vendido"] = reset($productoMasVendido)["nombre"];
    
    $idClienteMayorComprador = array_keys($ventasPorCliente, max($ventasPorCliente))[0];
    $clienteMayorComprador = array_filter($clientes, function($cliente) use ($idClienteMayorComprador) {
        return $cliente["id"] == $idClienteMayorComprador;
    });
    $resumen["cliente_mayor_comprador"] = reset($clienteMayorComprador)["nombre"];
    
    return $resumen;
}

$resumenVentas = generarResumenVentas($ventas, $tiendaData['productos'], $tiendaData['clientes']);

echo "Resumen de Ventas:";
echo "Total de ventas: {$resumenVentas['total_ventas']} productos vendidos";
echo "Producto más vendido: {$resumenVentas['producto_mas_vendido']}";
echo "Cliente que más ha comprado: {$resumenVentas['cliente_mayor_comprador']}";
?>
    