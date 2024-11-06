<?php
function busquedaAvanzada($pdo, array $criterios) {
    $qb = new QueryBuilder($pdo);
    $qb->table('productos p')
       ->select('p.*', 'c.nombre as categoria')
       ->join('categorias c', 'p.categoria_id', '=', 'c.id');

    // Aplicar filtros dinámicamente
    if (isset($criterios['nombre'])) {
        $qb->where('p.nombre', 'LIKE', '%' . $criterios['nombre'] . '%');
    }

    if (isset($criterios['precio_min'])) {
        $qb->where('p.precio', '>=', $criterios['precio_min']);
    }

    if (isset($criterios['precio_max'])) {
        $qb->where('p.precio', '<=', $criterios['precio_max']);
    }

    if (isset($criterios['categorias']) && is_array($criterios['categorias'])) {
        $qb->whereIn('c.id', $criterios['categorias']);
    }

    if (isset($criterios['ordenar_por'])) {
        $qb->orderBy($criterios['ordenar_por'], $criterios['orden'] ?? 'ASC');
    }

    if (isset($criterios['limite'])) {
        $qb->limit($criterios['limite'], $criterios['offset'] ?? 0);
    }

    return $qb->execute();
}

// Ejemplo de uso
$criterios = [
    'nombre' => 'laptop',
    'precio_min' => 500,
    'precio_max' => 2000,
    'categorias' => [1, 2],
    'ordenar_por' => 'p.precio',
    'orden' => 'DESC',
    'limite' => 10
];

$resultados = busquedaAvanzada($pdo, $criterios);
?>