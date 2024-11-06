
<?php
class Paginator {
    protected $pdo;
    protected $table;
    protected $perPage;
    protected $currentPage;
    protected $totalRecords;
    protected $conditions = [];
    protected $params = [];
    protected $orderBy = '';
    protected $joins = [];
    protected $fields = ['*'];

    public function __construct(PDO $pdo, $table, $perPage = 10) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->perPage = $perPage;
        $this->currentPage = 1;
    }

    public function select($fields) {
        $this->fields = is_array($fields) ? $fields : func_get_args();
        return $this;
    }

    public function where($condition, $params = []) {
        $this->conditions[] = $condition;
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    public function join($join) {
        $this->joins[] = $join;
        return $this;
    }

    public function orderBy($orderBy) {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function setPage($page) {
        $this->currentPage = max(1, (int)$page);
        return $this;
    }

    public function getTotalRecords() {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        
        if (!empty($this->joins)) {
            $sql .= " " . implode(" ", $this->joins);
        }
        
        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(" AND ", $this->conditions);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->fetchColumn();
    }

    public function getResults() {
        $offset = ($this->currentPage - 1) * $this->perPage;
        
        $sql = "SELECT " . implode(", ", $this->fields) . " FROM {$this->table}";
        
        if (!empty($this->joins)) {
            $sql .= " " . implode(" ", $this->joins);
        }
        
        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(" AND ", $this->conditions);
        }
        
        if ($this->orderBy) {
            $sql .= " ORDER BY {$this->orderBy}";
        }
        
        $sql .= " LIMIT {$this->perPage} OFFSET {$offset}";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPageInfo() {
        $totalRecords = $this->getTotalRecords();
        $totalPages = ceil($totalRecords / $this->perPage);

        return [
            'current_page' => $this->currentPage,
            'per_page' => $this->perPage,
            'total_records' => $totalRecords,
            'total_pages' => $totalPages,
            'has_previous' => $this->currentPage > 1,
            'has_next' => $this->currentPage < $totalPages,
            'previous_page' => $this->currentPage - 1,
            'next_page' => $this->currentPage + 1,
            'first_page' => 1,
            'last_page' => $totalPages,
        ];
    }
}

// Clase para paginación con cursor (más eficiente para grandes conjuntos de datos)
class CursorPaginator extends Paginator {
    private $cursorField;
    private $cursorValue;
    private $direction;

    public function __construct(PDO $pdo, $table, $cursorField, $perPage = 10) {
        parent::__construct($pdo, $table, $perPage);
        $this->cursorField = $cursorField;
    }

    public function setCursor($value, $direction = 'next') {
        $this->cursorValue = $value;
        $this->direction = $direction;
        return $this;
    }

    public function getResults() {
        $sql = "SELECT " . implode(", ", $this->fields) . " FROM {$this->table}";
        
        if (!empty($this->joins)) {
            $sql .= " " . implode(" ", $this->joins);
        }
        
        $conditions = $this->conditions;
        if ($this->cursorValue !== null) {
            $operator = $this->direction === 'next' ? '>' : '<';
            $conditions[] = "{$this->cursorField} {$operator} :cursor";
            $this->params[':cursor'] = $this->cursorValue;
        }
        
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        
        if ($this->orderBy) {
            $sql .= " ORDER BY {$this->orderBy}";
        } else {
            $direction = $this->direction === 'next' ? 'ASC' : 'DESC';
            $sql .= " ORDER BY {$this->cursorField} {$direction}";
        }
        
        $sql .= " LIMIT " . ($this->perPage + 1); // +1 para saber si hay más páginas

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $hasMore = count($results) > $this->perPage;
        if ($hasMore) {
            array_pop($results);
        }

        return [
            'results' => $results,
            'has_more' => $hasMore,
            'next_cursor' => $hasMore ? end($results)[$this->cursorField] : null
        ];
    }
}

// Ejemplo de uso del paginador tradicional:
$paginator = new Paginator($pdo, 'productos');
$paginator->select('productos.*', 'categorias.nombre as categoria')
         ->join('LEFT JOIN categorias ON productos.categoria_id = categorias.id')
         ->where('productos.precio >= ?', [100])
         ->orderBy('productos.nombre ASC')
         ->setPage(isset($_GET['page']) ? $_GET['page'] : 1);

$results = $paginator->getResults();
$pageInfo = $paginator->getPageInfo();

// Ejemplo de uso del paginador con cursor:
$cursorPaginator = new CursorPaginator($pdo, 'productos', 'id');
$cursorPaginator->select('*')
                ->where('precio >= ?', [100])
                ->setCursor(isset($_GET['cursor']) ? $_GET['cursor'] : null);

$cursorResults = $cursorPaginator->getResults();
?>

<!-- Ejemplo de HTML para mostrar la paginación -->
<!DOCTYPE html>
<html>
<head>
    <title>Productos Paginados</title>
    <style>
        .pagination {
            margin: 20px 0;
            padding: 0;
            list-style: none;
            display: flex;
            gap: 10px;
        }
        .pagination li {
            padding: 5px 10px;
            border: 1px solid #ddd;
            cursor: pointer;
        }
        .pagination li.active {
            background-color: #007bff;
            color: white;
        }
        .pagination li.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .results {
            margin-bottom: 20px;
        }
        .results table {
            width: 100%;
            border-collapse: collapse;
        }
        .results th, .results td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="results">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nombre']) ?></td>
                    <td>$<?= number_format($row['precio'], 2) ?></td>
                    <td><?= htmlspecialchars($row['categoria']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <ul class="pagination">
        <?php if ($pageInfo['has_previous']): ?>
        <li><a href="?page=1">Primera</a></li>
        <li><a href="?page=<?= $pageInfo['previous_page'] ?>">Anterior</a></li>
        <?php else: ?>
        <li class="disabled">Primera</li>
        <li class="disabled">Anterior</li>
        <?php endif; ?>

        <li class="active"><?= $pageInfo['current_page'] ?></li>

        <?php if ($pageInfo['has_next']): ?>
        <li><a href="?page=<?= $pageInfo['next_page'] ?>">Siguiente</a></li>
        <li><a href="?page=<?= $pageInfo['last_page'] ?>">Última</a></li>
        <?php else: ?>
        <li class="disabled">Siguiente</li>
        <li class="disabled">Última</li>
        <?php endif; ?>
    </ul>
</body>
</html>