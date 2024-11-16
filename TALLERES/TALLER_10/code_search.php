<?php
require_once 'config.php';
require_once 'SearchManager.php';

$searchManager = new SearchManager($github);

$query = $_GET['q'] ?? '';
$language = $_GET['language'] ?? '';
$extension = $_GET['extension'] ?? '';

$results = [];
$error = null;

if (!empty($query)) {
    try {
        $searchQuery = $query;
        if ($language) {
            $searchQuery .= " language:$language";
        }
        if ($extension) {
            $searchQuery .= " extension:$extension";
        }
        
        $results = $searchManager->searchCode($searchQuery);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Búsqueda de Código en GitHub</title>
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .search-form { margin-bottom: 20px; }
        .code-result { margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; }
        .file-info { font-size: 0.9em; color: #666; margin-bottom: 10px; }
        .error { color: red; padding: 10px; background: #fee; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Búsqueda de Código en GitHub</h1>
        
        <form class="search-form" method="GET">
            <div>
                <label for="q">Buscar código:</label>
                <input type="text" id="q" name="q" value="<?= htmlspecialchars($query) ?>" required>
            </div>
            
            <div>
                <label for="language">Lenguaje:</label>
                <input type="text" id="language" name="language" 
                       value="<?= htmlspecialchars($language) ?>">
            </div>
            
            <div>
                <label for="extension">Extensión del archivo:</label>
                <input type="text" id="extension" name="extension" 
                       value="<?= htmlspecialchars($extension) ?>">
            </div>
            
            <button type="submit">Buscar</button>
        </form>
        
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if (!empty($results)): ?>
            <div class="results">
                <h2>Resultados (Total: <?= $results['total_count'] ?>)</h2>
                
                <?php foreach ($results['items'] as $item): ?>
                    <div class="code-result">
                        <div class="file-info">
                            <strong>Repositorio:</strong> 
                            <a href="<?= htmlspecialchars($item['repository']['html_url']) ?>" 
                               target="_blank">
                                <?= htmlspecialchars($item['repository']['full_name']) ?>
                            </a>
                        </div>
                        
                        <div class="file-info">
                            <strong>Archivo:</strong> 
                            <a href="<?= htmlspecialchars($item['html_url']) ?>" target="_blank">
                                <?= htmlspecialchars($item['path']) ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
        